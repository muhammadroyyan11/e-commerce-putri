@extends('layouts.app')
@section('title', (app()->getLocale()==='id' ? 'FAQ - Pertanyaan Umum' : 'FAQ - Frequently Asked Questions') . ' - ' . App\Models\Setting::get('site_name','LongLeaf'))

@section('content')
<section class="page-banner">
    <div class="container">
        <h1>{{ __('messages.faq.title') }}</h1>
        <nav class="breadcrumb">
            <a href="{{ route('home') }}">{{ __('messages.common.home') }}</a>
            <span>/</span>
            <span>{{ __('messages.faq.breadcrumb') }}</span>
        </nav>
    </div>
</section>

<section style="padding:60px 0 80px;background:#fff;">
    <div class="container" style="max-width:860px;">

        @php
        $categoryLabels = [
            'general'  => __('messages.faq.cat_general'),
            'shipping' => __('messages.faq.cat_shipping'),
            'payment'  => __('messages.faq.cat_payment'),
            'care'     => __('messages.faq.cat_care'),
        ];
        @endphp

        @forelse($faqs as $category => $items)
        <div style="margin-bottom:48px;">
            <h2 style="font-size:20px;font-weight:800;color:var(--primary-dark);margin-bottom:20px;display:flex;align-items:center;gap:10px;">
                <span style="width:32px;height:32px;background:var(--primary-light);border-radius:8px;display:inline-flex;align-items:center;justify-content:center;font-size:14px;">
                    @if($category==='shipping')🚚@elseif($category==='payment')💳@elseif($category==='care')🌿@else❓@endif
                </span>
                {{ $categoryLabels[$category] ?? ucfirst($category) }}
            </h2>

            <div style="display:flex;flex-direction:column;gap:12px;">
                @foreach($items as $i => $faq)
                <div class="faq-item" style="background:#f8fafc;border-radius:14px;overflow:hidden;border:1px solid #f1f5f9;">
                    <button onclick="toggleFaq('faq-{{ $category }}-{{ $i }}')"
                        style="width:100%;display:flex;align-items:center;justify-content:space-between;padding:18px 20px;
                               background:none;border:none;cursor:pointer;text-align:left;font-family:inherit;">
                        <span style="font-size:15px;font-weight:600;color:#111827;line-height:1.4;">{{ $faq->question }}</span>
                        <i class="fas fa-chevron-down faq-icon" id="icon-faq-{{ $category }}-{{ $i }}"
                           style="color:#10b981;font-size:13px;flex-shrink:0;margin-left:16px;transition:transform .2s;"></i>
                    </button>
                    <div id="faq-{{ $category }}-{{ $i }}" style="display:none;padding:0 20px 18px;">
                        <div style="font-size:14px;color:#4b5563;line-height:1.75;border-top:1px solid #e5e7eb;padding-top:14px;">
                            {!! nl2br(e($faq->answer)) !!}
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        @empty
        <div style="text-align:center;padding:60px 0;color:#9ca3af;">
            <i class="fas fa-question-circle" style="font-size:48px;margin-bottom:16px;display:block;"></i>
            <p>{{ __('messages.faq.empty') }}</p>
        </div>
        @endforelse

        <div style="background:var(--primary-light);border-radius:20px;padding:32px;text-align:center;margin-top:20px;">
            <h3 style="font-size:20px;font-weight:700;color:var(--primary-dark);margin-bottom:8px;">
                {{ __('messages.faq.still_questions') }}
            </h3>
            <p style="color:var(--text-medium);margin-bottom:20px;">
                {{ __('messages.faq.still_desc') }}
            </p>
            <a href="{{ route('contact') }}" style="display:inline-flex;align-items:center;gap:8px;padding:12px 28px;background:var(--gradient-primary);color:white;border-radius:12px;font-weight:600;text-decoration:none;">
                <i class="fas fa-envelope"></i>
                {{ __('messages.faq.contact_us') }}
            </a>
        </div>
    </div>
</section>
@endsection

@push('scripts')
<script>
function toggleFaq(id) {
    const el   = document.getElementById(id);
    const icon = document.getElementById('icon-' + id);
    const open = el.style.display !== 'none';
    el.style.display   = open ? 'none' : 'block';
    icon.style.transform = open ? 'rotate(0deg)' : 'rotate(180deg)';
}
</script>
@endpush
