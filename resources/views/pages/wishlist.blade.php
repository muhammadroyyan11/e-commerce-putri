@extends('layouts.app')
@section('title', __('messages.wishlist.title') . ' - LongLeaf')

@section('content')
<section class="page-banner">
    <div class="container">
        <h1>{{ __('messages.wishlist.title') }}</h1>
    </div>
</section>

<section style="padding: 40px 0 60px; background: var(--bg-light);">
    <div class="container">
        @if($wishlists->isEmpty())
            <div style="text-align:center; padding:60px 20px; background:white; border-radius:20px;">
                <div style="font-size:64px; margin-bottom:16px;">🌿</div>
                <h3 style="font-size:20px; font-weight:700; margin-bottom:8px;">{{ __('messages.wishlist.empty') }}</h3>
                <p style="color:var(--text-medium); margin-bottom:24px;">{{ __('messages.wishlist.empty_desc') }}</p>
                <a href="{{ route('shop') }}" style="padding:14px 28px; background:var(--gradient-primary); color:white; border-radius:12px; font-weight:600; text-decoration:none;">
                    {{ __('messages.button.shop_now') }}
                </a>
            </div>
        @else
            <div style="display:grid; grid-template-columns:repeat(auto-fill, minmax(240px, 1fr)); gap:24px;">
                @foreach($wishlists as $item)
                @php $product = $item->product; @endphp
                @if($product)
                <div class="plant-card" style="background:white; border-radius:16px; overflow:hidden; box-shadow:0 4px 16px rgba(0,0,0,0.06);">
                    <a href="{{ route('product.detail', $product->slug) }}" style="display:block; position:relative;">
                        <img src="{{ $product->image ?? 'https://via.placeholder.com/400x300' }}" alt="{{ $product->name }}"
                            style="width:100%; height:220px; object-fit:cover;">
                        @if($product->badge)
                        <span style="position:absolute; top:12px; left:12px; background:var(--primary-color); color:white; font-size:11px; font-weight:700; padding:4px 10px; border-radius:20px;">
                            {{ $product->badge }}
                        </span>
                        @endif
                    </a>
                    <div style="padding:16px;">
                        <p style="font-size:12px; color:var(--text-light); margin-bottom:4px;">{{ $product->category?->name }}</p>
                        <h3 style="font-size:15px; font-weight:700; margin-bottom:8px;">
                            <a href="{{ route('product.detail', $product->slug) }}" style="color:var(--text-dark); text-decoration:none;">{{ $product->name }}</a>
                        </h3>
                        <div style="display:flex; justify-content:space-between; align-items:center;">
                            <span style="font-size:16px; font-weight:700; color:var(--primary-dark);">Rp {{ number_format($product->price, 0, ',', '.') }}</span>
                            <button onclick="removeWishlist({{ $product->id }}, this)"
                                style="padding:6px 12px; border:1px solid #fca5a5; background:#fff1f2; color:#dc2626; border-radius:8px; font-size:12px; cursor:pointer;">
                                <i class="fas fa-heart-broken"></i>
                            </button>
                        </div>
                        <a href="{{ route('product.detail', $product->slug) }}"
                            style="display:block; margin-top:12px; padding:10px; text-align:center; background:var(--gradient-primary); color:white; border-radius:10px; font-size:13px; font-weight:600; text-decoration:none;">
                            {{ __('messages.button.add_to_cart') }}
                        </a>
                    </div>
                </div>
                @endif
                @endforeach
            </div>
        @endif
    </div>
</section>
@endsection

@push('scripts')
<script>
function removeWishlist(productId, btn) {
    fetch('{{ route('wishlist.toggle') }}', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
        body: JSON.stringify({ product_id: productId })
    })
    .then(r => r.json())
    .then(data => {
        if (data.success) {
            btn.closest('.plant-card').remove();
            document.getElementById('wishlist-badge').textContent = data.count;
        }
    });
}
</script>
@endpush
