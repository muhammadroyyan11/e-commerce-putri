<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BlogPost;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class BlogPostController extends Controller
{
    public function index()
    {
        $posts = BlogPost::latest()->get();
        return view('admin.blog_posts.index', compact('posts'));
    }

    public function create()
    {
        return view('admin.blog_posts.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'excerpt' => 'nullable|string',
            'content' => 'nullable|string',
            'category' => 'nullable|string|max:255',
            'author' => 'nullable|string|max:255',
            'author_avatar' => 'nullable|string|max:255',
            'author_avatar_file' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'image' => 'nullable|string|max:255',
            'image_file' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'is_published' => 'boolean',
        ]);

        // Handle thumbnail image upload
        if ($request->hasFile('image_file')) {
            $validated['image'] = $this->uploadFile($request->file('image_file'));
        }

        // Handle author avatar upload
        if ($request->hasFile('author_avatar_file')) {
            $validated['author_avatar'] = $this->uploadFile($request->file('author_avatar_file'));
        }

        // Auto-fill author from logged-in user if empty
        if (empty($validated['author'])) {
            $validated['author'] = auth()->user()->name;
        }

        // Auto-fill author avatar from logged-in user if empty
        if (empty($validated['author_avatar'])) {
            $validated['author_avatar'] = $this->getUserAvatar();
        }

        $validated['slug'] = Str::slug($validated['title']);
        $validated['category_slug'] = Str::slug($validated['category'] ?? 'uncategorized');
        $validated['is_published'] = $request->boolean('is_published', false);
        $validated['published_at'] = $validated['is_published'] ? now() : null;

        BlogPost::create($validated);

        return redirect()->route('admin.blog-posts.index')->with('success', 'Artikel berhasil ditambahkan.');
    }

    public function edit(BlogPost $blogPost)
    {
        return view('admin.blog_posts.edit', compact('blogPost'));
    }

    public function update(Request $request, BlogPost $blogPost)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'excerpt' => 'nullable|string',
            'content' => 'nullable|string',
            'category' => 'nullable|string|max:255',
            'author' => 'nullable|string|max:255',
            'author_avatar' => 'nullable|string|max:255',
            'author_avatar_file' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'image' => 'nullable|string|max:255',
            'image_file' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'is_published' => 'boolean',
        ]);

        // Handle thumbnail image upload
        if ($request->hasFile('image_file')) {
            $validated['image'] = $this->uploadFile($request->file('image_file'));
        }

        // Handle author avatar upload
        if ($request->hasFile('author_avatar_file')) {
            $validated['author_avatar'] = $this->uploadFile($request->file('author_avatar_file'));
        }

        // Auto-fill author from logged-in user if empty
        if (empty($validated['author'])) {
            $validated['author'] = auth()->user()->name;
        }

        // Auto-fill author avatar from logged-in user if empty
        if (empty($validated['author_avatar'])) {
            $validated['author_avatar'] = $this->getUserAvatar();
        }

        $validated['slug'] = Str::slug($validated['title']);
        $validated['category_slug'] = Str::slug($validated['category'] ?? 'uncategorized');
        $validated['is_published'] = $request->boolean('is_published', false);
        if ($validated['is_published'] && !$blogPost->published_at) {
            $validated['published_at'] = now();
        }

        $blogPost->update($validated);

        return redirect()->route('admin.blog-posts.index')->with('success', 'Artikel berhasil diperbarui.');
    }

    public function destroy(BlogPost $blogPost)
    {
        $blogPost->delete();
        return redirect()->route('admin.blog-posts.index')->with('success', 'Artikel berhasil dihapus.');
    }

    private function uploadFile($file)
    {
        $filename = Str::uuid() . '.' . $file->getClientOriginalExtension();
        $path = public_path('uploads/blog');

        if (!file_exists($path)) {
            mkdir($path, 0755, true);
        }

        $file->move($path, $filename);

        return asset('uploads/blog/' . $filename);
    }

    private function getUserAvatar()
    {
        $email = auth()->user()->email;
        return 'https://www.gravatar.com/avatar/' . md5(strtolower(trim($email))) . '?d=mp&s=100';
    }
}
