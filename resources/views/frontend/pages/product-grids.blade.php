@extends('frontend.layouts.master')
@section('title','Product Grid')
@section('main-content')

<div class="py-5" style="background:#f8f9fa">
    <div class="container">
        {{-- Breadcrumbs --}}
        <nav aria-label="breadcrumb" class="mb-5">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{route('home')}}" class="text-success text-decoration-none">Home</a></li>
                <li class="breadcrumb-item active">Shop Grid</li>
            </ol>
        </nav>

        <div class="row g-4">
            {{-- Sidebar Filters --}}
            <div class="col-lg-3">
                <div class="sticky-top" style="top:100px">
                    {{-- Categories --}}
                    <div class="card border-0 shadow-sm rounded-4 p-4 mb-4">
                        <h5 class="fw-bold mb-3" style="font-family:'Nunito',sans-serif">Categories</h5>
                        <div class="accordion accordion-flush" id="catAccordion">
                            @php $menu=App\Models\Category::getAllParentWithChild(); @endphp
                            @foreach($menu as $cat)
                            <div class="accordion-item border-0">
                                <h2 class="accordion-header">
                                    <button class="accordion-button collapsed py-2 px-0 bg-transparent shadow-none fw-bold" type="button" data-bs-toggle="collapse" data-bs-target="#cat-{{$cat->id}}">
                                        {{$cat->title}}
                                    </button>
                                </h2>
                                <div id="cat-{{$cat->id}}" class="accordion-collapse collapse" data-bs-parent="#catAccordion">
                                    <div class="accordion-body p-0 pb-2">
                                        <ul class="list-unstyled ps-3 small">
                                            @foreach($cat->child_cat as $sub)
                                            <li class="my-2"><a href="{{route('product-sub-cat',[$cat->slug,$sub->slug])}}" class="text-decoration-none text-muted hover-success">{{$sub->title}}</a></li>
                                            @endforeach
                                            <li class="my-2"><a href="{{route('product-cat',$cat->slug)}}" class="text-decoration-none text-success fw-bold">View All {{$cat->title}}</a></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>

                    {{-- Price Filter --}}
                    <div class="card border-0 shadow-sm rounded-4 p-4 mb-4">
                        <h5 class="fw-bold mb-3" style="font-family:'Nunito',sans-serif">Price Range</h5>
                        <form action="{{route('shop.filter')}}" method="POST">
                            @csrf
                            <div id="price-slider" class="mb-3"></div>
                            <div class="d-flex justify-content-between align-items-center">
                                <span class="small text-muted" id="price-label">$0 - $1000</span>
                                <input type="hidden" name="price_range" id="price_range">
                                <button type="submit" class="btn btn-success btn-sm rounded-pill px-3">Filter</button>
                            </div>
                        </form>
                    </div>

                    {{-- Recent Products --}}
                    <div class="card border-0 shadow-sm rounded-4 p-4">
                        <h5 class="fw-bold mb-3" style="font-family:'Nunito',sans-serif">Recent Items</h5>
                        @foreach($recent_products->take(3) as $rp)
                        @php $rphoto=explode(',',$rp->photo); @endphp
                        <div class="d-flex align-items-center gap-3 mb-3">
                            <img src="{{$rphoto[0]}}" class="rounded-3" style="width:50px;height:50px;object-fit:cover">
                            <div>
                                <a href="{{route('product-detail',$rp->slug)}}" class="text-decoration-none text-dark small fw-bold d-block">{{Str::limit($rp->title, 20)}}</a>
                                <span class="text-success fw-bold small">${{number_format($rp->price, 2)}}</span>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>

            {{-- Product Grid --}}
            <div class="col-lg-9">
                <div class="d-flex justify-content-between align-items-center mb-4 bg-white p-3 rounded-4 shadow-sm">
                    <div class="d-flex align-items-center gap-3">
                        <span class="text-muted small">Showing {{ $products->firstItem() }}-{{ $products->lastItem() }} of {{ $products->total() }} results</span>
                    </div>
                    <div class="d-flex gap-2">
                        <select class="form-select form-select-sm rounded-pill border-0 bg-light px-3" style="width:150px">
                            <option>Default Sorting</option>
                            <option>Price: Low to High</option>
                            <option>Price: High to Low</option>
                            <option>Newest First</option>
                        </select>
                    </div>
                </div>

                <div class="row row-cols-2 row-cols-md-3 g-4">
                    @foreach($products as $product)
                    <div class="col">
                        <div class="product-item">
                            <figure>
                                <a href="{{route('product-detail',$product->slug)}}">
                                    @php $photo=explode(',',$product->photo); @endphp
                                    <img src="{{$photo[0]}}" alt="{{$product->title}}" style="height:200px;object-fit:contain;width:100%">
                                </a>
                                @if($product->discount)
                                <span class="badge bg-danger position-absolute top-0 start-0 m-2">{{$product->discount}}% OFF</span>
                                @endif
                                <div class="overlay-actions">
                                    <a href="{{route('add-to-wishlist',$product->slug)}}" class="btn-action"><i class="fas fa-heart"></i></a>
                                    <a href="{{route('add-to-cart',$product->slug)}}" class="btn-action"><i class="fas fa-cart-plus"></i></a>
                                </div>
                            </figure>
                            <div class="info text-center">
                                <a href="{{route('product-detail',$product->slug)}}" class="text-decoration-none"><h3>{{Str::limit($product->title, 50)}}</h3></a>
                                @php $after = $product->price - ($product->price * $product->discount / 100); @endphp
                                <div class="d-flex justify-content-center align-items-center gap-2">
                                    <span class="price">${{number_format($after, 2)}}</span>
                                    @if($product->discount > 0)<span class="price-old">${{number_format($product->price, 2)}}</span>@endif
                                </div>
                                <a href="{{route('add-to-cart',$product->slug)}}" class="btn btn-outline-success btn-sm rounded-pill mt-3 w-100 fw-bold">Add to Cart</a>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>

                <div class="mt-5 d-flex justify-content-center">
                    {{$products->appends($_GET)->links()}}
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@push('styles')
<style>
    .hover-success:hover { color: #4caf50 !important; }
    .product-item figure { position: relative; overflow: hidden; border-radius: 1rem; background: #fff; padding: 1rem; transition: all .3s; }
    .product-item:hover figure { transform: translateY(-5px); box-shadow: 0 10px 20px rgba(0,0,0,0.05); }
    .overlay-actions { position: absolute; bottom: -50px; left: 0; right: 0; display: flex; justify-content: center; gap: 10px; transition: all .3s; padding-bottom: 10px; }
    .product-item:hover .overlay-actions { bottom: 10px; }
    .btn-action { width: 35px; height: 35px; background: #fff; border-radius: 50%; display: flex; align-items: center; justify-content: center; color: #333; box-shadow: 0 3px 10px rgba(0,0,0,0.1); text-decoration: none; }
    .btn-action:hover { background: #4caf50; color: #fff; }
</style>
@endpush
