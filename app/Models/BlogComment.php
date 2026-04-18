<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BlogComment extends Model
{
    protected $fillable = [
        'blog_post_id', 'user_id', 'parent_id',
        'guest_name', 'guest_email', 'body', 'is_approved',
    ];

    protected $casts = ['is_approved' => 'boolean'];

    public function post()
    {
        return $this->belongsTo(BlogPost::class, 'blog_post_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function parent()
    {
        return $this->belongsTo(BlogComment::class, 'parent_id');
    }

    public function replies()
    {
        return $this->hasMany(BlogComment::class, 'parent_id')->where('is_approved', true)->with('user')->latest();
    }

    /** Display name — logged-in user or guest */
    public function getAuthorNameAttribute(): string
    {
        return $this->user?->name ?? $this->guest_name ?? 'Anonymous';
    }

    /** Initial letter for avatar */
    public function getInitialAttribute(): string
    {
        return strtoupper(substr($this->author_name, 0, 1));
    }
}
