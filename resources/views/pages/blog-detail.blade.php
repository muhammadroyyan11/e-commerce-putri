@extends('layouts.app')

@section('title', $post['title'] . ' - ' . App\Models\Setting::get('site_name', 'LongLeaf'))

@section('content')
<!-- Page Banner -->
<section class="page-banner blog-banner">
    <div class="container">
        <nav class="breadcrumb">
            <a href="{{ route('home') }}">{{ __('messages.common.home') }}</a>
            <span>/</span>
            <a href="{{ route('blog') }}">{{ __('messages.blog.breadcrumb') }}</a>
            <span>/</span>
            <span>{{ $post['title'] }}</span>
        </nav>
    </div>
</section>

<!-- Blog Detail -->
<section style="padding: 40px 0 60px; background: var(--bg-light);">
    <div class="container">
        <div class="blog-detail-layout">
            <!-- Main Content -->
            <article style="background: white; border-radius: 20px; padding: 40px; box-shadow: var(--shadow-sm);">
                <span style="display: inline-block; background: var(--primary-light); color: var(--primary-dark); padding: 6px 16px; border-radius: 20px; font-size: 13px; font-weight: 600; margin-bottom: 16px;">{{ $post['category'] }}</span>
                <h1 style="font-size: 36px; font-weight: 700; line-height: 1.3; margin-bottom: 24px; color: var(--text-dark);">{{ $post['title'] }}</h1>
                
                <div style="display: flex; align-items: center; gap: 20px; margin-bottom: 30px;">
                    <div style="display: flex; align-items: center; gap: 12px;">
                        <img src="{{ $post['author_avatar'] }}" alt="{{ $post['author'] }}" style="width: 50px; height: 50px; border-radius: 50%; object-fit: cover;">
                        <div>
                            <span style="display: block; font-weight: 600; color: var(--text-dark);">{{ $post['author'] }}</span>
                            <span style="font-size: 13px; color: var(--text-muted);">{{ __('messages.blog.expert') }}</span>
                        </div>
                    </div>
                    <span style="font-size: 14px; color: var(--text-light);"><i class="far fa-calendar" style="margin-right: 6px;"></i> {{ $post['date'] }}</span>
                </div>

                <img src="{{ $post['image'] }}" alt="{{ $post['title'] }}" style="width: 100%; height: 400px; object-fit: cover; border-radius: 16px; margin-bottom: 30px;">

                <div style="font-size: 16px; line-height: 1.8; color: var(--text-medium);">
                    <p style="font-size: 20px; font-weight: 500; color: var(--text-dark); margin-bottom: 30px;">{{ $post['excerpt'] }}</p>
                    
                    <p>{{ __('messages.blog.full_content') }}</p>
                    
                    <h2 style="font-size: 28px; font-weight: 700; color: var(--text-dark); margin: 40px 0 20px;">{{ __('messages.blog.conclusion') }}</h2>
                    <p>{{ __('messages.blog.conclusion_text') }}</p>
                </div>

                <!-- Comments -->
                <section style="margin-top: 50px;">
                    <h3 style="font-size: 24px; font-weight: 700; margin-bottom: 30px;">{{ __('messages.blog.comments') }} ({{ count($comments) }})</h3>
                    
                    @foreach($comments as $comment)
                    <div style="display: flex; gap: 16px; margin-bottom: 24px;">
                        <img src="{{ $comment['avatar'] }}" alt="{{ $comment['name'] }}" style="width: 50px; height: 50px; border-radius: 50%; object-fit: cover; flex-shrink: 0;">
                        <div style="flex: 1; background: var(--bg-light); border-radius: 12px; padding: 20px;">
                            <div style="display: flex; align-items: center; gap: 12px; margin-bottom: 10px;">
                                <h5 style="font-size: 16px; font-weight: 600;">{{ $comment['name'] }}</h5>
                                <span style="font-size: 13px; color: var(--text-muted);">{{ $comment['date'] }}</span>
                            </div>
                            <div style="color: #fbbf24; font-size: 12px; margin-bottom: 10px;">
                                @for($i = 0; $i < $comment['rating']; $i++)
                                    <i class="fas fa-star"></i>
                                @endfor
                            </div>
                            <p style="color: var(--text-medium); line-height: 1.6; margin: 0;">{{ $comment['comment'] }}</p>
                        </div>
                    </div>
                    @endforeach
                </section>
            </article>

            <!-- Sidebar -->
            <aside style="position: sticky; top: 92px; height: fit-content;">
                <div style="background: var(--gradient-primary); border-radius: 16px; padding: 24px; color: white; margin-bottom: 24px;">
                    <h3 style="font-size: 18px; font-weight: 600; margin-bottom: 12px;"><i class="fas fa-envelope" style="margin-right: 8px;"></i> {{ __('messages.blog.newsletter') }}</h3>
                    <p style="font-size: 14px; margin-bottom: 16px; opacity: 0.9;">{{ __('messages.blog.newsletter_desc') }}</p>
                    <form action="{{ route('newsletter.subscribe') }}" method="POST">
                        @csrf
                        <input type="email" name="email" placeholder="{{ __('messages.header.email') }}" required style="width: 100%; padding: 12px 16px; border: none; border-radius: 10px; margin-bottom: 12px;">
                        <button type="submit" style="width: 100%; padding: 12px; background: var(--secondary-color); color: white; border: none; border-radius: 10px; font-weight: 600; cursor: pointer;">{{ __('messages.button.subscribe') }}</button>
                    </form>
                </div>
            </aside>
        </div>
    </div>
</section>
@endsection
