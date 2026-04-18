# 🌿 GreenHaven — Plant E-Commerce

A full-featured bilingual (EN/ID) e-commerce platform for selling plants online, built with Laravel 10. Includes a customer storefront, admin panel, AI plant assistant, multi-currency support, and international shipping.

---

## ✨ Features

### Customer Storefront
- Product catalog with category filter, search, and sort
- Infinite scroll product listing
- Product detail with image gallery, care info, and reviews
- Wishlist with shareable link
- Cart & checkout with coupon/voucher support
- Multi-currency display (IDR, USD, EUR, SGD, MYR, GBP, AUD, JPY)
- Order history, tracking, and payment confirmation upload
- Blog with comments & replies
- FAQ page
- Account management (profile, saved addresses)
- **JEZY AI Plant Assistant** — floating chat bubble powered by Groq (llama-3.3-70b)

### Admin Panel
- Dashboard with revenue charts and order stats
- Product management with multi-image upload and AI description generator
- Category, blog post, FAQ, and newsletter management
- Order management with status updates
- Payment confirmation (approve/reject manual transfers)
- Payment methods (manual transfer + Midtrans)
- Coupon/voucher management
- Shipping zones (flat rate fallback)
- Sales settlement report with CSV export
- Site settings (name, logo, contact info, social media, trust badges)

### Payments
- **Manual transfer** — customer uploads proof, admin approves
- **Midtrans** — VA (BCA, BNI, BRI, Mandiri), GoPay, QRIS, ShopeePay, Minimarket

### Shipping
- **Domestic (Indonesia)** — RajaOngkir Komerce (JNE, TIKI, SiCepat, J&T, POS)
- **International** — Shippo (DHL, FedEx, UPS) with flat-rate zone fallback

---

## 🛠 Tech Stack

| Layer | Technology |
|---|---|
| Framework | Laravel 10 (PHP 8.1+) |
| Database | MySQL |
| Frontend | Blade, Vite, AdminLTE (admin) |
| Auth | Laravel Sanctum + Google OAuth (Socialite) |
| Payment | Midtrans Core API |
| Shipping | RajaOngkir Komerce + Shippo |
| Currency | Frankfurter.app (real-time, no API key needed) |
| AI | Groq API (llama-3.3-70b-versatile) |
| SEO | Dynamic meta tags, Open Graph, JSON-LD Schema, Sitemap XML |

---

## 🚀 Installation

### Requirements
- PHP 8.1+
- MySQL 8+
- Composer
- Node.js & npm
- Laragon / XAMPP / Docker

### Steps

```bash
# 1. Clone the repository
git clone <repo-url>
cd <project-folder>

# 2. Install dependencies
composer install
npm install

# 3. Environment setup
cp .env.example .env
php artisan key:generate

# 4. Configure .env
# Set DB_DATABASE, DB_USERNAME, DB_PASSWORD
# Set APP_URL to your local domain

# 5. Run migrations and seed
php artisan migrate --seed

# 6. Create storage symlink
php artisan storage:link

# 7. Build assets
npm run build

# 8. Start server (Laragon / artisan serve)
php artisan serve
```

---

## ⚙️ Environment Variables

Key variables to configure in `.env`:

```env
APP_URL=http://localhost

DB_DATABASE=your_database
DB_USERNAME=root
DB_PASSWORD=

# Google OAuth
GOOGLE_CLIENT_ID=
GOOGLE_CLIENT_SECRET=
GOOGLE_REDIRECT_URL="${APP_URL}/auth/google/callback"

# Midtrans
MIDTRANS_SERVER_KEY=
MIDTRANS_CLIENT_KEY=
MIDTRANS_IS_PRODUCTION=false

# AI Assistant (Groq)
GROQ_API_KEY=
```

> RajaOngkir and Shippo keys are configured via **Admin → API Settings** in the panel.

---

## 🔑 Default Credentials

| Role | Email | Password |
|---|---|---|
| Admin | admin@greenhaven.id | password |

---

## 📁 Project Structure

```
app/
├── Helpers/          # SeoMeta, ProductTranslator, CurrencyService
├── Http/
│   ├── Controllers/
│   │   ├── Admin/    # Admin panel controllers
│   │   └── *.php     # Customer-facing controllers
│   └── Middleware/
├── Models/           # Eloquent models
└── Services/         # GroqService, CurrencyService

resources/
├── lang/
│   ├── en/           # English translations
│   └── id/           # Indonesian translations
└── views/
    ├── admin/        # AdminLTE-based admin views
    ├── pages/        # Customer storefront pages
    └── partials/     # Header, footer, AI bubble, etc.
```

---

## 🌐 URLs

| URL | Description |
|---|---|
| `/` | Homepage |
| `/shop` | Product catalog |
| `/blog` | Blog |
| `/faq` | FAQ |
| `/account/profile` | Customer profile |
| `/account/addresses` | Saved addresses |
| `/account/orders` | Order history |
| `/sitemap.xml` | Auto-generated sitemap |
| `/admin` | Admin panel |

---

## 📄 License

MIT
