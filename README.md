# GreenHaven / LongLeaf — Feature Documentation

## Tech Stack
- **Framework**: Laravel 10
- **Database**: MySQL / MariaDB
- **Payment**: Midtrans Core API
- **Shipping**: RajaOngkir Komerce (domestic) + Shippo (international)
- **Currency**: Frankfurter.app (real-time exchange rates)
- **Auth**: Laravel Sanctum + Google OAuth (Socialite)

---

## 1. Authentication

| Feature | Detail |
|---------|--------|
| Register / Login | Email & password |
| Google OAuth | Login dengan akun Google |
| Admin login | `/admin/login` — terpisah dari customer |
| Middleware | `auth` untuk customer, `admin` untuk admin panel |

---

## 2. Admin Panel (`/admin`)

### Katalog
- **Kategori** — CRUD kategori produk
- **Produk** — CRUD produk (nama, harga, stok, berat gram, gambar, badge, dll)

### Penjualan
- **Pesanan** — lihat & update status order
- **Konfirmasi Pembayaran** — approve/reject bukti transfer manual

### Konten
- **Blog / Artikel** — CRUD artikel dengan rich text editor
- **Newsletter** — lihat & hapus subscriber

### Pembayaran
- **Metode Pembayaran** — CRUD (manual transfer / Midtrans), upload logo
- **Coupon / Voucher** — CRUD coupon 5 digit, masa aktif, tipe persen/fixed

### Konfigurasi
- **API Settings** — toggle ON/OFF + isi key untuk:
  - Midtrans (server key, client key, mode production/sandbox)
  - RajaOngkir Komerce (API key, ID kota asal)
  - Shippo (API token, kode pos asal, negara asal)
- **Zona Pengiriman** — kelola flat rate per zona internasional
- **Pengaturan** — nama toko, logo, dll

---

## 3. Shop (Customer)

### Halaman Toko (`/shop`)
- Filter produk by kategori
- Sort: Featured, Newest, Price Low-High, Price High-Low
- **Search produk** — via toolbar & navbar search
- Wishlist toggle (heart button)
- Responsive: 2 kolom di mobile

### Detail Produk (`/shop/{slug}`)
- Gambar, deskripsi, harga, stok
- Tombol Add to Cart
- Related products

### Wishlist (`/wishlist`)
- Daftar produk yang di-wishlist
- Hapus dari wishlist tanpa reload

---

## 4. Cart & Checkout

### Cart (`/cart`)
- Tambah, update qty, hapus item
- Hitung subtotal otomatis

### Checkout (`/checkout`)
- Form alamat pengiriman internasional (nama, alamat, kota, state/province, negara, kode pos, telepon)
- **Dropdown negara** — Select2 + REST Countries API (~250 negara)
- **Ongkir dinamis**:
  - Indonesia → pilih kota → RajaOngkir (JNE, TIKI, POS, SiCepat, J&T)
  - Internasional → Shippo (DHL, FedEx, dll) atau flat rate zona
- **Coupon/Voucher** — input kode, validasi AJAX, diskon langsung terlihat
- **Multi-currency** — total tampil dalam mata uang yang dipilih

---

## 5. Pembayaran

### Manual Transfer
- Customer pilih metode manual (PayPal, BCA, dll)
- Upload bukti bayar
- Admin approve/reject di panel konfirmasi pembayaran

### Midtrans (Online Payment)
- Customer pilih "Bayar Online"
- **Halaman pilih metode** (`/payment/{order}/select`):
  - Transfer Bank VA: BCA, BNI, BRI, Mandiri, Permata
  - E-Wallet: GoPay, QRIS, ShopeePay
  - Minimarket: Alfamart, Indomaret
- **Halaman detail pembayaran** (`/payment/{order}/detail`):
  - Tampil nomor VA / QR code / kode bayar
  - Tombol salin VA
  - Tombol download QR (via server proxy)
  - Countdown expired
  - Auto-refresh status setiap 15 detik
- **Webhook** — status order otomatis update saat pembayaran berhasil

