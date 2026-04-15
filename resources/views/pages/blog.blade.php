@extends('layouts.app')

@section('title', __('messages.blog.title', ['site' => App\Models\Setting::get('site_name', 'GreenHaven')]))

@section('content')
<!-- Page Banner -->
<section class="page-banner">
    <div class="container">
        <h1>{{ __('messages.blog.title', ['site' => App\Models\Setting::get('site_name', 'GreenHaven')]) }}</h1>
        <nav class="breadcrumb">
            <a href="{{ route('home') }}">{{ __('messages.common.home') }}</a>
            <span>/</span>
            <span>{{ __('messages.blog.breadcrumb') }}</span>
        </nav>
    </div>
</section>

<!-- Blog Section -->
<section style="padding: 60px 0; background: var(--bg-light);">
    <div class="container">
        <div class="blog-mobile-filters">
            <div class="sidebar-widget search-widget">
                <h3 class="widget-title"><i class="fas fa-search" style="margin-right: 8px; color: var(--primary-color);"></i> {{ __('messages.blog.search_article') }}</h3>
                <p class="search-helper">Cari judul atau topik artikel tanaman yang ingin Anda baca.</p>
                <form class="search-box" action="{{ route('blog') }}" method="GET">
                    <div class="search-shell">
                        <i class="fas fa-search"></i>
                        <input type="text" name="search" placeholder="{{ __('messages.blog.search_placeholder') }}" value="{{ request('search') }}">
                    </div>
                    @if(request()->filled('category'))
                        <input type="hidden" name="category" value="{{ request('category') }}">
                    @endif
                    <button type="submit">Cari</button>
                </form>
            </div>

            <div class="sidebar-widget">
                <h3 class="widget-title"><i class="fas fa-folder" style="margin-right: 8px; color: var(--primary-color);"></i> {{ __('messages.blog.categories') }}</h3>
                <ul class="category-list">
                    @foreach($categories as $category)
                    <li>
                        <a
                            href="{{ route('blog', array_filter(['category' => $category['slug'], 'search' => request('search')])) }}"
                            class="category-filter-link {{ request('category', 'all') === $category['slug'] ? 'active' : '' }}"
                        >
                            <span class="label-text">{{ $category['name'] }}</span>
                            <span class="count">({{ $category['count'] }})</span>
                        </a>
                    </li>
                    @endforeach
                </ul>
            </div>
        </div>

        <div class="blog-layout">
            <!-- Sidebar -->
            <aside class="blog-sidebar">
                <div class="sidebar-widget blog-desktop-filter search-widget">
                    <h3 class="widget-title"><i class="fas fa-search" style="margin-right: 8px; color: var(--primary-color);"></i> {{ __('messages.blog.search_article') }}</h3>
                    <p class="search-helper">Cari judul atau topik artikel tanaman yang ingin Anda baca.</p>
                    <form class="search-box" action="{{ route('blog') }}" method="GET">
                        <div class="search-shell">
                            <i class="fas fa-search"></i>
                            <input type="text" name="search" placeholder="{{ __('messages.blog.search_placeholder') }}" value="{{ request('search') }}">
                        </div>
                        @if(request()->filled('category'))
                            <input type="hidden" name="category" value="{{ request('category') }}">
                        @endif
                        <button type="submit">Cari</button>
                    </form>
                </div>

                <div class="sidebar-widget blog-desktop-filter">
                    <h3 class="widget-title"><i class="fas fa-folder" style="margin-right: 8px; color: var(--primary-color);"></i> {{ __('messages.blog.categories') }}</h3>
                    <ul class="category-list">
                        @foreach($categories as $category)
                        <li>
                            <a
                                href="{{ route('blog', array_filter(['category' => $category['slug'], 'search' => request('search')])) }}"
                                class="category-filter-link {{ request('category', 'all') === $category['slug'] ? 'active' : '' }}"
                            >
                                <span class="label-text">{{ $category['name'] }}</span>
                                <span class="count">({{ $category['count'] }})</span>
                            </a>
                        </li>
                        @endforeach
                    </ul>
                </div>

                <div class="sidebar-widget newsletter-widget">
                    <h3 class="widget-title"><i class="fas fa-envelope" style="margin-right: 8px;"></i> {{ __('messages.blog.newsletter') }}</h3>
                    <p>{{ __('messages.blog.newsletter_desc') }}</p>
                    <form action="{{ route('newsletter.subscribe') }}" method="POST">
                        @csrf
                        <input type="email" name="email" placeholder="{{ __('messages.header.email') }}" required>
                        <button type="submit" class="btn-primary">{{ __('messages.button.subscribe') }}</button>
                    </form>
                </div>
            </aside>

            <!-- Main Content -->
            <div class="blog-main">
                <div class="filter-bar">
                    <div class="results-info">
                        {{ __('messages.blog.results', ['start' => $posts->firstItem() ?? 0, 'end' => $posts->lastItem() ?? 0, 'total' => $posts->total()]) }}
                    </div>
                    @if(request()->filled('search') || (request()->filled('category') && request('category') !== 'all'))
                        <a href="{{ route('blog') }}" class="blog-reset-filter">Reset Filter</a>
                    @endif
                </div>

                <div class="blog-grid" id="blogGrid">
                    @foreach($posts as $post)
                    <article class="blog-card">
                        <div class="blog-image">
                            <img src="{{ $post['image'] }}" alt="{{ $post['title'] }}">
                            <span class="blog-badge">{{ $post['badge'] }}</span>
                            <div class="blog-overlay">
                                <a href="{{ route('blog.detail', $post['slug']) }}" class="read-more-btn">{{ __('messages.button.read_more') }}</a>
                            </div>
                        </div>
                        <div class="blog-content">
                            <div class="blog-meta">
                                <span class="category"><i class="fas fa-tag"></i> {{ $post['category'] }}</span>
                                <span class="date"><i class="far fa-calendar"></i> {{ $post['date'] }}</span>
                            </div>
                            <h3 class="blog-title"><a href="{{ route('blog.detail', $post['slug']) }}">{{ $post['title'] }}</a></h3>
                            <p class="blog-excerpt">{{ $post['excerpt'] }}</p>
                            <div class="blog-footer">
                                <div class="author">
                                    <img src="{{ $post['author_avatar'] }}" alt="{{ $post['author'] }}">
                                    <span>{{ $post['author'] }}</span>
                                </div>
                                <div class="stats">
                                    <span><i class="far fa-eye"></i> {{ $post['views'] }}</span>
                                    <span><i class="far fa-comment"></i> {{ $post['comments'] }}</span>
                                </div>
                            </div>
                        </div>
                    </article>
                    @endforeach
                </div>

                @if($posts->hasPages())
                    <div class="pagination">
                        {{ $posts->links('pagination::bootstrap-4') }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</section>

<style>
    .blog-mobile-filters {
        display: none;
        margin-bottom: 24px;
    }

    .search-widget {
        background: linear-gradient(180deg, #ffffff 0%, #f8fffb 100%);
    }

    .search-helper {
        color: #64748b;
        font-size: 14px;
        line-height: 1.6;
        margin: -4px 0 14px;
    }

    .search-box {
        display: grid;
        gap: 12px;
    }

    .search-shell {
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 12px 14px;
        border: 1px solid #d7e5dd;
        border-radius: 16px;
        background: #fff;
        box-shadow: inset 0 1px 2px rgba(15, 23, 42, 0.04);
    }

    .search-shell i {
        color: #16a34a;
        font-size: 14px;
    }

    .search-shell input {
        border: none;
        background: transparent;
        width: 100%;
        padding: 0;
        font-size: 14px;
        color: #0f172a;
        outline: none;
    }

    .search-box button {
        width: 100%;
        height: 46px;
        border: none;
        border-radius: 14px;
        background: linear-gradient(135deg, #166534 0%, #16a34a 100%);
        color: #fff;
        font-weight: 700;
        letter-spacing: 0.01em;
    }

    .category-filter-link {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 12px;
        padding: 12px 14px;
        border-radius: 14px;
        color: #334155;
        transition: 0.2s ease;
    }

    .category-filter-link:hover {
        background: #f0fdf4;
        color: #166534;
    }

    .category-filter-link.active {
        background: linear-gradient(135deg, #166534 0%, #16a34a 100%);
        color: #fff;
    }

    .category-filter-link .count {
        font-size: 12px;
        padding: 4px 8px;
        border-radius: 999px;
        background: rgba(15, 23, 42, 0.06);
    }

    .category-filter-link.active .count {
        background: rgba(255,255,255,0.18);
        color: #fff;
    }

    .blog-reset-filter {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        padding: 8px 14px;
        border-radius: 999px;
        background: #fff;
        color: #166534;
        border: 1px solid #bbf7d0;
        font-weight: 600;
        font-size: 13px;
    }

    @media (max-width: 992px) {
        .blog-mobile-filters {
            display: grid;
            gap: 16px;
        }

        .blog-desktop-filter {
            display: none;
        }
    }
</style>
@endsection
