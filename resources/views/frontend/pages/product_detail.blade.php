@extends('frontend.layouts.master')
@section('title','Product Details')
@section('main-content')

<div class="py-5" style="background:#fff">
    <div class="container">
        {{-- Breadcrumbs --}}
        <nav aria-label="breadcrumb" class="mb-4">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{route('home')}}" class="text-success text-decoration-none">Home</a></li>
                <li class="breadcrumb-item"><a href="{{route('product-grids')}}" class="text-success text-decoration-none">Products</a></li>
                <li class="breadcrumb-item active" aria-current="page">{{$product_detail->title}}</li>
            </ol>
        </nav>

        <div class="row g-5">
            {{-- Product Images --}}
            <div class="col-lg-6">
                @php $photo=explode(',',$product_detail->photo); @endphp
                <div class="position-sticky" style="top:100px">
                    <img id="main-product-img" src="{{$photo[0]}}" class="img-fluid rounded-4 shadow-sm w-100" style="height:500px;object-fit:contain;background:#f9fafb" alt="{{$product_detail->title}}">
                    
                    @if(count($photo) > 1)
                    <div class="row g-2 mt-3">
                        @foreach($photo as $img)
                        <div class="col-3">
                            <img src="{{$img}}" class="img-fluid rounded-3 cursor-pointer border thumbnail-img" style="height:80px;object-fit:cover" onclick="document.getElementById('main-product-img').src=this.src">
                        </div>
                        @endforeach
                    </div>
                    @endif
                </div>
            </div>

            {{-- Product Info --}}
            <div class="col-lg-6">
                <div class="ps-lg-3">
                    <span class="badge bg-success-subtle text-success mb-2 px-3 py-2 rounded-pill fw-bold">
                        {{$product_detail->cat_info['title'] ?? 'Category'}}
                    </span>
                    <h1 class="display-6 fw-extrabold mb-3" style="font-family:'Nunito',sans-serif;font-weight:800">{{$product_detail->title}}</h1>
                    
                    <div class="d-flex align-items-center gap-3 mb-4">
                        @php $rate=ceil($product_detail->getReview->avg('rate')) @endphp
                        <div class="text-warning">
                            @for($i=1; $i<=5; $i++)
                                <i class="fas fa-star{{ $rate >= $i ? '' : '-half-alt' }}"></i>
                            @endfor
                        </div>
                        <span class="text-muted small">({{$product_detail['getReview']->count()}} Reviews)</span>
                        <div class="vr"></div>
                        <span class="text-{{$product_detail->stock > 0 ? 'success' : 'danger'}} fw-bold small">
                            {{$product_detail->stock > 0 ? 'In Stock' : 'Out of Stock'}}
                        </span>
                    </div>

                    @php $after_discount=($product_detail->price-(($product_detail->price*$product_detail->discount)/100)); @endphp
                    <div class="d-flex align-items-center gap-3 mb-4">
                        <span class="display-5 fw-bold text-success">${{number_format($after_discount,2)}}</span>
                        @if($product_detail->discount > 0)
                        <span class="fs-4 text-muted text-decoration-line-through">${{number_format($product_detail->price,2)}}</span>
                        <span class="badge bg-danger rounded-pill px-3">{{$product_detail->discount}}% OFF</span>
                        @endif
                    </div>

                    <p class="text-muted fs-6 mb-5" style="line-height:1.7">{!! $product_detail->summary !!}</p>

                    <form action="{{route('single-add-to-cart')}}" method="POST">
                        @csrf
                        <input type="hidden" name="slug" value="{{$product_detail->slug}}">
                        
                        <div class="d-flex align-items-center gap-3 mb-4">
                            <label class="fw-bold mb-0">Quantity:</label>
                            <div class="d-inline-flex align-items-center border rounded-pill bg-light overflow-hidden">
                                <button type="button" class="btn btn-sm px-4 py-2" onclick="updateQtyDetail(-1)">-</button>
                                <input type="number" name="quant[1]" id="detail-qty" class="form-control form-control-sm text-center border-0 bg-transparent fw-bold" value="1" min="1" max="{{$product_detail->stock}}" style="width:60px">
                                <button type="button" class="btn btn-sm px-4 py-2" onclick="updateQtyDetail(1)">+</button>
                            </div>
                        </div>

                        <div class="d-flex gap-3">
                            <button type="submit" class="btn btn-success btn-lg rounded-pill px-5 flex-grow-1 fw-bold py-3 shadow-sm {{$product_detail->stock <= 0 ? 'disabled' : ''}}">
                                <i class="fas fa-shopping-cart me-2"></i>Add to Cart
                            </button>
                            <a href="{{route('add-to-wishlist',$product_detail->slug)}}" class="btn btn-outline-danger btn-lg rounded-pill px-4 py-3 border-2">
                                <i class="fas fa-heart"></i>
                            </a>
                        </div>
                    </form>

                    <hr class="my-5">

                    <div class="d-flex flex-column gap-3 mb-5">
                        <div class="d-flex align-items-center gap-3">
                            <div class="bg-light p-3 rounded-circle" style="width:55px;height:55px;display:flex;align-items:center;justify-content:center"><i class="fas fa-truck text-success"></i></div>
                            <div><div class="fw-bold">Free Shipping</div><div class="small text-muted">On orders over $99</div></div>
                        </div>
                        <div class="d-flex align-items-center gap-3">
                            <div class="bg-light p-3 rounded-circle" style="width:55px;height:55px;display:flex;align-items:center;justify-content:center"><i class="fas fa-undo text-success"></i></div>
                            <div><div class="fw-bold">Hassle-free Returns</div><div class="small text-muted">30 days return policy</div></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Tabs --}}
        <div class="row mt-5">
            <div class="col-12">
                <ul class="nav nav-pills mb-4 gap-2 justify-content-center" id="pills-tab" role="tablist">
                    <li class="nav-item">
                        <button class="nav-link active rounded-pill px-5 fw-bold py-2 border" id="pills-desc-tab" data-bs-toggle="pill" data-bs-target="#pills-desc" type="button">Description</button>
                    </li>
                    <li class="nav-item">
                        <button class="nav-link rounded-pill px-5 fw-bold py-2 border" id="pills-review-tab" data-bs-toggle="pill" data-bs-target="#pills-review" type="button">Reviews ({{$product_detail['getReview']->count()}})</button>
                    </li>
                </ul>
                <div class="tab-content border-top pt-4" id="pills-tabContent">
                    <div class="tab-pane fade show active" id="pills-desc" role="tabpanel">
                        <div class="mx-auto" style="max-width:800px;line-height:1.8">
                            {!! $product_detail->description !!}
                        </div>
                    </div>
                    <div class="tab-pane fade" id="pills-review" role="tabpanel">
                        <div class="mx-auto" style="max-width:800px">
                            @foreach($product_detail['getReview'] as $data)
                            <div class="card border-0 bg-light rounded-4 p-4 mb-3">
                                <div class="d-flex gap-3">
                                    <img src="{{$data->user_info['photo'] ?? asset('backend/img/avatar.png')}}" class="rounded-circle" style="width:50px;height:50px;object-fit:cover">
                                    <div class="flex-grow-1">
                                        <div class="d-flex justify-content-between mb-2">
                                            <h6 class="fw-bold mb-0">{{$data->user_info['name']}}</h6>
                                            <div class="text-warning small">
                                                @for($i=1;$i<=5;$i++)<i class="fas fa-star{{$data->rate >= $i ? '' : '-half-alt'}}"></i>@endfor
                                            </div>
                                        </div>
                                        <p class="text-muted small mb-1">{{$data->created_at->format('M d, Y')}}</p>
                                        <p class="mb-0">{{$data->review}}</p>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                            
                            @auth
                            <div class="mt-5 p-4 border rounded-4">
                                <h5 class="fw-bold mb-4">Write a Review</h5>
                                <form action="{{route('review.store',$product_detail->slug)}}" method="POST">
                                    @csrf
                                    <div class="mb-3">
                                        <label class="form-label">Rating</label>
                                        <div class="star-rating fs-4 text-warning">
                                            <input type="radio" name="rate" value="5" id="s5"><label for="s5"><i class="far fa-star"></i></label>
                                            <input type="radio" name="rate" value="4" id="s4"><label for="s4"><i class="far fa-star"></i></label>
                                            <input type="radio" name="rate" value="3" id="s3"><label for="s3"><i class="far fa-star"></i></label>
                                            <input type="radio" name="rate" value="2" id="s2"><label for="s2"><i class="far fa-star"></i></label>
                                            <input type="radio" name="rate" value="1" id="s1"><label for="s1"><i class="far fa-star"></i></label>
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <textarea name="review" class="form-control rounded-4 p-3" rows="4" placeholder="Share your experience..."></textarea>
                                    </div>
                                    <button class="btn btn-success rounded-pill px-5 fw-bold">Post Review</button>
                                </form>
                            </div>
                            @else
                            <div class="text-center p-5 bg-light rounded-4 mt-4">
                                <p>Please <a href="{{route('login.form')}}" class="text-success fw-bold">login</a> to leave a review.</p>
                            </div>
                            @endauth
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Related Products --}}
        @if($product_detail->rel_prods->count() > 1)
        <div class="mt-5 pt-5 border-top">
            <h2 class="fw-bold mb-4" style="font-family:'Nunito',sans-serif">Related Products</h2>
            <div class="row row-cols-2 row-cols-md-4 g-4">
                @foreach($product_detail->rel_prods as $rel)
                @if($rel->id != $product_detail->id)
                <div class="col">
                    <div class="product-item">
                        <figure>
                            <a href="{{route('product-detail',$rel->slug)}}">
                                @php $rphoto=explode(',',$rel->photo); @endphp
                                <img src="{{$rphoto[0]}}" class="img-fluid" alt="{{$rel->title}}" style="height:180px;object-fit:contain;width:100%">
                            </a>
                        </figure>
                        <div class="info">
                            <a href="{{route('product-detail',$rel->slug)}}" class="text-decoration-none"><h3>{{Str::limit($rel->title, 40)}}</h3></a>
                            @php $rafter = $rel->price - ($rel->price * $rel->discount / 100); @endphp
                            <div class="price text-successfw-bold">${{number_format($rafter, 2)}}</div>
                        </div>
                    </div>
                </div>
                @endif
                @endforeach
            </div>
        </div>
        @endif
    </div>
</div>

@endsection

@push('styles')
<style>
    .star-rating { display: flex; flex-direction: row-reverse; justify-content: flex-end; }
    .star-rating input { display: none; }
    .star-rating label { cursor: pointer; padding: 0 4px; }
    .star-rating input:checked ~ label i::before { content: "\f005"; font-family: "Font Awesome 6 Free"; font-weight: 900; }
    .star-rating label:hover ~ label i::before, .star-rating label:hover i::before { content: "\f005"; font-family: "Font Awesome 6 Free"; font-weight: 900; }
    .nav-pills .nav-link { color: #555; background: #fff; }
    .nav-pills .nav-link.active { background: #4caf50 !important; color: #fff !important; border-color: #4caf50 !important; }
    .cursor-pointer { cursor: pointer; transition: all .3s; }
    .thumbnail-img:hover { border-color: #4caf50 !important; transform: scale(1.05); }
</style>
@endpush

@push('scripts')
<script>
    function updateQtyDetail(delta) {
        let input = document.getElementById('detail-qty');
        let newVal = parseInt(input.value) + delta;
        if(newVal >= 1 && newVal <= parseInt(input.max)) {
            input.value = newVal;
        }
    }
</script>
@endpush