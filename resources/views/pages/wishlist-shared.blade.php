@extends('layouts.app')
@section('title', ($owner->name . (app()->getLocale()==='id' ? "'s Wishlist" : "'s Wishlist")) . ' - ' . App\Models\Setting::get('site_name','LongLeaf'))

@section('content')
<section class="page-banner">
    <div class="container">
        <h1>
            {{ app()->getLocale()==='id' ? 'Wishlist' : 'Wishlist' }}
            <span style="color:#84cc16;">{{ $owner->name }}</span>
        </h1>
        <nav class="breadcrumb">
            <a href="{{ route('home') }}">{{ __('messages.common.home') }}</a>
            <span>/</span>
            <span>Shared Wishlist</span>
        </nav>
    </div>
</section>

<section style="padding:48px 0 80px;background:#fff;">
    <div class="container">
        @if($wishlists->isEmpty())
        <div style="text-align:center;padding:60px 0;color:#9ca3af;">
            <i class="fas fa-heart" style="font-size:48px;margin-bottom:16px;display:block;"></i>
            <p>{{ app()->getLocale()==='id' ? 'Wishlist ini masih kosong.' : 'This wishlist is empty.' }}</p>
        </div>
        @else
        <div class="products-grid" style="display:grid;grid-template-columns:repeat(4,1fr);gap:24px;">
            @foreach($wishlists as $item)
            @if($item->product)
            <div class="plant-card">
                <div class="plant-image" style="height:220px;">
                    <img src="{{ $item->product->image ?? 'https://via.placeholder.com/400x500' }}" alt="{{ $item->product->name }}">
                    <div class="plant-overlay">
                        <div class="plant-actions">
                            <a href="{{ route('product.detail', $item->product->slug) }}" class="plant-action-btn"><i class="fas fa-eye"></i></a>
                        </div>
                    </div>
                </div>
                <div class="plant-info">
                    <span class="plant-category">{{ $item->product->category?->name }}</span>
                    <h3 class="plant-name"><a href="{{ route('product.detail', $item->product->slug) }}">{{ $item->product->name }}</a></h3>
                    <div class="plant-price">
                        <span class="current">{{ $currency->format($item->product->price, $currentCurrency) }}</span>
                        @if($item->product->original_price)
                        <span class="original">{{ $currency->format($item->product->original_price, $currentCurrency) }}</span>
                        @endif
                    </div>
                    <form action="{{ route('cart.add') }}" method="POST" style="margin-top:10px;">
                        @csrf
                        <input type="hidden" name="product_id" value="{{ $item->product->id }}">
                        <button type="submit" style="width:100%;padding:10px;background:var(--gradient-primary);color:white;border:none;border-radius:10px;font-weight:600;cursor:pointer;font-size:13px;">
                            <i class="fas fa-shopping-cart mr-1"></i> {{ __('messages.button.add_to_cart') }}
                        </button>
                    </form>
                </div>
            </div>
            @endif
            @endforeach
        </div>
        @endif
    </div>
</section>
@endsection
