@extends('layouts.app')
@section('title', __('messages.account.profile_tab') . ' — ' . App\Models\Setting::get('site_name','GreenHaven'))

@section('content')
<section class="page-banner">
    <div class="container">
        <h1>{{ __('messages.account.title') }}</h1>
        <nav class="breadcrumb">
            <a href="{{ route('home') }}">{{ __('messages.common.home') }}</a>
            <span>/</span>
            <span>{{ __('messages.account.profile_tab') }}</span>
        </nav>
    </div>
</section>

<section style="padding:40px 0 80px;background:var(--bg-light);">
    <div class="container" style="max-width:960px;">
        <div style="display:grid;grid-template-columns:220px 1fr;gap:28px;align-items:start;">

            {{-- Sidebar --}}
            @include('pages.account._sidebar', ['active' => 'profile'])

            {{-- Main --}}
            <div style="display:flex;flex-direction:column;gap:24px;">

                @if(session('success'))
                <div style="background:#dcfce7;color:#166534;padding:14px 18px;border-radius:12px;font-weight:600;font-size:14px;display:flex;align-items:center;gap:8px;">
                    <i class="fas fa-check-circle"></i> {{ session('success') }}
                </div>
                @endif

                {{-- Profile form --}}
                <div style="background:white;border-radius:20px;padding:28px;box-shadow:0 1px 4px rgba(0,0,0,.05);">
                    <h2 style="font-size:17px;font-weight:800;margin-bottom:4px;">{{ __('messages.account.profile_title') }}</h2>
                    <p style="font-size:13px;color:#6b7280;margin-bottom:24px;">{{ __('messages.account.profile_desc') }}</p>

                    <form action="{{ route('account.profile.update') }}" method="POST">
                        @csrf @method('PUT')
                        <div style="display:grid;grid-template-columns:1fr 1fr;gap:16px;margin-bottom:16px;">
                            <div>
                                <label class="acc-label">{{ __('messages.account.full_name') }}</label>
                                <input type="text" name="name" value="{{ old('name', $user->name) }}" required class="acc-input @error('name') acc-input-err @enderror">
                                @error('name')<p class="acc-err">{{ $message }}</p>@enderror
                            </div>
                            <div>
                                <label class="acc-label">{{ __('messages.account.phone') }}</label>
                                <input type="text" name="phone" value="{{ old('phone', $user->phone) }}" class="acc-input">
                            </div>
                        </div>
                        <div style="margin-bottom:20px;">
                            <label class="acc-label">{{ __('messages.account.email') }}</label>
                            <input type="email" name="email" value="{{ old('email', $user->email) }}" required class="acc-input @error('email') acc-input-err @enderror">
                            @error('email')<p class="acc-err">{{ $message }}</p>@enderror
                        </div>
                        <button type="submit" class="acc-btn-primary">{{ __('messages.account.save_profile') }}</button>
                    </form>
                </div>

                {{-- Referral Code --}}
                <div style="background:white;border-radius:20px;padding:28px;box-shadow:0 1px 4px rgba(0,0,0,.05);">
                    <h2 style="font-size:17px;font-weight:800;margin-bottom:4px;">Kode Referral</h2>
                    <p style="font-size:13px;color:#6b7280;margin-bottom:20px;">Bagikan link ini ke teman. Setiap teman yang daftar via link kamu akan tercatat.</p>

                    <div style="display:flex;align-items:center;gap:12px;background:#f0fdf4;border:1px solid #bbf7d0;border-radius:14px;padding:16px 20px;">
                        <i class="fas fa-gift" style="color:var(--primary-color);font-size:20px;"></i>
                        <div style="flex:1;">
                            <div style="font-size:11px;color:#6b7280;text-transform:uppercase;letter-spacing:1px;margin-bottom:4px;">Kode kamu</div>
                            <div style="font-size:22px;font-weight:800;letter-spacing:4px;color:var(--primary-color);" id="ref-code">{{ $user->referral_code ?? '—' }}</div>
                        </div>
                        @if($user->referral_code)
                        <button onclick="copyRefLink()" style="padding:10px 18px;background:var(--gradient-primary);color:white;border:none;border-radius:10px;font-weight:600;font-size:13px;cursor:pointer;" id="copy-btn">
                            <i class="fas fa-copy"></i> Salin Link
                        </button>
                        @endif
                    </div>

                    @if($user->referral_code)
                    <div style="margin-top:12px;font-size:12px;color:#9ca3af;word-break:break-all;" id="ref-link-display">
                        {{ url('/ref/' . $user->referral_code) }}
                    </div>
                    <div style="margin-top:12px;font-size:13px;color:#6b7280;">
                        Total teman yang daftar via kamu: <strong style="color:var(--primary-color);">{{ $user->referrals()->count() }}</strong>
                    </div>
                    @endif
                </div>

                {{-- Password form --}}
                <div style="background:white;border-radius:20px;padding:28px;box-shadow:0 1px 4px rgba(0,0,0,.05);">
                    <h2 style="font-size:17px;font-weight:800;margin-bottom:4px;">{{ __('messages.account.change_password') }}</h2>
                    <p style="font-size:13px;color:#6b7280;margin-bottom:24px;">{{ app()->getLocale()==='id' ? 'Gunakan password yang kuat dan unik.' : 'Use a strong and unique password.' }}</p>

                    @if($user->google_id && !$user->password)
                    <div style="background:#fef3c7;color:#92400e;padding:12px 16px;border-radius:10px;font-size:13px;">
                        <i class="fas fa-info-circle mr-1"></i>
                        {{ app()->getLocale()==='id' ? 'Akun ini login via Google. Ganti password tidak tersedia.' : 'This account uses Google login. Password change is not available.' }}
                    </div>
                    @else
                    <form action="{{ route('account.password.update') }}" method="POST">
                        @csrf @method('PUT')
                        <div style="display:grid;grid-template-columns:1fr 1fr 1fr;gap:16px;margin-bottom:20px;">
                            <div>
                                <label class="acc-label">{{ __('messages.account.current_password') }}</label>
                                <input type="password" name="current_password" required class="acc-input @error('current_password') acc-input-err @enderror">
                                @error('current_password')<p class="acc-err">{{ $message }}</p>@enderror
                            </div>
                            <div>
                                <label class="acc-label">{{ __('messages.account.new_password') }}</label>
                                <input type="password" name="password" required class="acc-input @error('password') acc-input-err @enderror">
                                @error('password')<p class="acc-err">{{ $message }}</p>@enderror
                            </div>
                            <div>
                                <label class="acc-label">{{ __('messages.account.confirm_password') }}</label>
                                <input type="password" name="password_confirmation" required class="acc-input">
                            </div>
                        </div>
                        <button type="submit" class="acc-btn-primary">{{ __('messages.account.save_password') }}</button>
                    </form>
                    @endif
                </div>

            </div>
        </div>
    </div>
</section>

@include('pages.account._styles')

@push('scripts')
<script>
function copyRefLink() {
    const link = '{{ url('/ref/' . ($user->referral_code ?? '')) }}';
    navigator.clipboard.writeText(link).then(() => {
        const btn = document.getElementById('copy-btn');
        btn.innerHTML = '<i class="fas fa-check"></i> Tersalin!';
        setTimeout(() => btn.innerHTML = '<i class="fas fa-copy"></i> Salin Link', 2000);
    });
}
</script>
@endpush
@endsection
