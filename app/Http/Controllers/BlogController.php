<?php

namespace App\Http\Controllers;

use App\Models\BlogPost;
use App\Models\BlogComment;
use App\Helpers\SeoMeta;
use Illuminate\Http\Request;

class BlogController extends Controller
{
    public function index(Request $request)
    {
        $posts = BlogPost::query()
            ->where('is_published', true)
            ->when($request->filled('search'), function ($query) use ($request) {
                $search = $request->string('search')->trim();

                $query->where(function ($subQuery) use ($search) {
                    $subQuery->where('title', 'like', "%{$search}%")
                        ->orWhere('excerpt', 'like', "%{$search}%")
                        ->orWhere('content', 'like', "%{$search}%")
                        ->orWhere('category', 'like', "%{$search}%")
                        ->orWhere('author', 'like', "%{$search}%");
                });
            })
            ->when($request->filled('category') && $request->category !== 'all', function ($query) use ($request) {
                $query->where('category_slug', $request->category);
            })
            ->latest('published_at')
            ->latest()
            ->paginate(6)
            ->withQueryString()
            ->through(fn (BlogPost $post) => $this->transformPost($post));

        $categories = $this->getCategories();

        return view('pages.blog', compact('posts', 'categories'));
    }

    public function show($slug)
    {
        $blogPost = BlogPost::where('slug', $slug)
            ->where('is_published', true)
            ->firstOrFail();

        $post = $this->transformPost($blogPost, true);
        $relatedPosts = BlogPost::where('is_published', true)
            ->where('category_slug', $blogPost->category_slug)
            ->whereKeyNot($blogPost->id)
            ->latest('published_at')
            ->take(3)
            ->get()
            ->map(fn (BlogPost $item) => $this->transformPost($item));

        // Real comments from DB — top-level only, replies eager-loaded
        $comments = BlogComment::where('blog_post_id', $blogPost->id)
            ->whereNull('parent_id')
            ->where('is_approved', true)
            ->with(['user', 'replies.user'])
            ->latest()
            ->get();

        return view('pages.blog-detail', compact('post', 'blogPost', 'relatedPosts', 'comments'))
            ->with('seo', SeoMeta::blog($blogPost));
    }

    private function transformPost(BlogPost $post, bool $detail = false): array
    {
        return [
            'id' => $post->id,
            'title' => $post->title,
            'slug' => $post->slug,
            'excerpt' => $post->excerpt ?: str($post->content)->stripTags()->limit(140)->toString(),
            'content' => $post->content,
            'category' => $post->category ?: 'Uncategorized',
            'category_slug' => $post->category_slug ?: 'uncategorized',
            'author' => $post->author ?: 'LongLeaf Team',
            'author_avatar' => $post->author_avatar ?: 'https://www.gravatar.com/avatar/?d=mp&s=100',
            'date' => optional($post->published_at ?: $post->created_at)->format('d M Y'),
            'views' => number_format((int) $post->views),
            'comments' => count($this->getComments($post->id)),
            'image' => $post->image ?: 'https://via.placeholder.com/400x300',
            'badge' => $post->category ?: 'Artikel',
            'full_content' => $detail ? ($post->content ?: nl2br(e($post->excerpt))) : null,
        ];
    }

    private function getCategories(): array
    {
        $categoryCounts = BlogPost::query()
            ->selectRaw('category, category_slug, COUNT(*) as total')
            ->where('is_published', true)
            ->groupBy('category', 'category_slug')
            ->orderBy('category')
            ->get();

        $categories = [[
            'name' => 'Semua Artikel',
            'slug' => 'all',
            'count' => BlogPost::where('is_published', true)->count(),
        ]];

        foreach ($categoryCounts as $category) {
            $categories[] = [
                'name' => $category->category ?: 'Uncategorized',
                'slug' => $category->category_slug ?: 'uncategorized',
                'count' => $category->total,
            ];
        }

        return $categories;
    }

    private function getComments($postId): array
    {
        return [
            [
                'name' => 'Rina Susanti',
                'avatar' => 'https://images.unsplash.com/photo-1438761681033-6461ffad8d80?w=100&h=100&fit=crop',
                'rating' => 5,
                'date' => '2 hari lalu',
                'comment' => 'Artikel yang sangat membantu! Saya baru sadar selama ini perawatan tanaman saya kurang tepat.',
                'verified' => true,
            ],
            [
                'name' => 'Adi Pratama',
                'avatar' => 'https://images.unsplash.com/photo-1500648767791-00dcc994a43e?w=100&h=100&fit=crop',
                'rating' => 5,
                'date' => '5 hari lalu',
                'comment' => 'Tipsnya praktis dan mudah diterapkan. Sangat membantu untuk pemula.',
                'verified' => true,
            ],
        ];
    }
}
