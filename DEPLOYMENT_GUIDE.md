# 🚀 Panduan Deploy CMS Sekolah ke Hosting

## 📋 Persiapan Sebelum Upload

### 1. Optimasi untuk Production
```bash
# Generate app key baru (optional)
php artisan key:generate

# Optimize aplikasi
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan optimize

# Install dependencies production only
composer install --optimize-autoloader --no-dev
```

### 2. File yang WAJIB di-upload
```
├── app/
├── bootstrap/
├── config/
├── database/
├── public/
├── resources/
├── routes/
├── storage/
├── vendor/
├── composer.json
├── composer.lock
├── artisan
└── .htaccess (jika diperlukan)
```

### 3. File yang TIDAK boleh di-upload
```
- .env (gunakan .env.production sebagai template)
- .env.example
- .git/
- .gitignore
- node_modules/
- tests/
- storage/logs/* (kosongkan)
- storage/framework/cache/* (kosongkan)
- storage/framework/sessions/* (kosongkan)
- storage/framework/views/* (kosongkan)
```

## 🗄️ Setup Database di Hosting

### 1. Buat Database Baru
- Login ke cPanel/hosting panel
- Buat database baru (contoh: `cms_sekolah`)
- Buat user database dengan full privileges

### 2. Import Database
```sql
-- Upload file database atau run migrations
php artisan migrate --force
php artisan db:seed --class=SimplifiedPermissionSeeder
php artisan db:seed --class=AboutCmsSeeder
```

### 3. Update .env di Hosting
```env
APP_NAME="CMS Sekolah"
APP_ENV=production
APP_DEBUG=false
APP_URL=https://yourdomain.com

DB_CONNECTION=mysql
DB_HOST=localhost
DB_DATABASE=your_database_name
DB_USERNAME=your_database_user
DB_PASSWORD=your_database_password
```

## 📁 Konfigurasi Folder dan Permission

### 1. Set Permission Folder
```bash
chmod 755 storage/
chmod 755 storage/app/
chmod 755 storage/framework/
chmod 755 storage/logs/
chmod 755 bootstrap/cache/
```

### 2. Symlink Storage (Jika diperlukan)
```bash
php artisan storage:link
```

## 🔧 Konfigurasi Web Server

### Apache (.htaccess)
File sudah tersedia di `public/.htaccess`

### Nginx
```nginx
server {
    listen 80;
    server_name yourdomain.com;
    root /path/to/your/app/public;

    add_header X-Frame-Options "SAMEORIGIN";
    add_header X-XSS-Protection "1; mode=block";
    add_header X-Content-Type-Options "nosniff";

    index index.html index.htm index.php;

    charset utf-8;

    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }

    location = /favicon.ico { access_log off; log_not_found off; }
    location = /robots.txt  { access_log off; log_not_found off; }

    error_page 404 /index.php;

    location ~ \.php$ {
        fastcgi_pass unix:/var/run/php/php8.2-fpm.sock;
        fastcgi_index index.php;
        fastcgi_param SCRIPT_FILENAME $realpath_root$fastcgi_script_name;
        include fastcgi_params;
    }

    location ~ /\.(?!well-known).* {
        deny all;
    }
}
```

## 👤 Setup User Administrator

### 1. Via Tinker (Setelah Upload)
```bash
php artisan tinker

# Buat user admin baru
$user = new App\Models\User();
$user->name = 'Administrator';
$user->email = 'admin@sekolah.com';
$user->password = bcrypt('password123');
$user->is_active = true;
$user->save();

# Assign role superadmin
$user->assignRole('superadmin');
```

### 2. Via Database Direct
```sql
INSERT INTO users (name, email, password, is_active, created_at, updated_at) 
VALUES ('Administrator', 'admin@sekolah.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 1, NOW(), NOW());

-- Get user ID dan assign role
INSERT INTO model_has_roles (role_id, model_type, model_id) 
VALUES (1, 'App\\Models\\User', LAST_INSERT_ID());
```

## 🔒 Security Checklist

- [ ] APP_DEBUG=false di .env
- [ ] APP_ENV=production di .env
- [ ] Password admin yang kuat
- [ ] File .env tidak bisa diakses dari web
- [ ] Folder storage dan bootstrap/cache writable
- [ ] SSL Certificate terpasang
- [ ] Backup database secara berkala

## 📞 Troubleshooting

### Error 500
1. Cek file .env sudah benar
2. Cek permission folder storage/
3. Cek error log di storage/logs/

### Database Connection Failed
1. Pastikan kredensial database benar
2. Cek apakah database sudah dibuat
3. Test koneksi database dari hosting panel

### Filament Admin Tidak Bisa Diakses
1. Pastikan URL correct: yourdomain.com/admin
2. Cek user sudah assign role superadmin
3. Clear cache: php artisan cache:clear

## 📈 Post-Deployment

1. **Test Semua Fitur**: Login admin, CRUD content, upload gambar
2. **Backup Setup**: Setup automatic database backup
3. **Monitor**: Setup error monitoring dan log
4. **Update**: Update .env dengan email SMTP untuk notifikasi

---

### 📋 Checklist Deploy

- [ ] File uploaded kecuali yang di-exclude
- [ ] Database created dan migrated
- [ ] .env configured dengan benar
- [ ] Folder permissions set
- [ ] Admin user created
- [ ] SSL installed
- [ ] Admin panel accessible
- [ ] All CMS features working
- [ ] Backup strategy in place
