@extends('user.layouts.master')

@section('title','Order Detail')

@section('main-content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="h4 mb-0 text-gray-800">Order Detail: #{{$order->order_number}}</h3>
        <a href="{{route('order.pdf',$order->id)}}" class="btn btn-success btn-sm shadow-sm rounded-pill px-4">
            <i class="fas fa-download fa-sm text-white-50 mr-2"></i> Generate PDF
        </a>
    </div>

    @if($order)
    <div class="row g-4">
        {{-- Information Column --}}
        <div class="col-lg-7">
            {{-- Order Meta Card --}}
            <div class="card border-0 shadow-sm rounded-4 mb-4 overflow-hidden">
                <div class="card-header bg-success text-white py-3 border-0">
                    <h6 class="m-0 font-weight-bold">Order Information</h6>
                </div>
                <div class="card-body">
                    <table class="table table-borderless table-sm mb-0">
                        <tr>
                            <td class="text-muted" style="width:150px">Order Number</td>
                            <td class="fw-bold">: #{{$order->order_number}}</td>
                        </tr>
                        <tr>
                            <td class="text-muted">Order Date</td>
                            <td>: {{$order->created_at->format('D, d M Y')}} at {{$order->created_at->format('H:i')}}</td>
                        </tr>
                        <tr>
                            <td class="text-muted">Status</td>
                            <td>: 
                                @if($order->status=='new')
                                    <span class="badge badge-primary px-2 rounded-pill">NEW</span>
                                @elseif($order->status=='process')
                                    <span class="badge badge-warning px-2 rounded-pill">PROCESSING</span>
                                @elseif($order->status=='delivered')
                                    <span class="badge badge-success px-2 rounded-pill">DELIVERED</span>
                                @else
                                    <span class="badge badge-danger px-2 rounded-pill">CANCELLED</span>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <td class="text-muted">Payment Method</td>
                            <td class="text-uppercase">: {{str_replace('_', ' ', $order->payment_method)}}</td>
                        </tr>
                        <tr>
                            <td class="text-muted">Payment Status</td>
                            <td>: <span class="badge badge-{{$order->payment_status == 'paid' ? 'success' : 'light-dark border'}} px-2 rounded-pill">{{strtoupper($order->payment_status)}}</span></td>
                        </tr>
                    </table>
                </div>
            </div>

            {{-- Shipping Info Card --}}
            <div class="card border-0 shadow-sm rounded-4 mb-4 overflow-hidden">
                <div class="card-header bg-light py-3 border-0">
                    <h6 class="m-0 font-weight-bold text-dark">Shipping & Customer Information</h6>
                </div>
                <div class="card-body">
                    <table class="table table-borderless table-sm mb-0">
                        <tr><td class="text-muted" style="width:150px">Full Name</td><td class="fw-bold">: {{$order->first_name}} {{$order->last_name}}</td></tr>
                        <tr><td class="text-muted">Email</td><td>: {{$order->email}}</td></tr>
                        <tr><td class="text-muted">Phone No.</td><td>: {{$order->phone}}</td></tr>
                        <tr><td class="text-muted">Address</td><td>: {{$order->address1}}, {{$order->address2}}</td></tr>
                        <tr><td class="text-muted">Country</td><td>: {{$order->country}}</td></tr>
                        <tr><td class="text-muted">Post Code</td><td>: {{$order->post_code}}</td></tr>
                    </table>
                </div>
            </div>
        </div>

        {{-- Actions & Summary Column --}}
        <div class="col-lg-5">
            {{-- WhatsApp Confirmation Card --}}
            @php $settings = DB::table('settings')->first(); @endphp
            @if($order->status == 'new' || $order->status == 'process')
            <div class="card border-0 shadow-sm rounded-4 mb-4 bg-success-subtle p-4" style="background:#e8f5e9">
                <h5 class="fw-bold text-success mb-3" style="font-family:'Nunito'">Confirm via WhatsApp</h5>
                <p class="small text-muted mb-4">Click the button below to confirm your payment or order status with our admin on WhatsApp.</p>
                @php
                    $wa_number = preg_replace('/[^0-9]/', '', ($settings->phone ?? '628123456789'));
                    // Ensure it starts with 62 or international format
                    if(strpos($wa_number, '0') === 0) { $wa_number = '62' . substr($wa_number, 1); }
                    $wa_message = urlencode("Hello Organik Admin! I want to confirm my order #".$order->order_number.". Total: $".number_format($order->total_amount, 2));
                    $wa_link = "https://wa.me/".$wa_number."?text=".$wa_message;
                @endphp
                <a href="{{$wa_link}}" target="_blank" class="btn btn-success w-100 rounded-pill py-2 shadow-sm fw-bold">
                    <i class="fab fa-whatsapp me-2"></i> Chat Admin
                </a>
            </div>
            @endif

            {{-- Payment Summary --}}
            <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
                <div class="card-body">
                    <h5 class="fw-bold mb-4" style="font-family:'Nunito'">Order Summary</h5>
                    <div class="d-flex justify-content-between mb-2">
                        <span class="text-muted">Quantity</span>
                        <span>{{$order->quantity}} items</span>
                    </div>
                    <div class="d-flex justify-content-between mb-2">
                        <span class="text-muted">Subtotal</span>
                        <span class="fw-bold">{{number_format($order->total_amount - $order->shipping->price, 2)}}</span>
                    </div>
                    <div class="d-flex justify-content-between mb-2">
                        <span class="text-muted">Shipping Charge</span>
                        <span class="fw-bold text-success">+{{number_format($order->shipping->price, 2)}}</span>
                    </div>
                    <hr>
                    <div class="d-flex justify-content-between">
                        <span class="h5 fw-bold">Total Amount</span>
                        <span class="h5 fw-bold text-success">${{number_format($order->total_amount, 2)}}</span>
                    </div>
                </div>
            </div>

            {{-- Manual Payment Instructions if applicable --}}
            @if($order->payment_method == 'bank_transfer' && $order->payment_status != 'paid')
            <div class="card border-0 shadow-sm rounded-4 mt-4 p-4 border-left-success border-width-4">
                <h6 class="fw-bold text-success">Bank Transfer Instructions</h6>
                <p class="small mb-2">Please transfer to our bank account:</p>
                <div class="bg-light p-3 rounded-3 small">
                    <strong>BCA: 1234567890</strong><br>
                    <strong>A/N: Organik Store Ltd.</strong>
                </div>
                <p class="small text-muted mt-3 mb-0">After transfer, click the WhatsApp button above to send proof of payment.</p>
            </div>
            @endif
        </div>
    </div>
    @endif
</div>
@endsection

@push('styles')
<style>
    .bg-success-subtle { background-color: #e8f5e9 !important; }
    .border-left-success { border-left: 4px solid #28a745 !important; }
    .rounded-4 { border-radius: 1rem !important; }
    .gap-3 { gap: 1rem; }
</style>
@endpush
