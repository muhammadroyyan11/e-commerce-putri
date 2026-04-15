@extends('layouts.app')

@section('title', __('messages.auth.login_page_title') . ' - GreenHaven')

@section('content')
<section class="page-banner" style="padding: 60px 0;">
    <div class="container" style="text-align: center;">
        <h1>{{ __('messages.auth.login_heading') }}</h1>
    </div>
</section>

<section style="padding: 40px 0 80px; background: var(--bg-light);">
    <div class="container" style="max-width: 480px;">
        <div style="background: white; border-radius: 24px; padding: 40px; box-shadow: var(--shadow-sm);">
            @if(session('success'))
                <div style="padding: 12px 16px; background: #dcfce7; color: #166534; border-radius: 12px; margin-bottom: 20px;">{{ session('success') }}</div>
            @endif
            @if(session('error'))
                <div style="padding: 12px 16px; background: #fee2e2; color: #991b1b; border-radius: 12px; margin-bottom: 20px;">{{ session('error') }}</div>
            @endif

            <form method="POST" action="{{ route('login') }}">
                @csrf
                <div style="margin-bottom: 20px;">
                    <label style="display: block; font-weight: 600; margin-bottom: 8px; font-size: 14px;">{{ __('messages.header.email') }}</label>
                    <input type="email" name="email" value="{{ old('email') }}" required style="width: 100%; padding: 14px 16px; border: 1px solid var(--border-color); border-radius: 14px; font-size: 15px;">
                </div>
                <div style="margin-bottom: 24px;">
                    <label style="display: block; font-weight: 600; margin-bottom: 8px; font-size: 14px;">{{ __('messages.header.password') }}</label>
                    <input type="password" name="password" required style="width: 100%; padding: 14px 16px; border: 1px solid var(--border-color); border-radius: 14px; font-size: 15px;">
                </div>
                <div style="display: flex; align-items: center; gap: 8px; margin-bottom: 24px;">
                    <input type="checkbox" name="remember" id="remember" style="width: 18px; height: 18px;">
                    <label for="remember" style="font-size: 14px; color: var(--text-medium); cursor: pointer;">{{ __('messages.header.remember_me') }}</label>
                </div>
                <button type="submit" style="width: 100%; padding: 16px; background: var(--gradient-primary); color: white; border: none; border-radius: 14px; font-weight: 600; font-size: 16px; cursor: pointer;">{{ __('messages.button.login') }}</button>
            </form>

            <div style="display: flex; align-items: center; gap: 12px; margin: 24px 0;">
                <div style="flex: 1; height: 1px; background: #e5e7eb;"></div>
                <span style="font-size: 12px; font-weight: 700; letter-spacing: 0.08em; color: #6b7280;">{{ __('messages.header.or') }}</span>
                <div style="flex: 1; height: 1px; background: #e5e7eb;"></div>
            </div>

            <a href="{{ route('auth.google') }}" style="display: flex; align-items: center; justify-content: center; gap: 12px; width: 100%; padding: 14px 16px; border: 1px solid #d1d5db; border-radius: 14px; color: #111827; font-weight: 600; text-decoration: none;">
                <span style="display: inline-flex; width: 22px; height: 22px; border-radius: 50%; align-items: center; justify-content: center; background: #fff; color: #ea4335; border: 1px solid #e5e7eb; font-size: 13px; font-weight: 700;">G</span>
                {{ __('messages.header.login_google') }}
            </a>

            <p style="text-align: center; margin-top: 24px; color: var(--text-medium); font-size: 14px;">
                {{ __('messages.auth.no_account') }} <a href="{{ route('register') }}" style="color: var(--primary-color); font-weight: 600;">{{ __('messages.auth.register_now') }}</a>
            </p>
        </div>
    </div>
</section>
@endsection
