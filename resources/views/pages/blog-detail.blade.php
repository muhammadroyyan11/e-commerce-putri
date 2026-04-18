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
                <section style="margin-top:50px;" id="comments">
                    <h3 style="font-size:22px;font-weight:800;margin-bottom:24px;display:flex;align-items:center;gap:10px;">
                        <i class="fas fa-comments" style="color:var(--primary-color);font-size:18px;"></i>
                        {{ app()->getLocale()==='id' ? 'Komentar' : 'Comments' }}
                        <span style="background:var(--primary-light);color:var(--primary-dark);font-size:13px;padding:3px 10px;border-radius:999px;">{{ $comments->count() }}</span>
                    </h3>

                    @if(session('comment_success'))
                    <div style="background:#dcfce7;color:#166534;padding:12px 16px;border-radius:10px;margin-bottom:20px;font-size:14px;font-weight:600;display:flex;align-items:center;gap:8px;">
                        <i class="fas fa-check-circle"></i> {{ session('comment_success') }}
                    </div>
                    @endif

                    {{-- Comment list --}}
                    @forelse($comments as $comment)
                    <div class="comment-thread" style="margin-bottom:20px;">
                        @include('partials.blog-comment', ['comment' => $comment, 'blogPost' => $blogPost, 'depth' => 0])
                    </div>
                    @empty
                    <div style="text-align:center;padding:32px;background:var(--bg-light);border-radius:14px;color:#9ca3af;margin-bottom:24px;">
                        <i class="far fa-comment-dots" style="font-size:32px;display:block;margin-bottom:8px;"></i>
                        <p style="font-size:14px;">{{ app()->getLocale()==='id' ? 'Belum ada komentar. Jadilah yang pertama!' : 'No comments yet. Be the first!' }}</p>
                    </div>
                    @endforelse

                    {{-- Write a comment --}}
                    <div style="background:var(--bg-light);border-radius:16px;padding:24px;margin-top:28px;" id="comment-form-section">
                        <h4 style="font-size:16px;font-weight:800;margin-bottom:16px;">
                            {{ app()->getLocale()==='id' ? '✍️ Tulis Komentar' : '✍️ Write a Comment' }}
                        </h4>
                        <form action="{{ route('blog.comments.store', $blogPost) }}" method="POST">
                            @csrf
                            <input type="hidden" name="parent_id" id="reply-parent-id" value="">

                            {{-- Reply indicator --}}
                            <div id="reply-indicator" style="display:none;background:#dbeafe;color:#1e40af;padding:8px 14px;border-radius:8px;font-size:13px;font-weight:600;margin-bottom:12px;display:none;align-items:center;justify-content:space-between;">
                                <span id="reply-to-name"></span>
                                <button type="button" onclick="cancelReply()" style="background:none;border:none;cursor:pointer;color:#1e40af;font-size:16px;">✕</button>
                            </div>

                            @guest
                            <div style="display:grid;grid-template-columns:1fr 1fr;gap:12px;margin-bottom:12px;">
                                <div>
                                    <label style="font-size:13px;font-weight:600;color:#374151;display:block;margin-bottom:5px;">{{ app()->getLocale()==='id' ? 'Nama *' : 'Name *' }}</label>
                                    <input type="text" name="guest_name" value="{{ old('guest_name') }}" required
                                        style="width:100%;padding:10px 14px;border:1.5px solid #e5e7eb;border-radius:10px;font-size:14px;font-family:inherit;box-sizing:border-box;">
                                    @error('guest_name')<p style="color:#dc2626;font-size:12px;margin-top:3px;">{{ $message }}</p>@enderror
                                </div>
                                <div>
                                    <label style="font-size:13px;font-weight:600;color:#374151;display:block;margin-bottom:5px;">Email *</label>
                                    <input type="email" name="guest_email" value="{{ old('guest_email') }}" required
                                        style="width:100%;padding:10px 14px;border:1.5px solid #e5e7eb;border-radius:10px;font-size:14px;font-family:inherit;box-sizing:border-box;">
                                    @error('guest_email')<p style="color:#dc2626;font-size:12px;margin-top:3px;">{{ $message }}</p>@enderror
                                </div>
                            </div>
                            @endguest

                            <div style="margin-bottom:14px;">
                                <label style="font-size:13px;font-weight:600;color:#374151;display:block;margin-bottom:5px;">
                                    {{ app()->getLocale()==='id' ? 'Komentar *' : 'Comment *' }}
                                </label>
                                <textarea name="body" rows="4" required placeholder="{{ app()->getLocale()==='id' ? 'Tulis komentar Anda...' : 'Write your comment...' }}"
                                    style="width:100%;padding:12px 14px;border:1.5px solid #e5e7eb;border-radius:10px;font-size:14px;font-family:inherit;resize:vertical;box-sizing:border-box;">{{ old('body') }}</textarea>
                                @error('body')<p style="color:#dc2626;font-size:12px;margin-top:3px;">{{ $message }}</p>@enderror
                            </div>

                            <button type="submit"
                                style="display:inline-flex;align-items:center;gap:8px;padding:11px 22px;background:var(--gradient-primary);color:white;border:none;border-radius:10px;font-weight:700;font-size:14px;cursor:pointer;font-family:inherit;">
                                <i class="fas fa-paper-plane"></i>
                                {{ app()->getLocale()==='id' ? 'Kirim Komentar' : 'Post Comment' }}
                            </button>
                        </form>
                    </div>
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
@push('scripts')
<script>
function replyTo(commentId, authorName) {
    document.getElementById('reply-parent-id').value = commentId;
    const indicator = document.getElementById('reply-indicator');
    document.getElementById('reply-to-name').textContent =
        (document.documentElement.lang === 'id' ? 'Membalas ' : 'Replying to ') + authorName;
    indicator.style.display = 'flex';
    document.getElementById('comment-form-section').scrollIntoView({ behavior: 'smooth', block: 'start' });
    setTimeout(() => document.querySelector('textarea[name="body"]').focus(), 400);
}

function cancelReply() {
    document.getElementById('reply-parent-id').value = '';
    document.getElementById('reply-indicator').style.display = 'none';
}
</script>
@endpush
@endsection
