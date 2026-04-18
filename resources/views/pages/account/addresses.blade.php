@extends('layouts.app')
@section('title', __('messages.account.address_tab') . ' — ' . App\Models\Setting::get('site_name','GreenHaven'))

@section('content')
<section class="page-banner">
    <div class="container">
        <h1>{{ __('messages.account.title') }}</h1>
        <nav class="breadcrumb">
            <a href="{{ route('home') }}">{{ __('messages.common.home') }}</a>
            <span>/</span>
            <span>{{ __('messages.account.address_tab') }}</span>
        </nav>
    </div>
</section>

<section style="padding:40px 0 80px;background:var(--bg-light);">
    <div class="container" style="max-width:960px;">
        <div style="display:grid;grid-template-columns:220px 1fr;gap:28px;align-items:start;">

            {{-- Sidebar --}}
            @include('pages.account._sidebar', ['active' => 'addresses'])

            {{-- Main --}}
            <div>

                @if(session('success'))
                <div style="background:#dcfce7;color:#166534;padding:14px 18px;border-radius:12px;font-weight:600;font-size:14px;display:flex;align-items:center;gap:8px;margin-bottom:20px;">
                    <i class="fas fa-check-circle"></i> {{ session('success') }}
                </div>
                @endif

                {{-- Header --}}
                <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:20px;">
                    <div>
                        <h2 style="font-size:17px;font-weight:800;margin:0;">{{ __('messages.account.addresses_title') }}</h2>
                        <p style="font-size:13px;color:#6b7280;margin:4px 0 0;">{{ __('messages.account.addresses_desc') }}</p>
                    </div>
                    <button onclick="openAddressModal()"
                        style="display:inline-flex;align-items:center;gap:8px;padding:10px 18px;background:var(--gradient-primary);color:white;border:none;border-radius:12px;font-weight:600;font-size:13px;cursor:pointer;">
                        <i class="fas fa-plus"></i> {{ __('messages.account.add_address') }}
                    </button>
                </div>

                {{-- Address list --}}
                @if($addresses->isEmpty())
                <div style="background:white;border-radius:20px;padding:48px;text-align:center;box-shadow:0 1px 4px rgba(0,0,0,.05);">
                    <i class="fas fa-map-marker-alt" style="font-size:40px;color:#d1d5db;margin-bottom:14px;display:block;"></i>
                    <p style="font-weight:700;font-size:16px;margin-bottom:6px;">{{ __('messages.account.no_addresses') }}</p>
                    <p style="font-size:13px;color:#6b7280;margin-bottom:20px;">{{ __('messages.account.no_addresses_desc') }}</p>
                    <button onclick="openAddressModal()" class="acc-btn-primary">{{ __('messages.account.add_address') }}</button>
                </div>
                @else
                <div style="display:flex;flex-direction:column;gap:14px;">
                    @foreach($addresses as $addr)
                    <div style="background:white;border-radius:16px;padding:20px 22px;box-shadow:0 1px 4px rgba(0,0,0,.05);
                                border:2px solid {{ $addr->is_primary ? '#10b981' : '#f1f5f9' }};position:relative;">

                        {{-- Primary badge --}}
                        @if($addr->is_primary)
                        <span style="position:absolute;top:16px;right:16px;background:#dcfce7;color:#166534;font-size:11px;font-weight:700;padding:3px 10px;border-radius:999px;display:flex;align-items:center;gap:4px;">
                            <i class="fas fa-check-circle" style="font-size:10px;"></i> {{ __('messages.account.primary_badge') }}
                        </span>
                        @endif

                        <div style="display:flex;align-items:flex-start;gap:14px;">
                            <div style="width:40px;height:40px;background:{{ $addr->is_primary ? '#dcfce7' : '#f1f5f9' }};border-radius:10px;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                                <i class="fas fa-map-marker-alt" style="color:{{ $addr->is_primary ? '#10b981' : '#9ca3af' }};font-size:16px;"></i>
                            </div>
                            <div style="flex:1;min-width:0;">
                                <div style="display:flex;align-items:center;gap:8px;margin-bottom:4px;">
                                    <span style="font-weight:700;font-size:14px;color:#111827;">{{ $addr->label }}</span>
                                </div>
                                <p style="font-size:14px;font-weight:600;color:#374151;margin:0 0 2px;">{{ $addr->recipient_name }}</p>
                                <p style="font-size:13px;color:#6b7280;margin:0 0 2px;">{{ $addr->phone }}</p>
                                <p style="font-size:13px;color:#6b7280;margin:0;line-height:1.5;">
                                    {{ $addr->address }}, {{ $addr->city }}, {{ $addr->province }} {{ $addr->postal_code }}, {{ $addr->country }}
                                </p>
                            </div>
                        </div>

                        {{-- Actions --}}
                        <div style="display:flex;gap:8px;margin-top:14px;padding-top:14px;border-top:1px solid #f1f5f9;flex-wrap:wrap;">
                            @if(!$addr->is_primary)
                            <form action="{{ route('account.addresses.primary', $addr) }}" method="POST" style="margin:0;">
                                @csrf
                                <button type="submit"
                                    style="padding:6px 14px;border-radius:8px;border:1.5px solid #10b981;background:white;color:#10b981;font-size:12px;font-weight:600;cursor:pointer;display:flex;align-items:center;gap:5px;">
                                    <i class="fas fa-star" style="font-size:10px;"></i> {{ __('messages.account.set_primary') }}
                                </button>
                            </form>
                            @endif
                            <button onclick="openEditModal({{ $addr->id }}, {{ json_encode($addr) }})"
                                style="padding:6px 14px;border-radius:8px;border:1.5px solid #e5e7eb;background:white;color:#374151;font-size:12px;font-weight:600;cursor:pointer;">
                                <i class="fas fa-edit" style="font-size:10px;"></i> {{ app()->getLocale()==='id' ? 'Edit' : 'Edit' }}
                            </button>
                            <form action="{{ route('account.addresses.destroy', $addr) }}" method="POST" style="margin:0;"
                                  onsubmit="return confirm('{{ __('messages.account.delete_confirm') }}')">
                                @csrf @method('DELETE')
                                <button type="submit"
                                    style="padding:6px 14px;border-radius:8px;border:1.5px solid #fca5a5;background:white;color:#dc2626;font-size:12px;font-weight:600;cursor:pointer;">
                                    <i class="fas fa-trash" style="font-size:10px;"></i> {{ app()->getLocale()==='id' ? 'Hapus' : 'Delete' }}
                                </button>
                            </form>
                        </div>
                    </div>
                    @endforeach
                </div>
                @endif
            </div>
        </div>
    </div>
