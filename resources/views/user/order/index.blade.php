@extends('user.layouts.master')

@section('main-content')
<div class="container-fluid">
    @include('user.layouts.notification')

    {{-- Shopee Style Tabs --}}
    <div class="card border-0 shadow-sm mb-4 rounded-3 overflow-hidden">
        <div class="card-body p-0">
            <ul class="nav nav-pills nav-fill bg-white" id="orderTabs">
                <li class="nav-item">
                    <a class="nav-link active rounded-0 py-3 border-bottom border-success border-3" href="#" data-status="all">All</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link rounded-0 py-3 text-dark" href="#" data-status="new">New</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link rounded-0 py-3 text-dark" href="#" data-status="process">Processing</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link rounded-0 py-3 text-dark" href="#" data-status="delivered">Delivered</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link rounded-0 py-3 text-dark" href="#" data-status="cancel">Cancelled</a>
                </li>
            </ul>
        </div>
    </div>

    {{-- Order Cards List --}}
    <div id="order-list">
        @if(count($orders) > 0)
            @foreach($orders as $order)
            <div class="card border-0 shadow-sm mb-3 rounded-3 order-card" data-status="{{$order->status}}">
                <div class="card-body">
                    {{-- Card Header --}}
                    <div class="d-flex justify-content-between align-items-center border-bottom pb-2 mb-3">
                        <div class="d-flex align-items-center gap-2">
                            <i class="fas fa-store text-success"></i>
                            <span class="fw-bold text-dark">Organik Store</span>
                            <span class="badge badge-light border text-muted px-2">#{{$order->order_number}}</span>
                        </div>
                        <div class="text-uppercase font-weight-bold">
                            @if($order->status=='new')
                                <span class="text-primary"><i class="fas fa-receipt me-1"></i> NEW</span>
                            @elseif($order->status=='process')
                                <span class="text-warning"><i class="fas fa-truck-loading me-1"></i> PROCESSING</span>
                            @elseif($order->status=='delivered')
                                <span class="text-success"><i class="fas fa-check-circle me-1"></i> DELIVERED</span>
                            @else
                                <span class="text-danger"><i class="fas fa-times-circle me-1"></i> CANCELLED</span>
                            @endif
                        </div>
                    </div>

                    {{-- Card Body (Product Summary) --}}
                    <div class="row align-items-center mb-3">
                        <div class="col-md-9">
                            <div class="d-flex gap-3 align-items-center">
                                @php 
                                    // In this specific Laravel project, orders usually have multiple products in order_products or cart table related to order.
                                    // But typically for a summary, we show one or general info.
                                    // Let's assume there's a relationship or we just show the count.
                                @endphp
                                <div class="bg-light rounded p-2" style="width:80px;height:80px;display:flex;align-items:center;justify-content:center">
                                    <i class="fas fa-box fa-2x text-light-green" style="color:#c8e6c9"></i>
                                </div>
                                <div>
                                    <h6 class="mb-1 font-weight-bold">Order containing {{$order->quantity}} items</h6>
                                    <p class="text-muted small mb-0">Purchased on {{ $order->created_at->format('d M Y, H:i') }}</p>
                                    <p class="text-muted small mb-0">Shipping to: {{$order->first_name}} {{$order->last_name}} ({{$order->phone}})</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 text-md-right mt-3 mt-md-0">
                            <span class="text-muted small d-block">Total Amount</span>
                            <span class="h5 font-weight-bold text-success">${{number_format($order->total_amount, 2)}}</span>
                        </div>
                    </div>

                    {{-- Card Footer (Actions) --}}
                    <div class="d-flex justify-content-end gap-2 border-top pt-3">
                        <a href="{{route('user.order.show', $order->id)}}" class="btn btn-outline-success btn-sm px-4 rounded-pill">View Detail</a>
                        @if($order->status == 'delivered')
                            <a href="#" class="btn btn-success btn-sm px-4 rounded-pill">Buy Again</a>
                        @endif
                        @if($order->status == 'new')
                            <form method="POST" action="{{route('user.order.delete',[$order->id])}}" class="d-inline">
                                @csrf
                                @method('delete')
                                <button type="submit" class="btn btn-outline-danger btn-sm px-4 rounded-pill dltBtn">Cancel Order</button>
                            </form>
                        @endif
                    </div>
                </div>
            </div>
            @endforeach
            <div class="mt-4 d-flex justify-content-center">
                {{$orders->links()}}
            </div>
        @else
            <div class="text-center py-5">
                <img src="https://img.icons8.com/clouds/200/000000/empty-box.png" alt="Empty">
                <h5 class="mt-3 text-muted">No orders found!</h5>
                <a href="{{route('home')}}" class="btn btn-success mt-3 rounded-pill px-4">Shop Now</a>
            </div>
        @endif
    </div>
</div>
@endsection

@push('styles')
<style>
    .nav-pills .nav-link.active {
        background: transparent !important;
        color: #28a745 !important;
        font-weight: bold;
    }
    .order-card {
        transition: transform 0.2s, box-shadow 0.2s;
    }
    .order-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.1) !important;
    }
    .text-light-green { color: #81c784; }
    .gap-2 { gap: 0.5rem; }
    .gap-3 { gap: 1rem; }
</style>
@endpush

@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
<script>
    $(document).ready(function(){
        // Tab filtering logic (client-side for demo, or you can make it server side)
        $('#orderTabs .nav-link').click(function(e){
            e.preventDefault();
            $('#orderTabs .nav-link').removeClass('active border-bottom border-success border-3').addClass('text-dark');
            $(this).addClass('active border-bottom border-success border-3').removeClass('text-dark');
            
            let status = $(this).data('status');
            if(status === 'all') {
                $('.order-card').show();
            } else {
                $('.order-card').hide();
                $('.order-card[data-status="' + status + '"]').show();
            }
        });

        $('.dltBtn').click(function(e){
            var form=$(this).closest('form');
            e.preventDefault();
            swal({
                title: "Are you sure?",
                text: "Do you want to cancel this order?",
                icon: "warning",
                buttons: true,
                dangerMode: true,
            }).then((willDelete) => {
                if (willDelete) {
                   form.submit();
                }
            });
        });
    });
</script>
@endpush
