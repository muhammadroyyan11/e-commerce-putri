@php $isOwn = auth()->check() && auth()->id() === $comment->user_id; @endphp

<div style="display:flex;gap:12px;{{ $depth > 0 ? 'margin-left:40px;margin-top:12px;' : '' }}">
    {{-- Avatar --}}
    <div style="width:40px;height:40px;border-radius:50%;background:var(--gradient-primary);display:flex;align-items:center;justify-content:center;color:white;font-weight:800;font-size:15px;flex-shrink:0;">
        {{ $comment->initial }}
    </div>

    <div style="flex:1;min-width:0;">
        <div style="background:white;border-radius:14px;padding:16px 18px;border:1px solid #f1f5f9;">
            {{-- Header --}}
            <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:8px;flex-wrap:wrap;gap:6px;">
                <div style="display:flex;align-items:center;gap:8px;">
                    <span style="font-weight:700;font-size:14px;color:#111827;">{{ $comment->author_name }}</span>
                    @if($comment->user_id)
                    <span style="background:#dcfce7;color:#166534;font-size:10px;font-weight:700;padding:2px 8px;border-radius:999px;">
                        {{ app()->getLocale()==='id' ? 'Member' : 'Member' }}
                    </span>
                    @endif
                    @if($depth > 0)
                    <span style="background:#dbeafe;color:#1e40af;font-size:10px;font-weight:700;padding:2px 8px;border-radius:999px;">
                        {{ app()->getLocale()==='id' ? 'Balasan' : 'Reply' }}
                    </span>
                    @endif
                </div>
                <div style="display:flex;align-items:center;gap:8px;">
                    <span style="font-size:12px;color:#9ca3af;">{{ $comment->created_at->diffForHumans() }}</span>
                    @if($isOwn || (auth()->check() && auth()->user()->is_admin))
                    <form action="{{ route('blog.comments.destroy', $comment) }}" method="POST" style="margin:0;"
                          onsubmit="return confirm('{{ app()->getLocale()==='id' ? 'Hapus komentar ini?' : 'Delete this comment?' }}')">
                        @csrf @method('DELETE')
                        <button type="submit" style="background:none;border:none;cursor:pointer;color:#ef4444;font-size:12px;padding:0;">
                            <i class="fas fa-trash"></i>
                        </button>
                    </form>
                    @endif
                </div>
            </div>

            {{-- Body --}}
            <p style="font-size:14px;color:#374151;line-height:1.7;margin:0;">{{ $comment->body }}</p>
        </div>

        {{-- Reply button --}}
        @if($depth === 0)
        <button onclick="replyTo({{ $comment->id }}, '{{ addslashes($comment->author_name) }}')"
            style="margin-top:6px;margin-left:4px;background:none;border:none;cursor:pointer;font-size:12px;font-weight:600;color:var(--primary-color);display:inline-flex;align-items:center;gap:4px;font-family:inherit;">
            <i class="fas fa-reply" style="font-size:11px;"></i>
            {{ app()->getLocale()==='id' ? 'Balas' : 'Reply' }}
        </button>
        @endif

        {{-- Replies --}}
        @if($comment->replies->count() > 0)
        <div style="margin-top:8px;">
            @foreach($comment->replies as $reply)
                @include('partials.blog-comment', ['comment' => $reply, 'blogPost' => $blogPost, 'depth' => 1])
            @endforeach
        </div>
        @endif
    </div>
</div>