---

## 6. Order Management (Customer)

### Riwayat Pesanan (`/account/orders`)
- List semua order compact (nomor, tanggal, status, total, item)
- Filter by status
- Tombol aksi per order:
  - **Detail** — lihat detail order
  - **Bayar Sekarang** — ke halaman pembayaran (jika pending)
  - **Ganti Metode Pembayaran** — reset & pilih ulang
  - **Batalkan Pesanan** — dengan wajib isi alasan

### Detail Order (`/account/orders/{id}`)
- Info produk, alamat, ongkir, total
- Status pembayaran (VA/QR/konfirmasi manual)
- Tombol cancel & ganti payment
- Tampil alasan pembatalan jika dibatalkan

---

## 7. Shipping

### Domestik (Indonesia) — RajaOngkir Komerce
- Endpoint: `https://rajaongkir.komerce.id/api/v1`
- Pilih kota tujuan (dropdown Select2, ~500+ kota)
- Kurir: JNE, TIKI, POS, SiCepat, J&T
- Harga real-time
- Kota di-cache 24 jam

### Internasional — Shippo
- Endpoint: `https://api.goshippo.com`
- Harga real-time dari carrier (DHL, FedEx, UPS, dll)
- Fallback ke flat rate zona jika Shippo OFF atau tidak ada rates

### Zona Pengiriman (Flat Rate Fallback)
| Zona | Contoh Negara | Default Rate |
|------|--------------|-------------|
| Indonesia | Indonesia | Rp 25.000 |
| SEA | Malaysia, Singapore, Thailand | Rp 150.000 |
| Asia Timur | Japan, Korea, China | Rp 250.000 |
| Asia Selatan | India, Pakistan | Rp 280.000 |
| Timur Tengah | UAE, Saudi Arabia | Rp 300.000 |
| Australia & Pasifik | Australia, NZ | Rp 320.000 |
| Eropa Barat | UK, Germany, France | Rp 400.000 |
| Eropa Timur | Poland, Russia | Rp 420.000 |
| Amerika Utara | US, Canada, Mexico | Rp 450.000 |
| Amerika Selatan | Brazil, Argentina | Rp 500.000 |
| Afrika | South Africa, Nigeria | Rp 550.000 |

---

## 8. Coupon / Voucher

- Kode **5 karakter** (huruf kapital + angka)
- Tipe: **Persen** (%) atau **Fixed** (Rp)
- Masa aktif: tanggal mulai & berakhir
- Minimum order
- Maksimum diskon (opsional)
- Batas pemakaian (opsional)
- Validasi AJAX di checkout (real-time)

---

## 9. Multi-Currency

- Mata uang: IDR, USD, EUR, SGD, MYR, GBP, AUD, JPY
- Switcher di header (dropdown)
- Kurs dari **Frankfurter.app** (gratis, tanpa API key)
- Cache kurs **1 jam**
- Berlaku di: shop, product detail, checkout summary

---

## 10. Internasionalisasi (i18n)

- Bahasa: **Indonesia (ID)** dan **English (EN)**
- Switcher di header
- File lang: `resources/lang/id/messages.php` & `resources/lang/en/messages.php`

---

## 11. Blog

- List artikel (`/blog`)
- Detail artikel (`/blog/{slug}`)
- CRUD di admin panel dengan rich text editor (Quill)
- Upload gambar artikel

---

## 12. Lainnya

- **Newsletter** — subscribe email dari homepage
- **Google Analytics** ready (tambah tracking ID di settings)
- **Responsive** — mobile-friendly (2 kolom grid di HP)
- **SEO** — meta title & description per halaman

---

## Deployment

- Server: CyberPanel + OpenLiteSpeed
- Domain: `putri.ypac.site`
- Branch: `feature/midtrans-payment`
- Deploy: `git pull && composer install --no-dev && php artisan migrate --force && php artisan config:cache`

---

## Default Credentials

| Role | Email | Password |
|------|-------|----------|
| Admin | admin@greenhaven.id | password |