</section>

{{-- Add/Edit Address Modal --}}
<div id="address-modal-backdrop"
     style="display:none;position:fixed;inset:0;background:rgba(0,0,0,.5);z-index:5000;align-items:center;justify-content:center;padding:20px;">
    <div style="background:white;border-radius:20px;padding:28px;width:100%;max-width:560px;max-height:90vh;overflow-y:auto;">
        <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:20px;">
            <h3 id="modal-title" style="font-size:17px;font-weight:800;margin:0;">{{ __('messages.account.add_address') }}</h3>
            <button onclick="closeAddressModal()" style="background:#f1f5f9;border:none;width:32px;height:32px;border-radius:50%;cursor:pointer;font-size:14px;color:#6b7280;">✕</button>
        </div>

        <form id="address-form" method="POST">
            @csrf
            <input type="hidden" name="_method" id="form-method" value="POST">

            <div style="display:grid;grid-template-columns:1fr 1fr;gap:14px;margin-bottom:14px;">
                <div>
                    <label class="acc-label">{{ __('messages.account.label') }}</label>
                    <input type="text" name="label" id="f-label" placeholder="{{ __('messages.account.label_placeholder') }}" required class="acc-input">
                </div>
                <div>
                    <label class="acc-label">{{ __('messages.account.recipient_name') }}</label>
                    <input type="text" name="recipient_name" id="f-recipient" required class="acc-input">
                </div>
            </div>
            <div style="margin-bottom:14px;">
                <label class="acc-label">{{ __('messages.account.phone') }}</label>
                <input type="text" name="phone" id="f-phone" required class="acc-input">
            </div>
            <div style="margin-bottom:14px;">
                <label class="acc-label">{{ __('messages.account.address_line') }}</label>
                <textarea name="address" id="f-address" rows="2" required class="acc-input" style="resize:vertical;"></textarea>
            </div>
            <div style="display:grid;grid-template-columns:1fr 1fr;gap:14px;margin-bottom:14px;">
                <div>
                    <label class="acc-label">{{ __('messages.account.city') }}</label>
                    <input type="text" name="city" id="f-city" required class="acc-input">
                </div>
                <div>
                    <label class="acc-label">{{ __('messages.account.province') }}</label>
                    <input type="text" name="province" id="f-province" required class="acc-input">
                </div>
            </div>
            <div style="display:grid;grid-template-columns:1fr 1fr;gap:14px;margin-bottom:20px;">
                <div>
                    <label class="acc-label">{{ __('messages.account.postal_code') }}</label>
                    <input type="text" name="postal_code" id="f-postal" required class="acc-input">
                </div>
                <div>
                    <label class="acc-label">{{ __('messages.account.country') }}</label>
                    <input type="text" name="country" id="f-country" value="Indonesia" class="acc-input">
                </div>
            </div>
            <div style="display:flex;align-items:center;gap:10px;margin-bottom:20px;">
                <input type="checkbox" name="is_primary" id="f-primary" value="1" style="width:18px;height:18px;accent-color:#10b981;">
                <label for="f-primary" style="font-size:14px;font-weight:600;color:#374151;cursor:pointer;">
                    {{ __('messages.account.set_primary') }}
                </label>
            </div>
            <button type="submit" class="acc-btn-primary" style="width:100%;">
                {{ __('messages.button.save') }}
            </button>
        </form>
    </div>
