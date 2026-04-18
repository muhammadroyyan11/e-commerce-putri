@extends('layouts.app')

@section('title', __('messages.cart.title') . ' - ' . App\Models\Setting::get('site_name', 'LongLeaf'))

@section('content')
<!-- Page Banner -->
<section class="page-banner">
    <div class="container">
        <h1>{{ __('messages.cart.title') }}</h1>
        <nav class="breadcrumb">
            <a href="{{ route('home') }}">{{ __('messages.common.home') }}</a>
            <span>/</span>
            <span>{{ __('messages.cart.breadcrumb') }}</span>
        </nav>
    </div>
</section>

<!-- Cart Section -->
<section style="padding: 40px 0 60px; background: var(--bg-light);">
    <div class="container">
        <!-- Cart Steps -->
        <div class="cart-steps" style="margin-bottom: 40px;">
            <div class="step active">
                <div class="step-number">1</div>
                <span class="step-label">{{ __('messages.cart.step_cart') }}</span>
            </div>
            <div class="step-line"></div>
            <div class="step">
                <div class="step-number">2</div>
                <span class="step-label">{{ __('messages.cart.step_checkout') }}</span>
            </div>
            <div class="step-line"></div>
            <div class="step">
                <div class="step-number">3</div>
                <span class="step-label">{{ __('messages.cart.step_done') }}</span>
            </div>
        </div>

        <div class="cart-layout">
            <!-- Cart Items -->
            <div class="cart-main">
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px;">
                    <h2 style="font-size: 24px; font-weight: 700;">{{ __('messages.cart.your_cart', ['count' => $summary['item_count']]) }}</h2>
                    <a href="{{ route('shop') }}" style="display: flex; align-items: center; gap: 8px; color: var(--primary-color); font-weight: 500; text-decoration: none;"><i class="fas fa-arrow-left"></i> {{ __('messages.button.continue_shopping') }}</a>
                </div>

                <!-- Cart Table -->
                <div style="background: white; border-radius: 16px; overflow: hidden; box-shadow: var(--shadow-sm);">
                    <div class="cart-table-wrapper">
                    <table style="width: 100%;">
                        <thead>
                            <tr style="background: var(--bg-light);">
                                <th style="padding: 16px 20px; text-align: left; font-size: 13px; text-transform: uppercase; color: var(--text-medium);">{{ __('messages.cart.product') }}</th>
                                <th style="padding: 16px 20px; text-align: left; font-size: 13px; text-transform: uppercase; color: var(--text-medium);">{{ __('messages.cart.price') }}</th>
                                <th style="padding: 16px 20px; text-align: left; font-size: 13px; text-transform: uppercase; color: var(--text-medium);">{{ __('messages.cart.qty') }}</th>
                                <th style="padding: 16px 20px; text-align: left; font-size: 13px; text-transform: uppercase; color: var(--text-medium);">{{ __('messages.cart.total') }}</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($cartItems as $item)
                            <tr>
                                <td style="padding: 20px;">
                                    <div style="display: flex; align-items: center; gap: 16px;">
                                        <img src="{{ $item['image'] }}" alt="{{ $item['name'] }}" style="width: 80px; height: 80px; border-radius: 12px; object-fit: cover;">
                                        <div>
                                            <h4 style="font-size: 15px; font-weight: 600;"><a href="{{ route('product.detail', $item['slug']) }}" style="color: var(--text-dark); text-decoration: none;">{{ $item['name'] }}</a></h4>
                                            <p style="font-size: 13px; color: var(--text-light); margin-bottom: 2px;">{{ __('messages.cart.size') }}: {{ $item['size'] }}</p>
                                            <p style="font-size: 13px; color: var(--text-muted);">{{ __('messages.cart.sku') }}: {{ $item['sku'] }}</p>
                                        </div>
                                    </div>
                                </td>
                                <td style="padding: 20px;">
                                    <span style="font-weight: 600; color: var(--text-dark);">Rp {{ number_format($item['price'], 0, ',', '.') }}</span>
                                </td>
                                <td style="padding: 20px;">
                                    <form action="{{ route('cart.update') }}" method="POST" style="display: flex; border: 1px solid var(--border-color); border-radius: 8px; width: fit-content;">
                                        @csrf
                                        <input type="hidden" name="product_id" value="{{ $item['id'] }}">
                                        <button type="submit" name="action" value="decrease" style="width: 36px; height: 36px; font-size: 16px; color: var(--text-medium); background: none; border: none; cursor: pointer;">-</button>
                                        <input type="number" name="quantity" value="{{ $item['quantity'] }}" min="1" style="width: 50px; text-align: center; border: none; border-left: 1px solid var(--border-color); border-right: 1px solid var(--border-color); font-weight: 600;">
                                        <button type="submit" name="action" value="increase" style="width: 36px; height: 36px; font-size: 16px; color: var(--text-medium); background: none; border: none; cursor: pointer;">+</button>
                                    </form>
                                </td>
                                <td style="padding: 20px;">
                                    <span style="font-weight: 600; color: var(--text-dark);">Rp {{ number_format($item['price'] * $item['quantity'], 0, ',', '.') }}</span>
                                </td>
                                <td style="padding: 20px;">
                                    <form action="{{ route('cart.remove') }}" method="POST" style="display: inline;">
                                        @csrf
                                        <input type="hidden" name="product_id" value="{{ $item['id'] }}">
                                        <button type="submit" style="width: 36px; height: 36px; border-radius: 50%; background: var(--bg-light); color: var(--text-medium); border: none; cursor: pointer;"><i class="fas fa-trash"></i></button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    </div>
                </div>
            </div>

            <!-- Cart Summary -->
            <div class="cart-sidebar" style="width: 380px;">
                <div style="background: white; border-radius: 16px; padding: 24px; box-shadow: var(--shadow-sm);">
                    <h3 style="font-size: 18px; font-weight: 700; margin-bottom: 20px;">{{ __('messages.cart.order_summary') }}</h3>
                    
                    <div style="display: flex; justify-content: space-between; margin-bottom: 12px; font-size: 14px; color: var(--text-medium);">
                        <span>{{ __('messages.cart.subtotal') }}</span>
                        <span style="font-weight: 500;">Rp {{ number_format($summary['subtotal'], 0, ',', '.') }}</span>
                    </div>
                    <div style="display: flex; justify-content: space-between; margin-bottom: 12px; font-size: 14px;">
                        <span>{{ __('messages.cart.discount') }}</span>
                        <span style="color: var(--success-color);">-Rp {{ number_format($summary['discount'], 0, ',', '.') }}</span>
                    </div>
                    <div style="display: flex; justify-content: space-between; margin-bottom: 12px; font-size: 14px; color: var(--text-medium);">
                        <span>{{ __('messages.cart.shipping') }}</span>
                        <span style="color: var(--success-color);">{{ $summary['shipping'] == 0 ? __('messages.cart.free_shipping') : 'Rp ' . number_format($summary['shipping'], 0, ',', '.') }}</span>
                    </div>
                    
                    <div style="height: 1px; background: var(--border-color); margin: 16px 0;"></div>
                    
                    <div style="display: flex; justify-content: space-between; font-size: 18px; font-weight: 700; color: var(--text-dark);">
                        <span>{{ __('messages.cart.total') }}</span>
                        <span style="color: var(--primary-color); font-size: 24px;">Rp {{ number_format($summary['total'], 0, ',', '.') }}</span>
                    </div>

                    <a href="{{ route('checkout') }}" style="display: block; width: 100%; padding: 16px; background: var(--gradient-primary); color: white; border-radius: 12px; font-weight: 600; font-size: 16px; text-align: center; text-decoration: none; margin-top: 24px;">{{ __('messages.button.checkout') }}</a>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- F3: Related products --}}
