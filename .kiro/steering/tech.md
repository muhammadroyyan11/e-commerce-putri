# Tech Stack

## Backend
- **PHP 8.1+** with **Laravel 10**
- **MySQL** database
- **Laravel Sanctum** for API token auth
- **Laravel Socialite** for Google OAuth
- **Guzzle** for HTTP requests

## Frontend
- **Blade** templating (server-side rendered)
- **Vite** for asset bundling (via `laravel-vite-plugin`)
- **AdminLTE** for the admin panel UI
- **DataTables** (jQuery) for admin table views
- **Chart.js** for dashboard charts
- **Font Awesome 6** for icons
- **Poppins** (Google Fonts) for the storefront
- Custom CSS: `public/css/plant-theme.css`, `public/css/responsive-fix.css`

## Dev Tools
- **Laravel Pint** — PHP code style fixer (PSR-12)
- **PHPUnit 10** — testing framework
- **Laravel Sail** — Docker dev environment
- **Faker** — test data generation

## Common Commands

```bash
# Install dependencies
composer install
npm install

# Environment setup
cp .env.example .env
php artisan key:generate

# Database
php artisan migrate
php artisan db:seed

# Asset compilation
npm run dev       # development with HMR
npm run build     # production build

# Code style
./vendor/bin/pint

# Tests
php artisan test
# or
./vendor/bin/phpunit

# Useful Artisan
php artisan tinker
php artisan route:list
php artisan cache:clear
php artisan config:clear
php artisan view:clear
```

## Docker
A `docker-compose.yml` and `Dockerfile` are present. Laravel Sail can also be used for local development.
