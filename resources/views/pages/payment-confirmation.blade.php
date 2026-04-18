@extends('layouts.app')

@section('title', __('messages.payment_confirmation.title') . ' - ' . App\Models\Setting::get('site_name', 'LongLeaf'))

@section('content')
<section class="page-banner">
    <div class="container">
        <h1>{{ __('messages.payment_confirmation.title') }}</h1>
        <nav class="breadcrumb">
            <a href="{{ route('home') }}">Home</a>
            <span>/</span>
            <span>{{ __('messages.payment_confirmation.title') }}</span>
        </nav>
    </div>
</section>

<section style="padding: 40px 0 60px; background: var(--bg-light);">
    <div class="container">
        <div style="max-width: 720px; margin: 0 auto;">
            <!-- Order Summary -->
            <div style="background: white; border-radius: 16px; padding: 24px; margin-bottom: 20px;">
                <h3 style="font-size: 16px; font-weight: 700; margin-bottom: 16px;">{{ __('messages.payment_confirmation.detail_order') }}</h3>
                <div style="display: flex; justify-content: space-between; margin-bottom: 8px; font-size: 14px;">
                    <span>{{ __('messages.payment_form.order_number') }}</span>
                    <strong>{{ $order->order_number }}</strong>
                </div>
                <div style="display: flex; justify-content: space-between; margin-bottom: 8px; font-size: 14px;">
                    <span>{{ __('messages.payment_form.payment_method') }}</span>
                    <strong>{{ $order->paymentMethod?->display_name ?? $order->payment_method }}</strong>
                </div>
                <div style="display: flex; justify-content: space-between; padding-top: 10px; border-top: 1px solid var(--border-color); font-size: 16px; font-weight: 700;">
                    <span>{{ __('messages.payment_form.total_pay') }}</span>
                    <span style="color: var(--primary-dark);">Rp {{ number_format($order->total, 0, ',', '.') }}</span>
                </div>
            </div>

            <!-- Form -->
            <div style="background: white; border-radius: 16px; padding: 30px;">
                <h3 style="font-size: 18px; font-weight: 700; margin-bottom: 24px;">{{ __('messages.payment_form.form_title') }}</h3>
                <form action="{{ route('payment-confirmation.store', $order) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div style="margin-bottom: 18px;">
                        <label style="display: block; font-size: 14px; font-weight: 500; margin-bottom: 8px;">{{ __('messages.payment_form.sender_name') }} *</label>
                        <input type="text" name="sender_name" value="{{ old('sender_name') }}" required style="width: 100%; padding: 14px 16px; border: 1px solid var(--border-color); border-radius: 12px;">
                        @error('sender_name')<div style="color: #dc2626; font-size: 13px; margin-top: 6px;">{{ $message }}</div>@enderror
                    </div>

                    <div class="grid-2-col" style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px; margin-bottom: 18px;">
                        <div>
                            <label style="display: block; font-size: 14px; font-weight: 500; margin-bottom: 8px;">{{ __('messages.payment_form.amount') }} *</label>
                            <input type="number" name="amount" value="{{ old('amount', $order->total) }}" required style="width: 100%; padding: 14px 16px; border: 1px solid var(--border-color); border-radius: 12px;">
                            @error('amount')<div style="color: #dc2626; font-size: 13px; margin-top: 6px;">{{ $message }}</div>@enderror
                        </div>
                        <div>
                            <label style="display: block; font-size: 14px; font-weight: 500; margin-bottom: 8px;">{{ __('messages.payment_form.payment_date') }} *</label>
                            <input type="date" name="payment_date" value="{{ old('payment_date', now()->format('Y-m-d')) }}" required style="width: 100%; padding: 14px 16px; border: 1px solid var(--border-color); border-radius: 12px;">
                            @error('payment_date')<div style="color: #dc2626; font-size: 13px; margin-top: 6px;">{{ $message }}</div>@enderror
                        </div>
                    </div>

                    <div style="margin-bottom: 18px;">
                        <label style="display: block; font-size: 14px; font-weight: 500; margin-bottom: 8px;">{{ __('messages.payment_form.notes') }} <span style="color:#9ca3af;">({{ __('messages.payment_form.notes_optional') }})</span></label>
                        <textarea name="notes" rows="3" style="width: 100%; padding: 14px 16px; border: 1px solid var(--border-color); border-radius: 12px;">{{ old('notes') }}</textarea>
                        @error('notes')<div style="color: #dc2626; font-size: 13px; margin-top: 6px;">{{ $message }}</div>@enderror
                    </div>

                    <div style="margin-bottom: 24px;">
                        <label style="display: block; font-size: 14px; font-weight: 500; margin-bottom: 8px;">{{ __('messages.payment_form.proof') }} <span style="color:#9ca3af;">({{ __('messages.payment_form.proof_optional') }})</span></label>
                        <input type="file" name="proof_image" accept="image/*" style="display: block; width: 100%; padding: 10px; border: 1px dashed var(--border-color); border-radius: 12px; background: var(--bg-light);">
                        @error('proof_image')<div style="color: #dc2626; font-size: 13px; margin-top: 6px;">{{ $message }}</div>@enderror
                    </div>

                    <button type="submit" style="width: 100%; padding: 16px; background: var(--gradient-primary); color: white; border-radius: 12px; font-weight: 600; font-size: 16px; border: none; cursor: pointer;">
                        {{ __('messages.payment_confirmation.submit') }}
                    </button>
                </form>
            </div>
        </div>
    </div>
</section>
@endsection
