# Project Structure

## Top-Level Layout

```
app/                  PHP application code (MVC)
bootstrap/            Laravel bootstrap files
config/               Laravel config files
database/             Migrations, seeders, factories
public/               Web root — compiled assets, images
resources/            Views, lang files, raw JS/CSS
routes/               Route definitions
storage/              Logs, file uploads, cache
tests/                PHPUnit test suites
```

## App Layer (`app/`)

```
app/
├── Http/
│   ├── Controllers/
│   │   ├── Admin/        # Admin panel controllers (prefixed admin.)
│   │   └── *.php         # Customer-facing controllers
│   ├── Middleware/
│   │   ├── IsAdmin.php   # Guards admin routes
│   │   └── SetLocale.php # Applies session locale
│   └── Kernel.php
├── Models/               # Eloquent models (all use HasFactory + $fillable)
└── Providers/
```

## Routes (`routes/web.php`)

- Customer routes: no prefix, named without prefix (e.g. `home`, `shop`, `cart`)
- Admin routes: `prefix('admin')->name('admin.')`, protected by `admin` middleware
- Auth: separate customer auth (`CustomerAuthController`) and admin auth (`AdminAuthController`)
- Locale switching: `GET /locale/{locale}` stores locale in session

## Views (`resources/views/`)

```
views/
├── admin/
│   ├── layouts/app.blade.php   # AdminLTE base layout
│   └── {resource}/             # index, create, edit, show per resource
├── layouts/app.blade.php       # Customer storefront base layout
├── pages/                      # Customer-facing pages
├── partials/                   # header.blade.php, footer.blade.php
└── auth/                       # Customer login/register
```

## Conventions

- **Controllers**: Thin — validate, call model, redirect with `->with('success', '...')` flash
- **Models**: Always define `$fillable`; use `$casts` for booleans and decimals; define Eloquent relationships and query scopes in the model
- **Slugs**: Generated via `Str::slug($name)` in controller store/update methods
- **Admin views**: Extend `admin.layouts.app`, use AdminLTE components and DataTables
- **Customer views**: Extend `layouts.app`, use `@yield('content')` and `@stack('scripts')`
- **Translations**: Stored in `resources/lang/en/` and `resources/lang/id/`; use `__('key')` in Blade
- **Image uploads**: Stored in `public/` subdirectories; path saved as string in DB
- **Flash messages**: Use `session('success')` / `session('error')` pattern in Blade views

## Database

- Migrations follow timestamp naming: `YYYY_MM_DD_HHMMSS_description.php`
- All tables use standard Laravel `id()` + `timestamps()`
- Soft deletes are not used — hard deletes only
