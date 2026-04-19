@extends('layouts.app')

@section('title', __('messages.auth.register_page_title') . ' - LongLeaf')

@section('content')
<section class="page-banner" style="padding: 60px 0;">
    <div class="container" style="text-align: center;">
        <h1>{{ __('messages.auth.register_heading') }}</h1>
    </div>
</section>

<section style="padding: 40px 0 80px; background: var(--bg-light);">
    <div class="container" style="max-width: 480px;">
        <div style="background: white; border-radius: 24px; padding: 40px; box-shadow: var(--shadow-sm);">
            @if(session('error'))
                <div style="padding: 12px 16px; background: #fee2e2; color: #991b1b; border-radius: 12px; margin-bottom: 20px;">{{ session('error') }}</div>
            @endif

            <form method="POST" action="{{ route('register') }}">
                @csrf
                <div style="margin-bottom: 20px;">
                    <label style="display: block; font-weight: 600; margin-bottom: 8px; font-size: 14px;">{{ __('messages.auth.name') }}</label>
                    <input type="text" name="name" value="{{ old('name') }}" required style="width: 100%; padding: 14px 16px; border: 1px solid var(--border-color); border-radius: 14px; font-size: 15px;">
                    @error('name')<div style="color: #dc2626; font-size: 13px; margin-top: 6px;">{{ $message }}</div>@enderror
                </div>
                <div style="margin-bottom: 20px;">
                    <label style="display: block; font-weight: 600; margin-bottom: 8px; font-size: 14px;">{{ __('messages.header.email') }}</label>
                    <input type="email" name="email" value="{{ old('email') }}" required style="width: 100%; padding: 14px 16px; border: 1px solid var(--border-color); border-radius: 14px; font-size: 15px;">
                    @error('email')<div style="color: #dc2626; font-size: 13px; margin-top: 6px;">{{ $message }}</div>@enderror
                </div>
                <div style="margin-bottom: 20px;">
                    <label style="display: block; font-weight: 600; margin-bottom: 8px; font-size: 14px;">{{ __('messages.header.password') }}</label>
                    <input type="password" name="password" required style="width: 100%; padding: 14px 16px; border: 1px solid var(--border-color); border-radius: 14px; font-size: 15px;">
                    @error('password')<div style="color: #dc2626; font-size: 13px; margin-top: 6px;">{{ $message }}</div>@enderror
                </div>
                <div style="margin-bottom: 24px;">
                    <label style="display: block; font-weight: 600; margin-bottom: 8px; font-size: 14px;">{{ __('messages.auth.confirm_password') }}</label>
                    <input type="password" name="password_confirmation" required style="width: 100%; padding: 14px 16px; border: 1px solid var(--border-color); border-radius: 14px; font-size: 15px;">
                </div>

                @if(session('referral_code'))
                <div style="margin-bottom: 20px; background: #f0fdf4; border: 1px solid #bbf7d0; border-radius: 14px; padding: 14px 16px; display: flex; align-items: center; gap: 10px;">
                    <i class="fas fa-gift" style="color: var(--primary-color);"></i>
                    <div>
                        <div style="font-size: 13px; color: #166534; font-weight: 600;">Kamu diundang dengan kode referral</div>
                        <div style="font-size: 15px; font-weight: 700; letter-spacing: 2px; color: var(--primary-color);">{{ session('referral_code') }}</div>
                    </div>
                    <input type="hidden" name="referral_code" value="{{ session('referral_code') }}">
                </div>
                @endif

                <button type="submit" style="width: 100%; padding: 16px; background: var(--gradient-primary); color: white; border: none; border-radius: 14px; font-weight: 600; font-size: 16px; cursor: pointer;">{{ __('messages.button.register') }}</button>
            </form>

            <p style="text-align: center; margin-top: 24px; color: var(--text-medium); font-size: 14px;">
                {{ __('messages.auth.have_account') }} <a href="{{ route('login') }}" style="color: var(--primary-color); font-weight: 600;">{{ __('messages.auth.login_here') }}</a>
            </p>
        </div>
    </div>
</section>
@endsection
