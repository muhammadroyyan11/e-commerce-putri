@extends('layouts.app')

@section('title', __('messages.checkout.title') . ' - ' . App\Models\Setting::get('site_name', 'GreenHaven'))

@section('content')
<!-- Page Banner -->
<section class="page-banner">
    <div class="container">
        <h1>{{ __('messages.checkout.title') }}</h1>
        <nav class="breadcrumb">
            <a href="{{ route('home') }}">{{ __('messages.common.home') }}</a>
            <span>/</span>
            <span>{{ __('messages.checkout.breadcrumb') }}</span>
        </nav>
    </div>
</section>

<!-- Checkout Section -->
<section style="padding: 40px 0 60px; background: var(--bg-light);">
    <div class="container">
        <!-- Steps -->
        <div class="cart-steps" style="margin-bottom: 40px;">
            <div class="step completed">
                <div class="step-number"><i class="fas fa-check"></i></div>
                <span class="step-label">{{ __('messages.cart.step_cart') }}</span>
            </div>
            <div class="step-line completed"></div>
            <div class="step active">
                <div class="step-number">2</div>
                <span class="step-label">{{ __('messages.checkout.title') }}</span>
            </div>
            <div class="step-line"></div>
            <div class="step">
                <div class="step-number">3</div>
                <span class="step-label">{{ __('messages.cart.step_done') }}</span>
            </div>
        </div>

        <div class="checkout-layout">
            <!-- Form -->
            <div style="flex: 1;">
                <form action="{{ route('checkout.process') }}" method="POST">
                    @csrf
                    
                    <!-- Contact -->
                    <div style="background: white; border-radius: 16px; padding: 30px; margin-bottom: 20px;">
                        <h3 style="font-size: 18px; font-weight: 700; margin-bottom: 24px;"><i class="fas fa-envelope" style="color: var(--primary-color); margin-right: 10px;"></i> {{ __('messages.checkout.contact_info') }}</h3>
                        <div style="margin-bottom: 16px;">
                            <label style="display: block; font-size: 14px; font-weight: 500; margin-bottom: 8px;">{{ __('messages.header.email') }} *</label>
                            <input type="email" name="email" required style="width: 100%; padding: 14px 16px; border: 1px solid var(--border-color); border-radius: 12px;">
                        </div>
                    </div>

                    <!-- Shipping Address -->
                    <div style="background: white; border-radius: 16px; padding: 30px; margin-bottom: 20px;">
                        <h3 style="font-size: 18px; font-weight: 700; margin-bottom: 24px;"><i class="fas fa-shipping-fast" style="color: var(--primary-color); margin-right: 10px;"></i> {{ __('messages.checkout.shipping_address') }}</h3>
                        <div class="grid-2-col" style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px; margin-bottom: 16px;">
                            <div>
                                <label style="display: block; font-size: 14px; font-weight: 500; margin-bottom: 8px;">{{ __('messages.checkout.first_name') }} *</label>
                                <input type="text" name="first_name" required style="width: 100%; padding: 14px 16px; border: 1px solid var(--border-color); border-radius: 12px;">
                            </div>
                            <div>
                                <label style="display: block; font-size: 14px; font-weight: 500; margin-bottom: 8px;">{{ __('messages.checkout.last_name') }} *</label>
                                <input type="text" name="last_name" required style="width: 100%; padding: 14px 16px; border: 1px solid var(--border-color); border-radius: 12px;">
                            </div>
                        </div>
                        <div style="margin-bottom: 16px;">
                            <label style="display: block; font-size: 14px; font-weight: 500; margin-bottom: 8px;">{{ __('messages.checkout.address') }} *</label>
                            <input type="text" name="address" required style="width: 100%; padding: 14px 16px; border: 1px solid var(--border-color); border-radius: 12px;">
                        </div>
                        <div class="grid-3-col" style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 16px; margin-bottom: 16px;">
                            <div>
                                <label style="display: block; font-size: 14px; font-weight: 500; margin-bottom: 8px;">{{ __('messages.checkout.city') }} *</label>
                                <input type="text" name="city" required style="width: 100%; padding: 14px 16px; border: 1px solid var(--border-color); border-radius: 12px;">
                            </div>
                            <div>
                                <label style="display: block; font-size: 14px; font-weight: 500; margin-bottom: 8px;">{{ __('messages.checkout.province') }} *</label>
                                <input type="text" name="province" required style="width: 100%; padding: 14px 16px; border: 1px solid var(--border-color); border-radius: 12px;">
                            </div>
                            <div>
                                <label style="display: block; font-size: 14px; font-weight: 500; margin-bottom: 8px;">{{ __('messages.checkout.postal_code') }} *</label>
                                <input type="text" name="postal_code" required style="width: 100%; padding: 14px 16px; border: 1px solid var(--border-color); border-radius: 12px;">
                            </div>
                        </div>
                        <div style="margin-bottom: 16px;">
                            <label style="display: block; font-size: 14px; font-weight: 500; margin-bottom: 8px;">{{ __('messages.checkout.country') }} *</label>
                            <select name="country" id="country-select" required style="width: 100%;"></select>
                        </div>
                        <div>
                            <label style="display: block; font-size: 14px; font-weight: 500; margin-bottom: 8px;">{{ __('messages.checkout.phone') }} *</label>
                            <input type="tel" name="phone" required style="width: 100%; padding: 14px 16px; border: 1px solid var(--border-color); border-radius: 12px;">
                        </div>
                    </div>

                    <!-- Shipping Options -->
                    <div style="background: white; border-radius: 16px; padding: 30px; margin-bottom: 20px;">
                        <h3 style="font-size: 18px; font-weight: 700; margin-bottom: 16px;"><i class="fas fa-truck" style="color: var(--primary-color); margin-right: 10px;"></i> Shipping / Pengiriman</h3>

                        {{-- Kota (hanya Indonesia) --}}
                        <div id="city-wrapper" style="display:none; margin-bottom: 16px;">
                            <label style="display: block; font-size: 14px; font-weight: 500; margin-bottom: 8px;">Kota Tujuan / Destination City *</label>
                            <select id="city-select" style="width: 100%;"></select>
                        </div>

                        <div id="shipping-loading" style="display:none; font-size:14px; color: var(--text-medium);">
                            <i class="fas fa-spinner fa-spin mr-1"></i> Calculating shipping cost...
                        </div>
                        <div id="shipping-options" style="display:flex; flex-direction:column; gap:10px;"></div>
                        <div id="shipping-placeholder" style="font-size:14px; color: var(--text-medium);">
                            <i class="fas fa-info-circle mr-1"></i> Select your country to see shipping options.
                        </div>

                        <input type="hidden" name="shipping_cost" id="shipping_cost" value="0">
                        <input type="hidden" name="shipping_courier" id="shipping_courier">
                        <input type="hidden" name="shipping_service" id="shipping_service">
                        <input type="hidden" name="shipping_etd" id="shipping_etd">
                    </div>

                    <!-- Payment -->
                    <div style="background: white; border-radius: 16px; padding: 30px; margin-bottom: 20px;">
                        <h3 style="font-size: 18px; font-weight: 700; margin-bottom: 24px;"><i class="fas fa-credit-card" style="color: var(--primary-color); margin-right: 10px;"></i> {{ __('messages.checkout.payment') }}</h3>
                        <div style="display: flex; flex-direction: column; gap: 12px;">
                            @forelse($paymentMethods as $index => $method)
                            <label style="display: flex; align-items: center; gap: 12px; padding: 14px 18px; background: var(--bg-light); border-radius: 10px; cursor: pointer; border: 1px solid transparent;">
                                <input type="radio" name="payment_method_id" value="{{ $method->id }}" {{ $index === 0 ? 'checked' : '' }} style="accent-color: var(--primary-color);">
                                @if($method->logo)
                                    <img src="{{ asset('storage/' . $method->logo) }}" alt="{{ $method->name }}" style="height: 28px; border-radius: 4px; background: #fff; padding: 2px; border: 1px solid #e5e7eb;">
                                @endif
                                <div>
                                    <div style="font-weight: 600; display: flex; align-items: center; gap: 8px;">
                                        {{ $method->name }}
                                        @if($method->isMidtrans())
                                            <span style="font-size: 11px; font-weight: 600; background: #dbeafe; color: #1d4ed8; padding: 2px 8px; border-radius: 20px;">Midtrans</span>
                                        @else
                                            <span style="font-size: 11px; font-weight: 600; background: #dcfce7; color: #15803d; padding: 2px 8px; border-radius: 20px;">Transfer Manual</span>
                                        @endif
                                    </div>
                                    @if($method->isManual())
                                    <div style="font-size: 13px; color: var(--text-medium);">{{ $method->account_number }} a.n. {{ $method->account_name }}</div>
                                    @else
                                    <div style="font-size: 13px; color: var(--text-medium);">Bayar via Midtrans (kartu kredit, transfer, e-wallet)</div>
                                    @endif
                                </div>
                            </label>
                            @empty
                            <p style="font-size: 14px; color: var(--text-medium);">{{ __('messages.checkout.select_payment') }}</p>
                            @endforelse
                        </div>
                    </div>

                    <button type="submit" style="width: 100%; padding: 18px; background: var(--gradient-primary); color: white; border-radius: 12px; font-weight: 600; font-size: 16px; border: none; cursor: pointer;">{{ __('messages.button.order_now') }}</button>
                    <input type="hidden" name="coupon_code" id="applied_coupon_code">
                </form>
            </div>

            <!-- Summary -->
            <div class="checkout-sidebar" style="width: 420px;">
                <div style="background: white; border-radius: 16px; padding: 30px; position: sticky; top: 92px;">
                    <h3 style="font-size: 18px; font-weight: 700; margin-bottom: 24px;">{{ __('messages.checkout.order_summary') }}</h3>
                    
                    @foreach($cartItems as $item)
                    <div style="display: flex; align-items: center; gap: 16px; margin-bottom: 16px; padding-bottom: 16px; border-bottom: 1px solid var(--border-color);">
                        <div style="position: relative;">
                            <img src="{{ $item['image'] }}" alt="{{ $item['name'] }}" style="width: 60px; height: 60px; border-radius: 10px; object-fit: cover;">
                            <span style="position: absolute; top: -8px; right: -8px; width: 22px; height: 22px; background: var(--text-dark); color: white; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 11px; font-weight: 600;">{{ $item['quantity'] }}</span>
                        </div>
                        <div style="flex: 1;">
                            <h4 style="font-size: 14px; font-weight: 600;">{{ $item['name'] }}</h4>
                            <p style="font-size: 12px; color: var(--text-light);">{{ $item['variant'] }}</p>
                        </div>
                        <span style="font-weight: 600; font-size: 14px;">{{ $currency->format($item['price'] * $item['quantity'], $currentCurrency) }}</span>
                    </div>
                    @endforeach

                    <div style="margin-top: 20px; padding-top: 20px; border-top: 2px solid var(--border-color);">
                        <div style="display: flex; justify-content: space-between; margin-bottom: 12px; font-size: 14px;">
                            <span>{{ __('messages.cart.subtotal') }}</span>
                            <span>{{ $currency->format($summary['subtotal'], $currentCurrency) }}</span>
                        </div>
                        <div style="display: flex; justify-content: space-between; margin-bottom: 12px; font-size: 14px;">
                            <span>Ongkir / Shipping</span>
                            <span id="shipping-display" style="color: var(--text-medium);">-</span>
                        </div>
                        <div id="coupon-discount-row" style="display: none; justify-content: space-between; margin-bottom: 12px; font-size: 14px; color: #16a34a;">
                            <span>Coupon (<span id="coupon-code-label"></span>)</span>
                            <span id="coupon-discount-amount"></span>
                        </div>
                        <div style="display: flex; justify-content: space-between; padding-top: 12px; border-top: 1px solid var(--border-color);">
                            <span style="font-size: 16px; font-weight: 700;">{{ __('messages.cart.total') }}</span>
                            <div style="text-align: right;">
                                <span id="total-display" style="font-size: 24px; font-weight: 700; color: var(--primary-dark);">{{ $currency->format($summary['subtotal'], $currentCurrency) }}</span>
                            </div>
                        </div>
                    </div>

                    <!-- Coupon Input -->
                    <div style="margin-top: 20px; padding-top: 20px; border-top: 1px solid var(--border-color);">
                        <p style="font-size: 14px; font-weight: 600; margin-bottom: 10px;"><i class="fas fa-ticket-alt" style="color: var(--primary-color); margin-right: 6px;"></i> Punya kode coupon?</p>
                        <div style="display: flex; gap: 8px;">
                            <input type="text" id="coupon_input" maxlength="5" placeholder="Masukkan kode"
                                style="flex: 1; padding: 10px 14px; border: 1px solid var(--border-color); border-radius: 10px; font-size: 14px; text-transform: uppercase;">
                            <button type="button" id="apply_coupon_btn"
                                style="padding: 10px 16px; background: var(--primary-color); color: white; border: none; border-radius: 10px; font-size: 14px; font-weight: 600; cursor: pointer;">
                                Pakai
                            </button>
                        </div>
                        <div id="coupon-message" style="margin-top: 8px; font-size: 13px;"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

