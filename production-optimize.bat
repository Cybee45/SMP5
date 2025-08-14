@echo off
REM 🚀 Production Optimization Script untuk CMS Sekolah (Windows)
REM Jalankan script ini sebelum upload ke hosting

echo 🔧 Optimizing CMS Sekolah for Production...

REM 1. Install production dependencies
echo 📦 Installing production dependencies...
composer install --optimize-autoloader --no-dev --no-interaction

REM 2. Generate optimized autoloader
echo ⚡ Generating optimized autoloader...
composer dump-autoload --optimize

REM 3. Cache configurations
echo ⚙️ Caching configurations...
php artisan config:cache
php artisan route:cache
php artisan view:cache

REM 4. Optimize application
echo 🎯 Optimizing application...
php artisan optimize

REM 5. Clear unnecessary caches
echo 🧹 Clearing development caches...
php artisan cache:clear

REM 6. Generate fresh application key (optional)
set /p REPLY="🔑 Generate new application key? (y/N): "
if /i "%REPLY%"=="y" (
    php artisan key:generate --force
)

REM 7. Create storage symlink
echo 🔗 Creating storage symlink...
php artisan storage:link

echo ✅ Production optimization completed!
echo.
echo 📋 Next steps:
echo 1. Update .env file with production database credentials
echo 2. Upload files to hosting (exclude .env, .git, node_modules, tests)
echo 3. Run migrations on production: php artisan migrate --force
echo 4. Seed permissions: php artisan db:seed --class=SimplifiedPermissionSeeder
echo 5. Create admin user via tinker or SQL
echo.
echo 🎉 Your CMS is ready for deployment!

pause
