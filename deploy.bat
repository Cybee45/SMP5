@echo off
echo === SMP5 CMS Deployment Script ===
echo.

REM Install dependencies
echo 📦 Installing dependencies...
composer install --no-dev --optimize-autoloader

REM Clear all caches
echo 🧹 Clearing caches...
php artisan config:clear
php artisan cache:clear
php artisan route:clear
php artisan view:clear

REM Run migrations
echo 🗄️  Running migrations...
php artisan migrate --force

REM Run seeders
echo 🌱 Running seeders...
php artisan db:seed --force

REM Optimize for production
echo ⚡ Optimizing for production...
php artisan config:cache
php artisan route:cache
php artisan view:cache

echo.
echo ✅ Deployment completed successfully!
echo.
echo === Super Admin Login Info ===
echo Email: admin@smpn5sangattautara.sch.id
echo Password: admin123
echo URL: /admin
echo.
echo 🚀 Your CMS is ready to use!
pause