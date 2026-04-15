# GreenHaven E-Commerce Features

Dokumen ini merangkum fitur-fitur utama yang saat ini tersedia di project `ecom-putri` dan bisa digunakan sebagai dasar materi publikasi, listing produk, atau penawaran komersial.

## Ringkasan Produk

GreenHaven adalah website e-commerce tanaman dengan dua area utama:

- customer-facing storefront untuk browsing, checkout, dan tracking pesanan
- admin panel untuk mengelola katalog, pesanan, pembayaran, konten blog, user, dan konfigurasi website

Website ini cocok untuk kebutuhan:

- toko tanaman online
- toko dekorasi / home living berbasis katalog
- e-commerce UMKM dengan pembayaran transfer manual
- website brand dengan kombinasi toko + blog + dashboard admin

## Fitur Customer

### 1. Homepage Storefront

- hero section modern
- kategori unggulan
- produk unggulan
- section testimonial
- section benefit / keunggulan brand
- newsletter subscription

### 2. Katalog Produk

- halaman shop / daftar produk
- detail produk
- filter kategori
- sorting produk
- wishlist toggle
- tampilan mobile-friendly

### 3. Autentikasi Customer

- login email/password
- register akun customer
- remember me
- logout
- login dengan Google

### 4. Cart dan Checkout

- tambah ke keranjang
- update quantity cart
- hapus item cart
- checkout customer login
- ringkasan biaya
- pilihan metode pembayaran

### 5. Order Flow

- pembuatan order otomatis setelah checkout
- halaman order success
- konfirmasi pembayaran customer
- upload bukti pembayaran
- riwayat belanja customer
- detail pesanan customer
- status order customer

### 6. Blog / Artikel

- halaman daftar artikel
- halaman detail artikel
- artikel terhubung ke data admin
- filter kategori artikel
- search artikel
- pagination real berdasarkan data published

### 7. Multi Language

- switch bahasa Indonesia / English
- customer-facing translation support

### 8. Responsive UI

- optimized untuk desktop
- mobile navigation
- responsive improvement untuk blog, auth, dan halaman order customer

## Fitur Admin Panel

### 1. Dashboard Admin

- summary operasional
- statistic cards
- recent orders
- recent products
- ringkasan performa toko
- chart tren 7 hari terakhir
- chart distribusi status pesanan

### 2. Manajemen User

- list user
- role admin / customer
- tambah user
- edit user
- hapus user
- datatable search/sort

### 3. Manajemen Kategori

- list kategori
- tambah kategori
- edit kategori
- hapus kategori
- auto count jumlah produk dari relasi
- datatable search/sort

### 4. Manajemen Produk

- list produk
- tambah produk
- edit produk
- hapus produk
- relasi kategori
- filter stok di admin
- datatable search/sort

### 5. Manajemen Blog / Artikel

- list artikel
- tambah artikel
- edit artikel
- publish / draft
- kategori artikel
- author dan avatar
- datatable search/sort

### 6. Manajemen Pesanan

- list order admin
- detail pesanan
- update status order
- hapus order
- filter tanggal
- datatable search/sort

### 7. Konfirmasi Pembayaran

- list payment confirmations
- detail pembayaran
- approve pembayaran
- reject pembayaran
- update status order setelah konfirmasi
- datatable search/sort

### 8. Metode Pembayaran

- list metode pembayaran
- tambah metode pembayaran
- edit metode pembayaran
- upload logo bank / payment method
- aktif / nonaktif metode pembayaran
- urutan tampil metode pembayaran
- datatable search/sort

### 9. Newsletter Admin

- list subscriber
- hapus subscriber
- datatable search/sort

### 10. Pengaturan Website

- site name
- site logo
- konfigurasi payment info dasar

## Fitur Teknis

- Laravel 10
- authentication berbasis Laravel Auth
- Google OAuth dengan Socialite
- MySQL database
- Blade template rendering
- AdminLTE untuk admin panel
- DataTables pada halaman tabel admin
- Chart.js untuk visualisasi dashboard

## Nilai Jual

- sudah memiliki area customer dan admin dalam satu project
- sudah ada blog + e-commerce dalam satu sistem
- sudah ada login Google
- sudah ada riwayat belanja customer
- sudah ada konfirmasi pembayaran manual
- sudah ada dashboard admin dengan chart
- cocok untuk custom branding dan pengembangan lanjutan

## Cocok Untuk Dijual Sebagai

- website toko tanaman siap pakai
- starter kit e-commerce Laravel
- template admin + storefront bilingual
- website UMKM dengan panel admin lengkap

## Catatan Untuk Materi Publikasi

Saat dipublikasikan ke publik, sebaiknya materi promosi menekankan:

- storefront modern dan mobile-friendly
- login Google
- bilingual support
- customer order history
- admin dashboard dengan chart
- CRUD lengkap untuk produk, kategori, artikel, pesanan, pembayaran

## Saran Packaging Jualan

Jika ingin dijual lebih menarik, Anda bisa buat 3 paket:

### Basic

- source code
- setup guide
- fitur e-commerce + admin dasar

### Standard

- source code
- setup guide
- deployment support
- branding basic

### Premium

- source code
- setup guide
- deployment support
- custom branding
- minor feature request
- bug fixing period

## File Pendukung Yang Sebaiknya Disiapkan Sebelum Dijual

- screenshot desktop customer pages
- screenshot mobile customer pages
- screenshot admin dashboard
- screenshot manajemen produk / order / blog
- setup guide installation
- daftar dependensi
- changelog fitur
- demo account admin dan customer

