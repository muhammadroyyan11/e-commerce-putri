<?php

namespace App\Http\Controllers;

use App\Models\BlogComment;
use App\Models\BlogPost;
use Illuminate\Http\Request;

class BlogCommentController extends Controller
{
    public function store(Request $request, BlogPost $blogPost)
    {
        $isAuth = auth()->check();

        $rules = [
            'body'      => 'required|string|max:2000',
            'parent_id' => 'nullable|exists:blog_comments,id',
        ];

        if (! $isAuth) {
            $rules['guest_name']  = 'required|string|max:100';
            $rules['guest_email'] = 'required|email|max:255';
        }

        $request->validate($rules);

        BlogComment::create([
            'blog_post_id' => $blogPost->id,
            'user_id'      => $isAuth ? auth()->id() : null,
            'parent_id'    => $request->parent_id ?: null,
            'guest_name'   => $isAuth ? null : $request->guest_name,
            'guest_email'  => $isAuth ? null : $request->guest_email,
            'body'         => $request->body,
            'is_approved'  => true,
        ]);

        return back()->with('comment_success', app()->getLocale() === 'id'
            ? 'Komentar berhasil dikirim!'
            : 'Comment posted successfully!');
    }

    public function destroy(BlogComment $comment)
    {
        // Only the comment author or admin can delete
        abort_unless(
            auth()->check() && (auth()->id() === $comment->user_id || auth()->user()->is_admin),
            403
        );

        $comment->delete();

        return back()->with('comment_success', app()->getLocale() === 'id'
            ? 'Komentar dihapus.'
            : 'Comment deleted.');
    }
}
