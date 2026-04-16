#!/bin/bash
# ============================================================
# Deploy Script - putri.ypac.site
# Jalankan di server: bash deploy.sh
# ============================================================

set -e

DOMAIN="putri.ypac.site"
REPO="https://github.com/muhammadroyyan11/e-commerce-putri.git"
WEBROOT="/home/$DOMAIN/public_html"
BRANCH="feature/midtrans-payment"

echo "=============================="
echo " Deploy: $DOMAIN"
echo "=============================="

# 1. Clone atau pull repo
if [ -d "$WEBROOT/.git" ]; then
    echo "[1/8] Pulling latest code..."
    cd $WEBROOT
    git fetch origin
    git reset --hard origin/$BRANCH
else
    echo "[1/8] Cloning repository..."
    rm -rf $WEBROOT
    git clone -b $BRANCH $REPO $WEBROOT
    cd $WEBROOT
fi

# 2. Install dependencies
echo "[2/8] Installing composer dependencies..."
composer install --no-dev --optimize-autoloader --no-interaction

# 3. Setup .env jika belum ada
if [ ! -f "$WEBROOT/.env" ]; then
    echo "[3/8] Creating .env file..."
    cp $WEBROOT/.env.example $WEBROOT/.env

    # Edit nilai .env
    sed -i "s|APP_NAME=Laravel|APP_NAME=LongLeaf|g" $WEBROOT/.env
    sed -i "s|APP_ENV=local|APP_ENV=production|g" $WEBROOT/.env
    sed -i "s|APP_DEBUG=true|APP_DEBUG=false|g" $WEBROOT/.env
    sed -i "s|APP_URL=http://localhost|APP_URL=https://$DOMAIN|g" $WEBROOT/.env

    echo ""
    echo "⚠️  PENTING: Edit .env dan isi nilai berikut:"
    echo "   DB_DATABASE, DB_USERNAME, DB_PASSWORD"
    echo "   MIDTRANS_SERVER_KEY, MIDTRANS_CLIENT_KEY"
    echo "   GOOGLE_CLIENT_ID, GOOGLE_CLIENT_SECRET"
    echo ""
    echo "   nano $WEBROOT/.env"
    echo ""
    read -p "Tekan ENTER setelah selesai edit .env..."
else
    echo "[3/8] .env sudah ada, skip..."
fi

# 4. Generate app key jika belum ada
APP_KEY=$(grep "^APP_KEY=" $WEBROOT/.env | cut -d'=' -f2)
if [ -z "$APP_KEY" ]; then
    echo "[4/8] Generating app key..."
    php artisan key:generate
else
    echo "[4/8] App key sudah ada, skip..."
fi

# 5. Permissions
echo "[5/8] Setting permissions..."
chown -R nobody:nobody $WEBROOT 2>/dev/null || chown -R www-data:www-data $WEBROOT 2>/dev/null || true
chmod -R 755 $WEBROOT
chmod -R 775 $WEBROOT/storage $WEBROOT/bootstrap/cache

# 6. Storage link
echo "[6/8] Creating storage link..."
cd $WEBROOT
php artisan storage:link --force 2>/dev/null || true

# 7. Migrate & seed
echo "[7/8] Running migrations..."
php artisan migrate --force

echo "      Running seeders..."
php artisan db:seed --class=ShippingZoneSeeder --force 2>/dev/null || true

# 8. Optimize
echo "[8/8] Optimizing..."
php artisan config:cache
php artisan route:cache
php artisan view:cache

echo ""
echo "=============================="
echo " ✅ Deploy selesai!"
echo "=============================="
echo ""
echo "Langkah selanjutnya di CyberPanel:"
echo "1. Pastikan document root = $WEBROOT/public"
echo "2. Aktifkan SSL (Let's Encrypt)"
echo "3. Buka https://$DOMAIN"
echo ""