@push('styles')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet">
<style>
.select2-container { width: 100% !important; }
.select2-container .select2-selection--single {
    height: 50px !important;
    border: 1px solid var(--border-color) !important;
    border-radius: 12px !important;
    display: flex;
    align-items: center;
    padding: 0 16px;
}
.select2-container--default .select2-selection--single .select2-selection__rendered {
    line-height: 50px !important;
    padding-left: 0;
    color: #333;
}
.select2-container--default .select2-selection--single .select2-selection__arrow {
    height: 50px !important;
    right: 10px;
}
.select2-dropdown { border: 1px solid var(--border-color); border-radius: 12px; overflow: hidden; }
.select2-search--dropdown .select2-search__field { border-radius: 8px; padding: 8px 12px; }
</style>
@endpush

@push('scripts')
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
(function () {
    const subtotal = {{ $summary['subtotal'] }};
    const currencyRate = {{ $currency->getRate($currentCurrency) }};
    const currencySymbol = '{{ $currency->symbol($currentCurrency) }}';
    const currencyCode = '{{ $currentCurrency }}';
    let shippingCost = 0;
    let couponDiscount = 0;

    function formatMoney(idrAmount) {
        const v = idrAmount * currencyRate;
        return currencyCode === 'IDR'
            ? 'Rp ' + Math.round(v).toLocaleString('id-ID')
            : currencySymbol + v.toFixed(2);
    }

    function updateTotal() {
        const total = Math.max(0, subtotal + shippingCost - couponDiscount);
        document.getElementById('total-display').textContent = formatMoney(total);
    }

    // ── Country Select2 ──────────────────────────────────────────────────────
    fetch('https://restcountries.com/v3.1/all?fields=name')
        .then(r => r.json())
        .then(data => {
            const countries = data.map(c => c.name.common).sort((a, b) => a.localeCompare(b));
            initCountrySelect(countries);
        })
        .catch(() => {
            initCountrySelect(['Indonesia','Malaysia','Singapore','Thailand','Philippines',
                'Vietnam','Australia','Japan','South Korea','China','India','United States','United Kingdom']);
        });

    function initCountrySelect(countries) {
        const sel = document.getElementById('country-select');
        sel.appendChild(new Option('Indonesia', 'Indonesia', true, true));
        countries.filter(c => c !== 'Indonesia').forEach(n => sel.appendChild(new Option(n, n)));
        $(sel).select2({ placeholder: 'Search country...', allowClear: false });
        $(sel).on('change', onCountryChange);
        // Trigger for Indonesia default
        onCountryChange();
    }

    function onCountryChange() {
        const country = document.getElementById('country-select').value;
        const cityWrapper = document.getElementById('city-wrapper');

        if (country === 'Indonesia') {
            cityWrapper.style.display = 'block';
            loadCities();
        } else {
            cityWrapper.style.display = 'none';
            fetchShippingOptions(country, '');
        }
    }

    // ── City Select2 (Indonesia only) ────────────────────────────────────────
    let citiesLoaded = false;
    function loadCities() {
        if (citiesLoaded) return;
        fetch('{{ route('shipping.cities') }}')
            .then(r => r.json())
            .then(data => {
                const sel = document.getElementById('city-select');
                $(sel).empty();
                (data.cities || []).forEach(c => {
                    sel.appendChild(new Option(c.city_name + ' (' + c.province + ')', c.city_id));
                });
                $(sel).select2({ placeholder: 'Pilih kota...', allowClear: false, width: '100%' });
                $(sel).on('change', function () {
                    fetchShippingOptions('Indonesia', this.value);
                });
                citiesLoaded = true;
                if (data.cities && data.cities.length > 0) {
                    fetchShippingOptions('Indonesia', data.cities[0].city_id);
                }
            })
            .catch(() => {
                // RajaOngkir off — fetch flat rate
                fetchShippingOptions('Indonesia', '');
            });
    }

    // ── Fetch Shipping Options ───────────────────────────────────────────────
    function fetchShippingOptions(country, cityId) {
        document.getElementById('shipping-loading').style.display = 'block';
        document.getElementById('shipping-options').innerHTML = '';
        document.getElementById('shipping-placeholder').style.display = 'none';

        fetch('{{ route('shipping.options') }}', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
            body: JSON.stringify({ country, city_id: cityId })
        })
        .then(r => r.json())
        .then(data => {
            document.getElementById('shipping-loading').style.display = 'none';
            renderShippingOptions(data.options || []);
        })
        .catch(() => {
            document.getElementById('shipping-loading').style.display = 'none';
            document.getElementById('shipping-placeholder').style.display = 'block';
            document.getElementById('shipping-placeholder').textContent = 'Gagal mengambil opsi pengiriman.';
        });
    }

    function renderShippingOptions(options) {
        const container = document.getElementById('shipping-options');
        container.innerHTML = '';
        if (!options.length) {
            container.innerHTML = '<p style="font-size:14px;color:var(--text-medium)">No shipping options available for this destination.</p>';
            return;
        }
        options.forEach((opt, i) => {
            const isIntl = opt.courier === 'INTL';
            const label = document.createElement('label');
            label.style.cssText = 'display:flex;align-items:center;gap:12px;padding:12px 16px;background:var(--bg-light);border-radius:10px;cursor:pointer;border:2px solid transparent;transition:border-color .2s;';
            label.innerHTML = `
                <input type="radio" name="_shipping_option" value="${i}" ${i === 0 ? 'checked' : ''} style="accent-color:var(--primary-color)">
                <div style="flex:1">
                    <div style="font-weight:600;font-size:14px">
                        ${isIntl ? '<i class="fas fa-globe" style="color:var(--primary-color);margin-right:6px"></i>' : ''}
                        ${opt.courier} — ${opt.service}
                    </div>
                    <div style="font-size:12px;color:var(--text-medium);margin-top:2px">
                        ${opt.description}
                        ${opt.etd !== '-' ? ' &nbsp;·&nbsp; <i class="fas fa-clock" style="font-size:11px"></i> ' + opt.etd : ''}
                    </div>
                </div>
                <span style="font-weight:700;font-size:15px;white-space:nowrap">${formatMoney(opt.cost)}</span>
            `;
            label.querySelector('input').addEventListener('change', () => selectShipping(opt));
            // highlight on select
            label.addEventListener('click', () => {
                container.querySelectorAll('label').forEach(l => l.style.borderColor = 'transparent');
                label.style.borderColor = 'var(--primary-color)';
            });
            container.appendChild(label);
            if (i === 0) {
                selectShipping(opt);
                label.style.borderColor = 'var(--primary-color)';
            }
        });
    }

    function selectShipping(opt) {
        shippingCost = opt.cost;
        document.getElementById('shipping_cost').value = opt.cost;
        document.getElementById('shipping_courier').value = opt.courier;
        document.getElementById('shipping_service').value = opt.service;
        document.getElementById('shipping_etd').value = opt.etd;
        document.getElementById('shipping-display').textContent = formatMoney(opt.cost);
        document.getElementById('shipping-display').style.color = 'inherit';
        updateTotal();
    }

    // ── Coupon ───────────────────────────────────────────────────────────────
    document.getElementById('coupon_input').addEventListener('input', function () {
        this.value = this.value.toUpperCase();
    });

    document.getElementById('apply_coupon_btn').addEventListener('click', function () {
        const code = document.getElementById('coupon_input').value.trim();
        if (!code) return;
        fetch('{{ route('coupon.apply') }}', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
            body: JSON.stringify({ code })
        })
        .then(r => r.json())
        .then(data => {
            const msg = document.getElementById('coupon-message');
            if (data.success) {
                couponDiscount = data.discount;
                document.getElementById('applied_coupon_code').value = data.code;
                document.getElementById('coupon-code-label').textContent = data.code;
                document.getElementById('coupon-discount-amount').textContent = '- ' + formatMoney(data.discount);
                document.getElementById('coupon-discount-row').style.display = 'flex';
                msg.style.color = '#16a34a';
                msg.textContent = data.message;
            } else {
                msg.style.color = '#dc2626';
                msg.textContent = data.message;
            }
            updateTotal();
        });
    });
})();
</script>
@endpush
