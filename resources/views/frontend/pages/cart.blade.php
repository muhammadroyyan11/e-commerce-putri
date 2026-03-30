@extends('frontend.layouts.master')
@section('title','Shopping Cart')
@section('main-content')

<div class="py-5" style="background:#f8f9fa; min-height:80vh">
    <div class="container">
        <h1 class="fw-bold mb-4" style="font-family:'Nunito',sans-serif;font-size:1.8rem">Shopping Cart</h1>

        @if(Helper::getAllProductFromCart()->count() > 0)
        <div class="row g-4">
            {{-- Cart Items --}}
            <div class="col-lg-8">
                <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
                    <div class="table-responsive">
                        <table class="table table-borderless align-middle mb-0">
                            <thead style="background:#e8f5e9">
                                <tr>
                                    <th class="py-3 px-4">Product</th>
                                    <th class="py-3">Price</th>
                                    <th class="py-3 text-center">Quantity</th>
                                    <th class="py-3">Total</th>
                                    <th class="py-3"></th>
                                </tr>
                            </thead>
                            <tbody class="bg-white">
                                <form action="{{route('cart.update')}}" method="POST" id="cart-form">
                                @csrf
                                @foreach(Helper::getAllProductFromCart() as $key=>$cart)
                                <tr class="border-bottom">
                                    <td class="py-3 px-4">
                                        <div class="d-flex align-items-center gap-3">
                                            @php $photo=explode(',',$cart->product['photo']); @endphp
                                            <img src="{{$photo[0]}}" class="rounded-3" alt="{{$cart->product['title']}}" style="width:70px;height:70px;object-fit:cover">
                                            <div>
                                                <a href="{{route('product-detail',$cart->product['slug'])}}" class="text-decoration-none fw-bold text-dark d-block">
                                                    {{$cart->product['title']}}
                                                </a>
                                                <span class="text-muted small">ID: #{{$cart->id}}</span>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="py-3">
                                        <span class="fw-bold text-success">${{number_format($cart['price'],2)}}</span>
                                    </td>
                                    <td class="py-3 text-center">
                                        <div class="d-inline-flex align-items-center border rounded-pill bg-light overflow-hidden">
                                            <button type="button" class="btn btn-sm px-3 btn-qty-minus" onclick="updateQty(this, -1)">-</button>
                                            <input type="text" name="quant[{{$key}}]" class="form-control form-control-sm text-center border-0 bg-transparent fw-bold" value="{{$cart->quantity}}" style="width:40px" readonly>
                                            <input type="hidden" name="qty_id[]" value="{{$cart->id}}">
                                            <button type="button" class="btn btn-sm px-3 btn-qty-plus" onclick="updateQty(this, 1)">+</button>
                                        </div>
                                    </td>
                                    <td class="py-3">
                                        <span class="fw-bold">${{number_format($cart['amount'],2)}}</span>
                                    </td>
                                    <td class="py-3 text-end px-4">
                                        <a href="{{route('cart-delete',$cart->id)}}" class="text-danger" title="Remove Item"><i class="fas fa-trash-alt"></i></a>
                                    </td>
                                </tr>
                                @endforeach
                                </form>
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="d-flex justify-content-between mt-4">
                    <a href="{{route('product-grids')}}" class="btn btn-outline-success rounded-pill px-4 fw-bold">
                        <i class="fas fa-arrow-left me-2"></i>Continue Shopping
                    </a>
                    <button type="button" onclick="document.getElementById('cart-form').submit()" class="btn btn-success rounded-pill px-4 fw-bold">
                        Update Cart
                    </button>
                </div>
            </div>

            {{-- Summary --}}
            <div class="col-lg-4">
                <div class="card border-0 shadow-sm rounded-4 p-4">
                    <h5 class="fw-bold mb-4" style="font-family:'Nunito',sans-serif">Order Summary</h5>
                    
                    <div class="mb-4">
                        <form action="{{route('coupon-store')}}" method="POST" class="d-flex gap-2">
                            @csrf
                            <input name="code" class="form-control rounded-pill border-0 bg-light px-3" placeholder="Promo Code">
                            <button class="btn btn-dark rounded-pill px-4">Apply</button>
                        </form>
                    </div>

                    <div class="d-flex justify-content-between mb-2">
                        <span class="text-muted">Subtotal</span>
                        <span class="fw-bold">${{number_format(Helper::totalCartPrice(),2)}}</span>
                    </div>

                    @if(session()->has('coupon'))
                    <div class="d-flex justify-content-between mb-2">
                        <span class="text-muted">Discount ({{session('coupon')['code']}})</span>
                        <span class="text-danger">-${{number_format(Session::get('coupon')['value'],2)}}</span>
                    </div>
                    @endif

                    <div class="d-flex justify-content-between mb-4 border-top pt-3">
                        <span class="fw-bold fs-5">Total Pay</span>
                        @php
                            $total_amount=Helper::totalCartPrice();
                            if(session()->has('coupon')){ $total_amount-=(float)Session::get('coupon')['value']; }
                        @endphp
                        <span class="fw-bold fs-5 text-success">${{number_format($total_amount,2)}}</span>
                    </div>

                    <a href="{{route('checkout')}}" class="btn btn-success w-100 rounded-pill py-3 fw-bold fs-5 mb-3">
                        Proceed To Checkout <i class="fas fa-arrow-right ms-2"></i>
                    </a>
                    
                    <div class="text-center small text-muted">
                        <i class="fas fa-shield-alt me-1"></i> Secure Checkout Guaranteed
                    </div>
                </div>
            </div>
        </div>
        @else
        <div class="card border-0 shadow-sm rounded-4 p-5 text-center">
            <div class="mb-4">
                <i class="fas fa-shopping-basket fa-4x text-light-green" style="color:#e8f5e9"></i>
            </div>
            <h3 class="fw-bold" style="font-family:'Nunito',sans-serif">Your cart is empty</h3>
            <p class="text-muted mb-4">Looks like you haven't added anything to your cart yet.</p>
            <div>
                <a href="{{route('product-grids')}}" class="btn btn-success rounded-pill px-5 py-3 fw-bold">
                    Start Shopping
                </a>
            </div>
        </div>
        @endif
    </div>
</div>

@endsection

@push('scripts')
<script>
    function updateQty(btn, delta) {
        let input = btn.parentElement.querySelector('input[type="text"]');
        let newVal = parseInt(input.value) + delta;
        if(newVal >= 1 && newVal <= 100) {
            input.value = newVal;
        }
    }
</script>
@endpush
