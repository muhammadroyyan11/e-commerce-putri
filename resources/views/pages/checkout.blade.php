@extends('layouts.app')

@section('title', __('messages.checkout.title') . ' - ' . App\Models\Setting::get('site_name', 'GreenHaven'))

@section('content')
<!-- Page Banner -->
<section class="page-banner">
    <div class="container">
        <h1>{{ __('messages.checkout.title') }}</h1>
        <nav class="breadcrumb">
            <a href="{{ route('home') }}">{{ __('messages.common.home') }}</a>
            <span>/</span>
            <span>{{ __('messages.checkout.breadcrumb') }}</span>
        </nav>
    </div>
</section>

<!-- Checkout Section -->
<section style="padding: 40px 0 60px; background: var(--bg-light);">
    <div class="container">
        <!-- Steps -->
        <div class="cart-steps" style="margin-bottom: 40px;">
            <div class="step completed">
                <div class="step-number"><i class="fas fa-check"></i></div>
                <span class="step-label">{{ __('messages.cart.step_cart') }}</span>
            </div>
            <div class="step-line completed"></div>
            <div class="step active">
                <div class="step-number">2</div>
                <span class="step-label">{{ __('messages.checkout.title') }}</span>
            </div>
            <div class="step-line"></div>
            <div class="step">
                <div class="step-number">3</div>
                <span class="step-label">{{ __('messages.cart.step_done') }}</span>
            </div>
        </div>

        <div class="checkout-layout">
            <!-- Form -->
            <div style="flex: 1;">
                <form action="{{ route('checkout.process') }}" method="POST">
                    @csrf
                    
                    <!-- Contact -->
                    <div style="background: white; border-radius: 16px; padding: 30px; margin-bottom: 20px;">
                        <h3 style="font-size: 18px; font-weight: 700; margin-bottom: 24px;"><i class="fas fa-envelope" style="color: var(--primary-color); margin-right: 10px;"></i> {{ __('messages.checkout.contact_info') }}</h3>
                        <div style="margin-bottom: 16px;">
                            <label style="display: block; font-size: 14px; font-weight: 500; margin-bottom: 8px;">{{ __('messages.header.email') }} *</label>
                            <input type="email" name="email" required style="width: 100%; padding: 14px 16px; border: 1px solid var(--border-color); border-radius: 12px;">
                        </div>
                    </div>

                    <!-- Shipping Address -->
                    <div style="background: white; border-radius: 16px; padding: 30px; margin-bottom: 20px;">
                        <h3 style="font-size: 18px; font-weight: 700; margin-bottom: 24px;"><i class="fas fa-shipping-fast" style="color: var(--primary-color); margin-right: 10px;"></i> {{ __('messages.checkout.shipping_address') }}</h3>
                        <div class="grid-2-col" style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px; margin-bottom: 16px;">
                            <div>
                                <label style="display: block; font-size: 14px; font-weight: 500; margin-bottom: 8px;">{{ __('messages.checkout.first_name') }} *</label>
                                <input type="text" name="first_name" required style="width: 100%; padding: 14px 16px; border: 1px solid var(--border-color); border-radius: 12px;">
                            </div>
                            <div>
                                <label style="display: block; font-size: 14px; font-weight: 500; margin-bottom: 8px;">{{ __('messages.checkout.last_name') }} *</label>
                                <input type="text" name="last_name" required style="width: 100%; padding: 14px 16px; border: 1px solid var(--border-color); border-radius: 12px;">
                            </div>
                        </div>
                        <div style="margin-bottom: 16px;">
                            <label style="display: block; font-size: 14px; font-weight: 500; margin-bottom: 8px;">{{ __('messages.checkout.address') }} *</label>
                            <input type="text" name="address" required style="width: 100%; padding: 14px 16px; border: 1px solid var(--border-color); border-radius: 12px;">
                        </div>
                        <div class="grid-3-col" style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 16px; margin-bottom: 16px;">
                            <div>
                                <label style="display: block; font-size: 14px; font-weight: 500; margin-bottom: 8px;">{{ __('messages.checkout.city') }} *</label>
                                <input type="text" name="city" required style="width: 100%; padding: 14px 16px; border: 1px solid var(--border-color); border-radius: 12px;">
                            </div>
                            <div>
                                <label style="display: block; font-size: 14px; font-weight: 500; margin-bottom: 8px;">{{ __('messages.checkout.province') }} *</label>
                                <select name="province" required style="width: 100%; padding: 14px 16px; border: 1px solid var(--border-color); border-radius: 12px;">
                                    <option value="">{{ __('messages.common.all') }}</option>
                                    <option value="Jakarta">DKI Jakarta</option>
                                    <option value="Jabar">Jawa Barat</option>
                                    <option value="Jateng">Jawa Tengah</option>
                                    <option value="Jatim">Jawa Timur</option>
                                </select>
                            </div>
                            <div>
                                <label style="display: block; font-size: 14px; font-weight: 500; margin-bottom: 8px;">{{ __('messages.checkout.postal_code') }} *</label>
                                <input type="text" name="postal_code" required style="width: 100%; padding: 14px 16px; border: 1px solid var(--border-color); border-radius: 12px;">
                            </div>
                        </div>
                        <div>
                            <label style="display: block; font-size: 14px; font-weight: 500; margin-bottom: 8px;">{{ __('messages.checkout.phone') }} *</label>
                            <input type="tel" name="phone" required style="width: 100%; padding: 14px 16px; border: 1px solid var(--border-color); border-radius: 12px;">
                        </div>
                    </div>

                    <!-- Payment -->
                    <div style="background: white; border-radius: 16px; padding: 30px; margin-bottom: 20px;">
                        <h3 style="font-size: 18px; font-weight: 700; margin-bottom: 24px;"><i class="fas fa-credit-card" style="color: var(--primary-color); margin-right: 10px;"></i> {{ __('messages.checkout.payment') }}</h3>
                        <div style="display: flex; flex-direction: column; gap: 12px;">
                            @forelse($paymentMethods as $index => $method)
                            <label style="display: flex; align-items: center; gap: 12px; padding: 14px 18px; background: var(--bg-light); border-radius: 10px; cursor: pointer; border: 1px solid transparent;">
                                <input type="radio" name="payment_method_id" value="{{ $method->id }}" {{ $index === 0 ? 'checked' : '' }} style="accent-color: var(--primary-color);">
                                @if($method->logo)
                                    <img src="{{ asset('storage/' . $method->logo) }}" alt="{{ $method->name }}" style="height: 28px; border-radius: 4px; background: #fff; padding: 2px; border: 1px solid #e5e7eb;">
                                @endif
                                <div>
                                    <div style="font-weight: 600;">{{ $method->name }}</div>
                                    <div style="font-size: 13px; color: var(--text-medium);">{{ $method->account_number }} a.n. {{ $method->account_name }}</div>
                                </div>
                            </label>
                            @empty
                            <p style="font-size: 14px; color: var(--text-medium);">{{ __('messages.checkout.select_payment') }}</p>
                            @endforelse
                        </div>
                    </div>

                    <button type="submit" style="width: 100%; padding: 18px; background: var(--gradient-primary); color: white; border-radius: 12px; font-weight: 600; font-size: 16px; border: none; cursor: pointer;">{{ __('messages.button.order_now') }}</button>
                </form>
            </div>

            <!-- Summary -->
            <div class="checkout-sidebar" style="width: 420px;">
                <div style="background: white; border-radius: 16px; padding: 30px; position: sticky; top: 92px;">
                    <h3 style="font-size: 18px; font-weight: 700; margin-bottom: 24px;">{{ __('messages.checkout.order_summary') }}</h3>
                    
                    @foreach($cartItems as $item)
                    <div style="display: flex; align-items: center; gap: 16px; margin-bottom: 16px; padding-bottom: 16px; border-bottom: 1px solid var(--border-color);">
                        <div style="position: relative;">
                            <img src="{{ $item['image'] }}" alt="{{ $item['name'] }}" style="width: 60px; height: 60px; border-radius: 10px; object-fit: cover;">
                            <span style="position: absolute; top: -8px; right: -8px; width: 22px; height: 22px; background: var(--text-dark); color: white; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 11px; font-weight: 600;">{{ $item['quantity'] }}</span>
                        </div>
                        <div style="flex: 1;">
                            <h4 style="font-size: 14px; font-weight: 600;">{{ $item['name'] }}</h4>
                            <p style="font-size: 12px; color: var(--text-light);">{{ $item['variant'] }}</p>
                        </div>
                        <span style="font-weight: 600; font-size: 14px;">Rp {{ number_format($item['price'] * $item['quantity'], 0, ',', '.') }}</span>
                    </div>
                    @endforeach

                    <div style="margin-top: 20px; padding-top: 20px; border-top: 2px solid var(--border-color);">
                        <div style="display: flex; justify-content: space-between; margin-bottom: 12px; font-size: 14px;">
                            <span>{{ __('messages.cart.subtotal') }}</span>
                            <span>Rp {{ number_format($summary['subtotal'], 0, ',', '.') }}</span>
                        </div>
                        <div style="display: flex; justify-content: space-between; margin-bottom: 12px; font-size: 14px;">
                            <span>{{ __('messages.cart.shipping') }}</span>
                            <span style="color: var(--success-color);">{{ __('messages.cart.free_shipping') }}</span>
                        </div>
                        <div style="display: flex; justify-content: space-between; padding-top: 12px; border-top: 1px solid var(--border-color);">
                            <span style="font-size: 16px; font-weight: 700;">{{ __('messages.cart.total') }}</span>
                            <div style="text-align: right;">
                                <span style="font-size: 24px; font-weight: 700; color: var(--primary-dark);">Rp {{ number_format($summary['total'], 0, ',', '.') }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
