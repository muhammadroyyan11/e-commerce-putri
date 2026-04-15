@extends('layouts.app')

@section('title', __('messages.order.success_title') . ' - ' . App\Models\Setting::get('site_name', 'GreenHaven'))

@section('content')
<div style="min-height: 80vh; display: flex; align-items: center; justify-content: center; padding: 60px 20px; background: var(--bg-light);">
    <div style="background: white; border-radius: 30px; padding: 60px; text-align: center; max-width: 600px; width: 100%; box-shadow: var(--shadow-lg);">
        <div style="width: 120px; height: 120px; background: var(--gradient-primary); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 30px; font-size: 56px; color: white; animation: scaleIn 0.6s ease; box-shadow: 0 20px 40px rgba(16, 185, 129, 0.3);">
            <i class="fas fa-check"></i>
        </div>
        <h1 style="font-size: 32px; font-weight: 700; margin-bottom: 16px; color: var(--text-dark);">{{ __('messages.order.success_title') }}</h1>
        <p style="color: var(--text-medium); margin-bottom: 30px; font-size: 16px;">{{ __('messages.order.success_desc', ['site' => App\Models\Setting::get('site_name', 'GreenHaven')]) }}</p>
        
        <div style="background: var(--bg-light); border-radius: 20px; padding: 30px; margin-bottom: 30px; text-align: left;">
            <div style="display: flex; justify-content: space-between; margin-bottom: 14px; font-size: 15px;">
                <span>{{ __('messages.order.order_number') }}</span>
                <strong style="color: var(--primary-color);">{{ $order['number'] }}</strong>
            </div>
            <div style="display: flex; justify-content: space-between; margin-bottom: 14px; font-size: 15px;">
                <span>{{ __('messages.order.order_date') }}</span>
                <span>{{ $order['date'] }}</span>
            </div>
            <div style="display: flex; justify-content: space-between; margin-bottom: 14px; font-size: 15px;">
                <span>{{ __('messages.order.payment_method') }}</span>
                <span>{{ $order['payment_method'] }}</span>
            </div>
            <div style="display: flex; justify-content: space-between; padding-top: 14px; border-top: 2px solid var(--border-color); font-weight: 700; font-size: 18px; color: var(--text-dark);">
                <span>{{ __('messages.order.total_payment') }}</span>
                <strong>Rp {{ number_format($order['total'], 0, ',', '.') }}</strong>
            </div>
        </div>

        <div style="background: var(--primary-lighter); border-radius: 12px; padding: 20px; margin-bottom: 30px;">
            <p style="font-size: 14px; color: var(--text-medium); margin: 0;">
                <i class="fas fa-info-circle" style="color: var(--primary-color); margin-right: 8px;"></i>
                {{ __('messages.order.email_info') }}
            </p>
        </div>

        @if(session('success'))
        <div class="alert alert-success" style="margin-bottom: 24px; border-radius: 12px;">
            {{ session('success') }}
        </div>
        @endif

        <div style="display: flex; gap: 16px; justify-content: center; flex-wrap: wrap;">
            <a href="{{ route('shop') }}" style="padding: 16px 36px; background: var(--gradient-primary); color: white; border-radius: 12px; font-weight: 600; text-decoration: none; display: inline-flex; align-items: center; gap: 10px;"><i class="fas fa-shopping-bag"></i> {{ __('messages.order.shop_again') }}</a>
            <a href="{{ route('customer.orders.index') }}" style="padding: 16px 36px; background: white; color: #14532d; border: 2px solid #86efac; border-radius: 12px; font-weight: 600; text-decoration: none; display: inline-flex; align-items: center; gap: 10px;"><i class="fas fa-box"></i> {{ __('messages.order.history') }}</a>
            @if(!empty($order['id']))
            <a href="{{ route('payment-confirmation.create', $order['id']) }}" style="padding: 16px 36px; background: #fff7ed; color: #c2410c; border: 2px solid #fdba74; border-radius: 12px; font-weight: 600; text-decoration: none; display: inline-flex; align-items: center; gap: 10px;"><i class="fas fa-money-bill-wave"></i> {{ __('messages.order.confirm_payment') }}</a>
            @endif
        </div>
    </div>
</div>

<style>
@keyframes scaleIn {
    0% { transform: scale(0); opacity: 0; }
    50% { transform: scale(1.1); }
    100% { transform: scale(1); opacity: 1; }
}
</style>
@endsection
