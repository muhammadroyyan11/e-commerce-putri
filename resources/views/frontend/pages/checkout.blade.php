@extends('frontend.layouts.master')
@section('title','Checkout')
@section('main-content')

<div class="py-5" style="background:#f8f9fa; min-height:80vh">
    <div class="container">
        <h1 class="fw-bold mb-4" style="font-family:'Nunito',sans-serif;font-size:1.8rem">Checkout</h1>

        <form action="{{route('cart.order')}}" method="POST">
            @csrf
            <div class="row g-4">
                {{-- Billing Info --}}
                <div class="col-lg-8">
                    <div class="card border-0 shadow-sm rounded-4 p-4 mb-4">
                        <h5 class="fw-bold mb-4" style="font-family:'Nunito',sans-serif">Shipping Address</h5>
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label small fw-bold">First Name <span class="text-danger">*</span></label>
                                <input name="first_name" class="form-control rounded-pill border-0 bg-light px-3" value="{{auth()->user()->name ?? ''}}" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label small fw-bold">Last Name <span class="text-danger">*</span></label>
                                <input name="last_name" class="form-control rounded-pill border-0 bg-light px-3" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label small fw-bold">Email Address <span class="text-danger">*</span></label>
                                <input type="email" name="email" class="form-control rounded-pill border-0 bg-light px-3" value="{{auth()->user()->email ?? ''}}" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label small fw-bold">Phone Number <span class="text-danger">*</span></label>
                                <input name="phone" class="form-control rounded-pill border-0 bg-light px-3" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label small fw-bold">Country <span class="text-danger">*</span></label>
                                <select name="country" class="form-select rounded-pill border-0 bg-light px-3">
                                    <option value="ID">Indonesia</option>
                                    <option value="NP" selected>Nepal</option>
                                    <option value="IN">India</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label small fw-bold">City / Town <span class="text-danger">*</span></label>
                                <input name="address1" class="form-control rounded-pill border-0 bg-light px-3" required>
                            </div>
                            <div class="col-12">
                                <label class="form-label small fw-bold">Full Address <span class="text-danger">*</span></label>
                                <textarea name="address2" class="form-control rounded-4 border-0 bg-light p-3" rows="3" required></textarea>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label small fw-bold">Postal Code</label>
                                <input name="post_code" class="form-control rounded-pill border-0 bg-light px-3">
                            </div>
                        </div>
                    </div>

                    <div class="card border-0 shadow-sm rounded-4 p-4">
                        <h5 class="fw-bold mb-4" style="font-family:'Nunito',sans-serif">Shipping Method</h5>
                        @php $shippings = DB::table('shippings')->where('status','active')->get(); @endphp
                        @foreach($shippings as $key => $ship)
                        <div class="form-check p-3 border rounded-3 mb-2 ps-5 cursor-pointer hover-bg-light">
                            <input class="form-check-input" type="radio" name="shipping" value="{{$ship->id}}" id="ship-{{$ship->id}}" data-price="{{$ship->price}}" required {{ $key == 0 ? 'checked' : '' }}>
                            <label class="form-check-label d-flex justify-content-between w-100 cursor-pointer" for="ship-{{$ship->id}}">
                                <span>{{$ship->type}} <small class="text-muted d-block small">Delivery in {{ $ship->price > 50 ? '1-2' : '3-5' }} days</small></span>
                                <span class="fw-bold text-success">${{number_format($ship->price, 2)}}</span>
                            </label>
                        </div>
                        @endforeach
                    </div>
                </div>

                {{-- Order Summary & Payment --}}
                <div class="col-lg-4">
                    <div class="card border-0 shadow-sm rounded-4 p-4 mb-4" style="background-color:#fff">
                        <h5 class="fw-bold mb-4" style="font-family:'Nunito',sans-serif">Your Order</h5>
                        <ul class="list-unstyled mb-4">
                            @foreach(Helper::getAllProductFromCart() as $cart)
                            <li class="d-flex justify-content-between mb-2 small">
                                <span class="text-muted">{{$cart->product['title']}} x {{$cart->quantity}}</span>
                                <span class="fw-bold">${{number_format($cart['amount'], 2)}}</span>
                            </li>
                            @endforeach
                        </ul>

                        <div class="border-top pt-3 mb-2 d-flex justify-content-between small">
                            <span class="text-muted">Subtotal</span>
                            <span class="fw-bold" id="subtotal" data-price="{{Helper::totalCartPrice()}}">${{number_format(Helper::totalCartPrice(), 2)}}</span>
                        </div>

                        @if(session()->has('coupon'))
                        <div class="d-flex justify-content-between mb-2 small">
                            <span class="text-muted">Discount</span>
                            <span class="text-danger fw-bold" id="discount" data-price="{{Session::get('coupon')['value']}}">-${{number_format(Session::get('coupon')['value'], 2)}}</span>
                        </div>
                        @else
                        <input type="hidden" id="discount" data-price="0">
                        @endif

                        <div class="d-flex justify-content-between mb-2 small">
                            <span class="text-muted">Shipping</span>
                            <span class="fw-bold" id="shipping-price">$0.00</span>
                        </div>

                        <div class="d-flex justify-content-between mt-3 mb-4 pt-3 border-top">
                            <span class="fw-bold fs-5">Total Pay</span>
                            <span class="fw-bold fs-5 text-success" id="total-price">${{number_format(Helper::totalCartPrice(), 2)}}</span>
                        </div>

                        <h6 class="fw-bold mb-3" style="font-family:'Nunito',sans-serif">Payment Method</h6>
                        <div class="form-check mb-3">
                            <input class="form-check-input" type="radio" name="payment_method" value="cod" id="pay-cod" checked>
                            <label class="form-check-label fw-bold" for="pay-cod">Cash on Delivery</label>
                        </div>
                        <div class="form-check mb-4">
                            <input class="form-check-input" type="radio" name="payment_method" value="paypal" id="pay-paypal">
                            <label class="form-check-label fw-bold" for="pay-paypal">PayPal</label>
                        </div>
                        <div class="form-check mb-4">
                            <input class="form-check-input" type="radio" name="payment_method" value="bank_transfer" id="pay-bank">
                            <label class="form-check-label fw-bold" for="pay-bank">Manual Bank Transfer</label>
                        </div>

                        <button type="submit" class="btn btn-success w-100 rounded-pill py-3 fw-bold fs-5 shadow-sm">
                            Place Order <i class="fas fa-check-circle ms-2"></i>
                        </button>
                    </div>

                    <div class="text-center">
                        <img src="{{asset('backend/img/payments.png')}}" class="img-fluid" style="max-height:30px;opacity:0.6" alt="Payments">
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

@endsection

@push('styles')
<style>
    .cursor-pointer { cursor: pointer; }
    .hover-bg-light:hover { background-color: #f9fafb; border-color: #4caf50 !important; }
</style>
@endpush

@push('scripts')
<script>
    $(document).ready(function() {
        $('input[name="shipping"]').change(function() {
            let ship_cost = parseFloat($(this).data('price')) || 0;
            let subtotal = parseFloat($('#subtotal').data('price')) || 0;
            let discount = parseFloat($('#discount').data('price')) || 0;
            
            $('#shipping-price').text('$' + ship_cost.toFixed(2));
            $('#total-price').text('$' + (subtotal + ship_cost - discount).toFixed(2));
        });
        // Trigger initial calculation
        $('input[name="shipping"]:checked').change();
    });
</script>
@endpush