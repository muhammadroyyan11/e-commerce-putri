<?php

namespace App\Services;

use App\Models\Order;
use Illuminate\Support\Facades\Http;

class MidtransService
{
    private string $serverKey;
    private string $baseUrl;

    public function __construct()
    {
        $this->serverKey = config('services.midtrans.server_key');
        $this->baseUrl   = config('services.midtrans.is_production')
            ? 'https://api.midtrans.com/v2'
            : 'https://api.sandbox.midtrans.com/v2';
    }

    private function http()
    {
        return Http::withBasicAuth($this->serverKey, '')
            ->acceptJson()
            ->asJson();
    }

    public function charge(Order $order, string $paymentType, array $extra = []): array
    {
        $payload = [
            'payment_type'       => $paymentType,
            'transaction_details' => [
                'order_id'     => $order->order_number,
                'gross_amount' => (int) $order->total,
            ],
            'customer_details' => [
                'first_name' => $order->customer_name,
                'email'      => $order->customer_email,
                'phone'      => $order->customer_phone,
            ],
        ];

        $payload = array_merge($payload, $extra);

        $response = $this->http()->post("{$this->baseUrl}/charge", $payload);

        return $response->json();
    }

    public function chargeVA(Order $order, string $bank): array
    {
        return $this->charge($order, 'bank_transfer', [
            'bank_transfer' => ['bank' => $bank],
        ]);
    }

    public function chargeGopay(Order $order): array
    {
        return $this->charge($order, 'gopay', [
            'gopay' => ['enable_callback' => false],
        ]);
    }

    public function chargeQris(Order $order): array
    {
        return $this->charge($order, 'qris', [
            'qris' => ['acquirer' => 'gopay'],
        ]);
    }

    public function chargeShopeepay(Order $order): array
    {
        return $this->charge($order, 'shopeepay', [
            'shopeepay' => ['callback_url' => route('customer.orders.show', $order)],
        ]);
    }

    public function chargeAlfamart(Order $order): array
    {
        return $this->charge($order, 'cstore', [
            'cstore' => ['store' => 'alfamart'],
        ]);
    }

    public function chargeIndomaret(Order $order): array
    {
        return $this->charge($order, 'cstore', [
            'cstore' => ['store' => 'indomaret'],
        ]);
    }

    /**
     * Parse charge response and extract VA/QR/code info
     */
    public function parseChargeResult(array $result): array
    {
        $type    = $result['payment_type'] ?? '';
        $vaNumber = null;
        $qrUrl   = null;
        $expiredAt = $result['expiry_time'] ?? now()->addHours(24)->format('Y-m-d H:i:s');

        // Bank Transfer VA
        if ($type === 'bank_transfer') {
            $vaNumbers = $result['va_numbers'] ?? [];
            $vaNumber  = $vaNumbers[0]['va_number'] ?? ($result['permata_va_number'] ?? null);
        }

        // Mandiri Bill
        if ($type === 'echannel') {
            $vaNumber = ($result['biller_code'] ?? '') . ' / ' . ($result['bill_key'] ?? '');
        }

        // GoPay / ShopeePay / QRIS
        if (in_array($type, ['gopay', 'qris', 'shopeepay'])) {
            $actions = $result['actions'] ?? [];
            foreach ($actions as $action) {
                if (($action['name'] ?? '') === 'generate-qr-code') {
                    $qrUrl = $action['url'] ?? null;
                    break;
                }
            }
            // fallback
            if (!$qrUrl) {
                $qrUrl = $result['qr_string'] ?? null;
            }
        }

        // Convenience store
        if ($type === 'cstore') {
            $vaNumber = $result['payment_code'] ?? null;
        }

        return [
            'payment_type'       => $type,
            'payment_token'      => $result['transaction_id'] ?? null,
            'payment_va_number'  => $vaNumber,
            'payment_qr_url'     => $qrUrl,
            'payment_expired_at' => $expiredAt,
        ];
    }

    public function verifySignature(string $orderId, string $statusCode, string $grossAmount, string $signatureKey): bool
    {
        $expected = hash('sha512', $orderId . $statusCode . $grossAmount . $this->serverKey);
        return hash_equals($expected, $signatureKey);
    }
}
