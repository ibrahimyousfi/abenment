# حل مشكلة HTTP ERROR 500

## الخطوات السريعة:

### 1. تحقق من ملف السجلات:
```bash
cd /home/swissleg/a
tail -50 storage/logs/laravel.log
```

### 2. تحقق من الصلاحيات:
```bash
chmod -R 775 storage bootstrap/cache
chown -R swissleg:swissleg storage bootstrap/cache
```

### 3. مسح الكاش:
```bash
php artisan config:clear
php artisan cache:clear
php artisan view:clear
php artisan route:clear
php artisan optimize:clear
```

### 4. تحقق من ملف .env:
```bash
# تأكد من وجود:
APP_ENV=production
APP_DEBUG=false
APP_KEY=base64:... (يجب أن يكون موجود)
```

### 5. إعادة توليد APP_KEY:
```bash
php artisan key:generate
```

### 6. تحقق من قاعدة البيانات:
```bash
php artisan migrate:status
```

### 7. تحقق من ملف .htaccess:
- تأكد من وجود ملف .htaccess في المجلد الرئيسي
- تأكد من وجود ملف .htaccess في مجلد public

### 8. تحقق من PHP Version:
- يجب أن يكون PHP >= 8.2
- في cPanel: Select PHP Version

### 9. تحقق من Extensions المطلوبة:
- OpenSSL
- PDO
- Mbstring
- Tokenizer
- XML
- Ctype
- JSON
- BCMath

### 10. تحقق من Document Root:
- يجب أن يكون Document Root يشير إلى مجلد `public`
- أو استخدم ملف `.htaccess` في المجلد الرئيسي
