<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class SalesReportController extends Controller
{
    public function index(Request $request)
    {
        // ── Date range ────────────────────────────────────────────────────────
        $period    = $request->get('period', 'this_month');
        $dateFrom  = $request->get('date_from');
        $dateTo    = $request->get('date_to');

        [$from, $to] = $this->resolveDateRange($period, $dateFrom, $dateTo);

        // ── Base query: only completed/shipped = settled ──────────────────────
        $base = Order::whereBetween('created_at', [$from->startOfDay(), $to->copy()->endOfDay()])
            ->where('status', 'completed');

        // ── Summary cards ─────────────────────────────────────────────────────
        $summary = [
            'total_revenue'  => (clone $base)->sum('total'),
            'total_orders'   => (clone $base)->count(),
            'total_items'    => OrderItem::whereHas('order', fn($q) => $q
                ->whereBetween('created_at', [$from->startOfDay(), $to->copy()->endOfDay()])
                ->where('status', 'completed')
            )->sum('quantity'),
            'avg_order'      => (clone $base)->avg('total') ?? 0,
            'total_shipping' => (clone $base)->sum('shipping'),
            'total_discount' => (clone $base)->sum('discount'),
        ];

        // ── Orders table ──────────────────────────────────────────────────────
        $orders = (clone $base)->with(['items', 'paymentMethod'])
            ->latest()
            ->paginate(20)
            ->withQueryString();

        // ── Daily chart data ──────────────────────────────────────────────────
        $days = $from->diffInDays($to) + 1;
        $chartData = collect(range(0, min($days - 1, 29)))->map(function ($i) use ($from) {
            $date = $from->copy()->addDays($i);
            $rev  = Order::whereDate('created_at', $date)->where('status', 'completed')->sum('total');
            return ['label' => $date->format('d M'), 'revenue' => (float) $rev];
        });

        // ── Top products ──────────────────────────────────────────────────────
        $topProducts = OrderItem::selectRaw('product_name, SUM(quantity) as total_qty, SUM(subtotal) as total_rev')
            ->whereHas('order', fn($q) => $q
                ->whereBetween('created_at', [$from->startOfDay(), $to->copy()->endOfDay()])
                ->where('status', 'completed')
            )
            ->groupBy('product_name')
            ->orderByDesc('total_rev')
            ->limit(5)
            ->get();

        // ── Export CSV ────────────────────────────────────────────────────────
        if ($request->get('export') === 'csv') {
            return $this->exportCsv($base, $from, $to);
        }

        return view('admin.reports.sales', compact(
            'summary', 'orders', 'chartData', 'topProducts',
            'from', 'to', 'period', 'dateFrom', 'dateTo'
        ));
    }

    // ── Helpers ───────────────────────────────────────────────────────────────

    private function resolveDateRange(string $period, ?string $from, ?string $to): array
    {
        return match ($period) {
            'today'        => [Carbon::today(),        Carbon::today()],
            'yesterday'    => [Carbon::yesterday(),    Carbon::yesterday()],
            'this_week'    => [Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek()],
            'last_week'    => [Carbon::now()->subWeek()->startOfWeek(), Carbon::now()->subWeek()->endOfWeek()],
            'this_month'   => [Carbon::now()->startOfMonth(), Carbon::now()->endOfMonth()],
            'last_month'   => [Carbon::now()->subMonth()->startOfMonth(), Carbon::now()->subMonth()->endOfMonth()],
            'this_year'    => [Carbon::now()->startOfYear(), Carbon::now()->endOfYear()],
            'custom'       => [Carbon::parse($from ?? now()->startOfMonth()), Carbon::parse($to ?? now())],
            default        => [Carbon::now()->startOfMonth(), Carbon::now()->endOfMonth()],
        };
    }

    private function exportCsv($query, Carbon $from, Carbon $to)
    {
        $orders = (clone $query)->with('items')->latest()->get();

        $filename = 'settlement_' . $from->format('Ymd') . '_' . $to->format('Ymd') . '.csv';

        $headers = [
            'Content-Type'        => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"{$filename}\"",
        ];

        $callback = function () use ($orders) {
            $handle = fopen('php://output', 'w');
            // BOM for Excel UTF-8
            fputs($handle, "\xEF\xBB\xBF");

            fputcsv($handle, [
                'No. Order', 'Tanggal', 'Customer', 'Email', 'Kota',
                'Subtotal', 'Diskon', 'Ongkir', 'Total',
                'Metode Bayar', 'Status',
            ]);

            foreach ($orders as $order) {
                fputcsv($handle, [
                    $order->order_number,
                    $order->created_at->format('d/m/Y H:i'),
                    $order->customer_name,
                    $order->customer_email,
                    $order->city,
                    $order->subtotal,
                    $order->discount,
                    $order->shipping,
                    $order->total,
                    $order->paymentMethod?->name ?? $order->payment_method,
                    $order->status,
                ]);
            }

            fclose($handle);
        };

        return response()->stream($callback, 200, $headers);
    }
}
