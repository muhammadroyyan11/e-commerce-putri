const { chromium } = require('playwright');
const path = require('path');
const fs = require('fs');

const BASE_URL = process.env.APP_URL || 'http://localhost:8000';
const EMAIL = 'admin@greenhaven.id';
const PASSWORD = 'password';
const OUT_DIR = path.join(__dirname, 'images');

const PAGES = [
  { name: '01-dashboard',            url: '/admin' },
  { name: '02-products',             url: '/admin/products' },
  { name: '03-products-create',      url: '/admin/products/create' },
  { name: '04-categories',           url: '/admin/categories' },
  { name: '05-orders',               url: '/admin/orders' },
  { name: '06-payment-confirmations',url: '/admin/payment-confirmations' },
  { name: '07-payment-methods',      url: '/admin/payment-methods' },
  { name: '08-coupons',              url: '/admin/coupons' },
  { name: '09-blog-posts',           url: '/admin/blog-posts' },
  { name: '10-faqs',                 url: '/admin/faqs' },
  { name: '11-newsletters',          url: '/admin/newsletters' },
  { name: '12-users',                url: '/admin/users' },
  { name: '13-shipping-zones',       url: '/admin/shipping-zones' },
  { name: '14-reports-sales',        url: '/admin/reports/sales' },
  { name: '15-api-settings',         url: '/admin/api-settings' },
  { name: '16-settings',             url: '/admin/settings' },
];

(async () => {
  fs.mkdirSync(OUT_DIR, { recursive: true });

  const browser = await chromium.launch();
  const page = await browser.newPage();
  await page.setViewportSize({ width: 1440, height: 900 });

  // Login
  await page.goto(`${BASE_URL}/admin/login`);
  await page.fill('input[name="email"]', EMAIL);
  await page.fill('input[name="password"]', PASSWORD);
  await page.click('button[type="submit"]');
  await page.waitForURL(`${BASE_URL}/admin**`);
  console.log('✅ Login berhasil');

  // Screenshot tiap halaman
  for (const { name, url } of PAGES) {
    try {
      await page.goto(`${BASE_URL}${url}`, { waitUntil: 'networkidle' });
      const file = path.join(OUT_DIR, `${name}.png`);
      await page.screenshot({ path: file, fullPage: true });
      console.log(`📸 ${name}.png`);
    } catch (e) {
      console.warn(`⚠️  Gagal: ${name} — ${e.message}`);
    }
  }

  await browser.close();
  console.log(`\n✅ Selesai! Gambar tersimpan di: ${OUT_DIR}`);
})();
