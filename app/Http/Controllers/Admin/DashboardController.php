<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use App\Models\BlogPost;
use App\Models\Order;
use App\Models\Newsletter;
use Illuminate\Support\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'products' => Product::count(),
            'active_products' => Product::where('is_active', true)->count(),
            'categories' => Category::count(),
            'blog_posts' => BlogPost::count(),
            'published_posts' => BlogPost::where('is_published', true)->count(),
            'orders' => Order::count(),
            'newsletters' => Newsletter::count(),
            'pending_orders' => Order::where('status', 'pending')->count(),
            'processing_orders' => Order::whereIn('status', ['awaiting_confirmation', 'processing', 'shipped'])->count(),
            'completed_orders' => Order::where('status', 'completed')->count(),
            'total_revenue' => Order::whereIn('status', ['completed', 'shipped'])->sum('total'),
        ];

        $recentOrders = Order::latest()->take(5)->get();
        $recentProducts = Product::latest()->take(5)->get();
        $statusOrder = ['pending', 'awaiting_confirmation', 'processing', 'shipped', 'completed', 'cancelled'];
        $statusBreakdown = collect($statusOrder)->map(function ($status) {
            return [
                'status' => $status,
                'count' => Order::where('status', $status)->count(),
            ];
        });

        $dailyOrders = collect(range(6, 0))->map(function ($daysAgo) {
            $date = Carbon::today()->subDays($daysAgo);

            return [
                'label' => $date->format('d M'),
                'orders' => Order::whereDate('created_at', $date)->count(),
                'revenue' => Order::whereDate('created_at', $date)
                    ->whereIn('status', ['completed', 'shipped'])
                    ->sum('total'),
            ];
        });

        return view('admin.dashboard.index', compact('stats', 'recentOrders', 'recentProducts', 'statusBreakdown', 'dailyOrders'));
    }
}
