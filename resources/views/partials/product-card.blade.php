<div class="plant-card">
    <div class="plant-image">
        <img src="{{ $product['image'] }}" alt="{{ $product['name'] }}" loading="lazy">
        @if($product['badge'])
        <span class="plant-badge {{ $product['badge'] }}">
            @if($product['badge'] == 'sale') {{ __('messages.shop.discount', ['percent' => $product['discount'] ?? 0]) }}
            @elseif($product['badge'] == 'new') New
            @elseif($product['badge'] == 'rare') Rare
            @else {{ ucfirst($product['badge']) }}
            @endif
        </span>
        @endif
        <div class="plant-overlay">
            <div class="plant-actions">
                <a href="{{ route('product.detail', $product['slug']) }}" class="plant-action-btn" title="{{ __('messages.shop.view_detail') }}">
                    <i class="fas fa-eye"></i>
                </a>
                <form action="{{ route('cart.add') }}" method="POST" style="display:inline;">
                    @csrf
                    <input type="hidden" name="product_id" value="{{ $product['id'] }}">
                    <button type="submit" class="plant-action-btn" title="{{ __('messages.button.add_to_cart') }}">
                        <i class="fas fa-shopping-cart"></i>
                    </button>
                </form>
                @php $inWL = in_array($product['id'], $wishlistIds ?? []); @endphp
                <button type="button" class="plant-action-btn btn-wishlist {{ $inWL ? 'active' : '' }}"
                        data-product-id="{{ $product['id'] }}" title="{{ __('messages.shop.favorite') }}">
                    <i class="{{ $inWL ? 'fas' : 'far' }} fa-heart"></i>
                </button>
            </div>
        </div>
    </div>
    <div class="plant-info">
        <span class="plant-category">{{ $product['category'] }}</span>
        <h3 class="plant-name"><a href="{{ route('product.detail', $product['slug']) }}">{{ $product['name'] }}</a></h3>
        <div class="plant-specs">
            <span><i class="fas fa-ruler-vertical"></i> {{ $product['height'] }}</span>
            <span><i class="fas fa-sun"></i> {{ pval($product['light']) }}</span>
        </div>
        <div class="care-icons">
            <div class="care-icon" data-tooltip="{{ __('messages.shop.watering') }}: {{ pval($product['watering']) }}">💧</div>
            <div class="care-icon" data-tooltip="{{ __('messages.shop.light') }}: {{ pval($product['light']) }}">🌤</div>
            <div class="care-icon" data-tooltip="{{ pval($product['care_level']) }}">✨</div>
        </div>
        <div class="plant-price">
            <span class="current">{{ $currency->format($product['price'], $currentCurrency) }}</span>
            @if($product['original_price'])
            <span class="original">{{ $currency->format($product['original_price'], $currentCurrency) }}</span>
            @endif
        </div>
    </div>
</div>
