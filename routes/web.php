<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ShopController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\CustomerOrderController;
use App\Http\Controllers\PaymentConfirmationController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\CustomerAuthController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\AiController;
use App\Http\Controllers\MidtransController;
use App\Http\Controllers\Admin\AdminAuthController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\BlogPostController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\NewsletterController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\PaymentMethodController;
use App\Http\Controllers\Admin\PaymentConfirmationController as AdminPaymentConfirmationController;
use App\Http\Controllers\Admin\ApiSettingController as AdminApiSettingController;
use App\Http\Controllers\Admin\ShippingZoneController as AdminShippingZoneController;
use App\Http\Controllers\Admin\CouponController as AdminCouponController;
use App\Http\Controllers\CouponController;
use App\Http\Controllers\ShippingController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\WishlistController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Home Route
Route::get('/', [HomeController::class, 'index'])->name('home');

// Customer Auth Routes
Route::middleware('guest')->group(function () {
    Route::get('/login', [CustomerAuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [CustomerAuthController::class, 'login']);
    Route::get('/register', [CustomerAuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [CustomerAuthController::class, 'register']);
    Route::get('/auth/google', [CustomerAuthController::class, 'redirectToGoogle'])->name('auth.google');
    Route::get('/auth/google/callback', [CustomerAuthController::class, 'handleGoogleCallback'])->name('auth.google.callback');
});

Route::post('/logout', [CustomerAuthController::class, 'logout'])->name('logout')->middleware('auth');

// Shop Routes
Route::get('/shop', [ShopController::class, 'index'])->name('shop');
Route::get('/shop/{slug}', [ShopController::class, 'show'])->name('product.detail');

// Category Routes
Route::get('/category/indoor', [ShopController::class, 'indoor'])->name('category.indoor');
Route::get('/category/outdoor', [ShopController::class, 'outdoor'])->name('category.outdoor');
Route::get('/category/succulent', [ShopController::class, 'succulent'])->name('category.succulent');
Route::get('/category/rare', [ShopController::class, 'rare'])->name('category.rare');

// Cart Routes (Require Auth)
Route::middleware('auth')->group(function () {
    Route::get('/cart', [CartController::class, 'index'])->name('cart');
    Route::get('/wishlist', [WishlistController::class, 'index'])->name('wishlist');
    Route::post('/cart/add', [CartController::class, 'add'])->name('cart.add');
    Route::post('/cart/update', [CartController::class, 'update'])->name('cart.update');
    Route::post('/cart/remove', [CartController::class, 'remove'])->name('cart.remove');

    // Checkout Routes
    Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout');
    Route::post('/checkout/process', [CheckoutController::class, 'process'])->name('checkout.process');
    Route::post('/coupon/apply', [CouponController::class, 'apply'])->name('coupon.apply');
    Route::post('/shipping/options', [ShippingController::class, 'getOptions'])->name('shipping.options');
    Route::get('/shipping/cities', [ShippingController::class, 'getCities'])->name('shipping.cities');
    Route::get('/order-success', [CheckoutController::class, 'success'])->name('order.success');
    Route::get('/account/orders', [CustomerOrderController::class, 'index'])->name('customer.orders.index');
    Route::get('/account/orders/{order}', [CustomerOrderController::class, 'show'])->name('customer.orders.show');
    Route::post('/account/orders/{order}/cancel', [CustomerOrderController::class, 'cancel'])->name('customer.orders.cancel');
    Route::post('/account/orders/{order}/change-payment', [CustomerOrderController::class, 'changePayment'])->name('customer.orders.change-payment');

    // Midtrans Custom Payment
    Route::get('/payment/{order}/select', [PaymentController::class, 'select'])->name('payment.select');
    Route::post('/payment/{order}/process', [PaymentController::class, 'process'])->name('payment.process');
    Route::get('/payment/{order}/detail', [PaymentController::class, 'detail'])->name('payment.detail');
    Route::get('/payment/{order}/qr-download', function (\App\Models\Order $order) {
        abort_if($order->customer_email !== auth()->user()->email, 403);
        abort_if(!$order->payment_qr_url, 404);
        $content = file_get_contents($order->payment_qr_url);
        return response($content, 200)
            ->header('Content-Type', 'image/png')
            ->header('Content-Disposition', 'attachment; filename="qr-' . $order->order_number . '.png"');
    })->name('payment.qr-download');

    // Payment Confirmation Routes
    Route::get('/orders/{order}/payment-confirmation', [PaymentConfirmationController::class, 'create'])->name('payment-confirmation.create');
    Route::post('/orders/{order}/payment-confirmation', [PaymentConfirmationController::class, 'store'])->name('payment-confirmation.store');

    // Review Routes
    Route::post('/orders/{order}/reviews', [ReviewController::class, 'store'])->name('reviews.store');

    // Account — Profile & Addresses
    Route::get('/account/profile',                    [\App\Http\Controllers\AccountController::class, 'profile'])->name('account.profile');
    Route::put('/account/profile',                    [\App\Http\Controllers\AccountController::class, 'updateProfile'])->name('account.profile.update');
    Route::put('/account/password',                   [\App\Http\Controllers\AccountController::class, 'updatePassword'])->name('account.password.update');
    Route::get('/account/addresses',                  [\App\Http\Controllers\AccountController::class, 'addresses'])->name('account.addresses');
    Route::post('/account/addresses',                 [\App\Http\Controllers\AccountController::class, 'storeAddress'])->name('account.addresses.store');
    Route::put('/account/addresses/{address}',        [\App\Http\Controllers\AccountController::class, 'updateAddress'])->name('account.addresses.update');
    Route::delete('/account/addresses/{address}',     [\App\Http\Controllers\AccountController::class, 'destroyAddress'])->name('account.addresses.destroy');
    Route::post('/account/addresses/{address}/primary', [\App\Http\Controllers\AccountController::class, 'setPrimaryAddress'])->name('account.addresses.primary');

    // AI Routes (auth required to prevent abuse)
    Route::post('/ai/chat', [AiController::class, 'chat'])->name('ai.chat');
});

// AI chat also available for guests (read-only product page)
Route::post('/ai/chat/guest', [AiController::class, 'chat'])->name('ai.chat.guest')
    ->middleware('throttle:20,1'); // 20 req/menit per IP

// Blog Routes
Route::get('/blog', [BlogController::class, 'index'])->name('blog');
Route::get('/blog/{slug}', [BlogController::class, 'show'])->name('blog.detail');

// Midtrans Routes
Route::post('/midtrans/notification', [MidtransController::class, 'notification'])->name('midtrans.notification')->withoutMiddleware([\App\Http\Middleware\VerifyCsrfToken::class]);
Route::get('/midtrans/finish', [MidtransController::class, 'finish'])->name('midtrans.finish');
Route::get('/midtrans/unfinish', [MidtransController::class, 'unfinish'])->name('midtrans.unfinish');
Route::get('/midtrans/error', [MidtransController::class, 'error'])->name('midtrans.error');

// Static Pages
Route::get('/about', function () {
    return view('pages.about');
})->name('about');

Route::get('/contact', function () {
    return view('pages.contact');
})->name('contact');

Route::get('/care-guide', function () {
    return view('pages.care-guide');
})->name('care.guide');

Route::get('/currency/{currency}', function ($currency) {
    $supported = ['IDR', 'USD', 'EUR', 'SGD', 'MYR', 'GBP', 'AUD', 'JPY'];
    if (in_array(strtoupper($currency), $supported)) {
        session(['currency' => strtoupper($currency)]);
    }
    return redirect()->back();
})->name('currency.switch');

Route::get('/locale/{locale}', function ($locale) {
    if (! in_array($locale, ['en', 'id'])) {
        abort(404);
    }

    session(['locale' => $locale]);
    app()->setLocale($locale);

    return redirect()->to(url()->previous() ?: route('home'));
})->name('locale.switch');

// Wishlist Route (AJAX)
Route::post('/wishlist/toggle', [ShopController::class, 'toggleWishlist'])->name('wishlist.toggle');

// F8: Shared wishlist (public, no auth)
Route::get('/wishlist/shared/{token}', [WishlistController::class, 'shared'])->name('wishlist.shared');

// FAQ public page
Route::get('/faq', [\App\Http\Controllers\FaqController::class, 'index'])->name('faq');

// Newsletter Subscription
Route::post('/newsletter/subscribe', [HomeController::class, 'subscribe'])->name('newsletter.subscribe');

// Sitemap
Route::get('/sitemap.xml', [\App\Http\Controllers\SitemapController::class, 'index'])->name('sitemap');

// Robots.txt
Route::get('/robots.txt', function () {
    $content = "User-agent: *\nAllow: /\nDisallow: /admin/\nDisallow: /cart\nDisallow: /checkout\nDisallow: /account/\n\nSitemap: " . route('sitemap');
    return response($content)->header('Content-Type', 'text/plain');
});

// Admin Routes
Route::prefix('admin')->name('admin.')->group(function () {
    // Guest admin routes
    Route::middleware('guest')->group(function () {
        Route::get('/login', [AdminAuthController::class, 'showLoginForm'])->name('login');
        Route::post('/login', [AdminAuthController::class, 'login']);
    });

    // Protected admin routes
    Route::middleware('admin')->group(function () {
        Route::post('/logout', [AdminAuthController::class, 'logout'])->name('logout');
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

        Route::resource('users', UserController::class);
        Route::resource('categories', CategoryController::class);
        Route::resource('products', ProductController::class);
        Route::resource('blog-posts', BlogPostController::class);
        Route::post('/upload-image', [\App\Http\Controllers\Admin\UploadController::class, 'uploadImage'])->name('upload-image');
        Route::resource('orders', OrderController::class);
        Route::resource('payment-methods', PaymentMethodController::class);
        Route::get('/payment-confirmations', [AdminPaymentConfirmationController::class, 'index'])->name('payment-confirmations.index');
        Route::get('/payment-confirmations/{paymentConfirmation}', [AdminPaymentConfirmationController::class, 'show'])->name('payment-confirmations.show');
        Route::post('/payment-confirmations/{paymentConfirmation}/confirm', [AdminPaymentConfirmationController::class, 'confirm'])->name('payment-confirmations.confirm');
        Route::post('/payment-confirmations/{paymentConfirmation}/reject', [AdminPaymentConfirmationController::class, 'reject'])->name('payment-confirmations.reject');
        Route::resource('newsletters', NewsletterController::class)->only(['index', 'destroy']);
        Route::resource('coupons', AdminCouponController::class);

        Route::get('/api-settings', [AdminApiSettingController::class, 'index'])->name('api-settings.index');
        Route::put('/api-settings', [AdminApiSettingController::class, 'update'])->name('api-settings.update');
        Route::resource('shipping-zones', AdminShippingZoneController::class)->except(['create','edit','show']);

        Route::get('/settings', [SettingController::class, 'index'])->name('settings.index');
        Route::put('/settings', [SettingController::class, 'update'])->name('settings.update');

        // Sales Report
        Route::get('/reports/sales', [\App\Http\Controllers\Admin\SalesReportController::class, 'index'])->name('reports.sales');

        // FAQ admin CRUD
        Route::resource('faqs', \App\Http\Controllers\Admin\FaqController::class);

        // AI - Generate product description
        Route::post('/ai/generate-description', [\App\Http\Controllers\AiController::class, 'generateDescription'])->name('ai.generate-description');    });
});