@if(isset($relatedProducts) && $relatedProducts->count() > 0)
<section style="padding:48px 0 64px;background:#fff;">
    <div class="container">
        <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:28px;">
            <h2 style="font-size:22px;font-weight:800;">
                {{ app()->getLocale()==='id' ? '🌿 Mungkin Kamu Juga Suka' : '🌿 You Might Also Like' }}
            </h2>
            <a href="{{ route('shop') }}" style="color:var(--primary-color);font-weight:600;text-decoration:none;font-size:14px;">
                {{ __('messages.button.view_all') }} →
            </a>
        </div>
        <div style="display:grid;grid-template-columns:repeat(4,1fr);gap:20px;">
            @foreach($relatedProducts as $rp)
            <div class="plant-card">
                <div class="plant-image" style="height:200px;">
                    <img src="{{ $rp['image'] }}" alt="{{ $rp['name'] }}">
                    @if($rp['badge'])
                    <span class="plant-badge badge-{{ $rp['badge'] }}">{{ ucfirst($rp['badge']) }}</span>
                    @endif
                    <div class="plant-overlay">
                        <div class="plant-actions">
                            <a href="{{ route('product.detail', $rp['slug']) }}" class="plant-action-btn"><i class="fas fa-eye"></i></a>
                            <form action="{{ route('cart.add') }}" method="POST" style="display:inline;">
                                @csrf
                                <input type="hidden" name="product_id" value="{{ $rp['id'] }}">
                                <button type="submit" class="plant-action-btn"><i class="fas fa-shopping-cart"></i></button>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="plant-info">
                    <span class="plant-category">{{ $rp['category'] }}</span>
                    <h3 class="plant-name"><a href="{{ route('product.detail', $rp['slug']) }}">{{ $rp['name'] }}</a></h3>
                    <div class="plant-price">
                        <span class="current">{{ $currency->format($rp['price'], $currentCurrency) }}</span>
                        @if($rp['original_price'])
                        <span class="original">{{ $currency->format($rp['original_price'], $currentCurrency) }}</span>
                        @endif
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>
@endif
@endsection
