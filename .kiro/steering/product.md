# LongLeaf — Product Overview

LongLeaf is a bilingual (Indonesian/English) e-commerce platform for selling plants online. It is a Laravel-based monolith with two distinct areas:

- **Customer storefront** — browsing, cart, checkout, order tracking, blog, wishlist, Google login
- **Admin panel** — full CRUD management for products, categories, orders, blog posts, users, payment methods, payment confirmations, newsletter subscribers, and site settings

## Key Business Concepts

- Products belong to categories and have attributes like `stock`, `is_active`, `badge`, `care_level`, `watering`, `light`
- Orders go through a manual payment flow: customer checks out → uploads payment proof → admin approves/rejects
- Order statuses: `pending` → `awaiting_confirmation` → `processing` → `shipped` → `delivered` / `cancelled`
- Payment methods are configurable by admin (bank transfer, etc.) with logos and active/inactive toggle
- Blog posts support publish/draft states and are linked to categories
- Multi-language support via Laravel locale sessions (`en` / `id`)

## Target Use Case

Small-to-medium Indonesian plant/home-living online stores needing a combined storefront + admin panel with manual bank transfer payment flow.
