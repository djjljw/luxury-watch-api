#!/bin/bash
set -e

echo "🚀 Menjalankan post-build script di Clever Cloud untuk Luxury Watch API..."

# 1. Jalankan migrasi basis data secara otomatis di server Clever Cloud
php artisan migrate --force

# 2. Seed data katalog awal jika belum terisi
php artisan db:seed --class=WatchSeeder --force || true

# 3. Optimasi performa untuk lingkungan produksi
php artisan config:cache
php artisan route:cache
php artisan view:cache

echo "✅ Post-build Clever Cloud berhasil diselesaikan!"
