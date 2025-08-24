#!/bin/bash

echo "=== SMP5 CMS Deployment Script ==="
echo ""

# Install dependencies
echo "📦 Installing dependencies..."
composer install --no-dev --optimize-autoloader

# Clear all caches
echo "🧹 Clearing caches..."
php artisan config:clear
php artisan cache:clear
php artisan route:clear
php artisan view:clear

# Run migrations
echo "🗄️  Running migrations..."
php artisan migrate --force

# Run seeders
echo "🌱 Running seeders..."
php artisan db:seed --force

# Optimize for production
echo "⚡ Optimizing for production..."
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Set permissions
echo "🔐 Setting permissions..."
chmod -R 755 storage
chmod -R 755 bootstrap/cache

echo ""
echo "✅ Deployment completed successfully!"
echo ""
echo "=== Super Admin Login Info ==="
echo "Email: admin@smpn5sangattautara.sch.id"
echo "Password: admin123"
echo "URL: /admin"
echo ""
echo "🚀 Your CMS is ready to use!"
