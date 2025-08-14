#!/bin/bash

# 🚀 Production Optimization Script untuk CMS Sekolah
# Jalankan script ini sebelum upload ke hosting

echo "🔧 Optimizing CMS Sekolah for Production..."

# 1. Install production dependencies
echo "📦 Installing production dependencies..."
composer install --optimize-autoloader --no-dev --no-interaction

# 2. Generate optimized autoloader
echo "⚡ Generating optimized autoloader..."
composer dump-autoload --optimize

# 3. Cache configurations
echo "⚙️ Caching configurations..."
php artisan config:cache
php artisan route:cache
php artisan view:cache

# 4. Optimize application
echo "🎯 Optimizing application..."
php artisan optimize

# 5. Clear unnecessary caches
echo "🧹 Clearing development caches..."
php artisan cache:clear

# 6. Generate fresh application key (optional)
read -p "🔑 Generate new application key? (y/N): " -n 1 -r
echo
if [[ $REPLY =~ ^[Yy]$ ]]; then
    php artisan key:generate --force
fi

# 7. Set proper file permissions
echo "🔒 Setting file permissions..."
chmod -R 755 storage/
chmod -R 755 bootstrap/cache/

# 8. Create storage symlink
echo "🔗 Creating storage symlink..."
php artisan storage:link

echo "✅ Production optimization completed!"
echo ""
echo "📋 Next steps:"
echo "1. Update .env file with production database credentials"
echo "2. Upload files to hosting (exclude .env, .git, node_modules, tests)"
echo "3. Run migrations on production: php artisan migrate --force"
echo "4. Seed permissions: php artisan db:seed --class=SimplifiedPermissionSeeder"
echo "5. Create admin user via tinker or SQL"
echo ""
echo "🎉 Your CMS is ready for deployment!"