</div>

@include('pages.account._styles')

@push('scripts')
<script>
const STORE_URL = '{{ route('account.addresses.store') }}';

function openAddressModal() {
    document.getElementById('modal-title').textContent = '{{ __('messages.account.add_address') }}';
    document.getElementById('address-form').action = STORE_URL;
    document.getElementById('form-method').value = 'POST';
    ['label','recipient','phone','address','city','province','postal','country'].forEach(id => {
        const el = document.getElementById('f-' + id);
        if (el) el.value = id === 'country' ? 'Indonesia' : '';
    });
    document.getElementById('f-primary').checked = false;
    showModal();
}

function openEditModal(id, data) {
    document.getElementById('modal-title').textContent = '{{ __('messages.account.edit_address') }}';
    document.getElementById('address-form').action = '/account/addresses/' + id;
    document.getElementById('form-method').value = 'PUT';
    document.getElementById('f-label').value      = data.label;
    document.getElementById('f-recipient').value  = data.recipient_name;
    document.getElementById('f-phone').value      = data.phone;
    document.getElementById('f-address').value    = data.address;
    document.getElementById('f-city').value       = data.city;
    document.getElementById('f-province').value   = data.province;
    document.getElementById('f-postal').value     = data.postal_code;
    document.getElementById('f-country').value    = data.country;
    document.getElementById('f-primary').checked  = !!data.is_primary;
    showModal();
}

function showModal() {
    const bd = document.getElementById('address-modal-backdrop');
    bd.style.display = 'flex';
    document.body.style.overflow = 'hidden';
}

function closeAddressModal() {
    document.getElementById('address-modal-backdrop').style.display = 'none';
    document.body.style.overflow = '';
}

document.getElementById('address-modal-backdrop').addEventListener('click', function(e) {
    if (e.target === this) closeAddressModal();
});
</script>
@endpush
@endsection
