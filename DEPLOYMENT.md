# تعليمات النشر على cPanel

## متطلبات الاستضافة

- PHP >= 8.2
- Composer
- MySQL/MariaDB أو SQLite
- mod_rewrite مفعل

## خطوات النشر

### 1. رفع الملفات

ارفع جميع ملفات المشروع إلى المجلد الرئيسي (public_html) أو مجلد فرعي.

### 2. إعداد قاعدة البيانات

- أنشئ قاعدة بيانات من cPanel
- سجل معلومات الاتصال (اسم قاعدة البيانات، المستخدم، كلمة المرور)

### 3. إعداد ملف .env

- انسخ `.env.example` إلى `.env`
- عدّل الملف بإضافة معلومات قاعدة البيانات:
```
DB_CONNECTION=mysql
DB_HOST=localhost
DB_PORT=3306
DB_DATABASE=اسم_قاعدة_البيانات
DB_USERNAME=اسم_المستخدم
DB_PASSWORD=كلمة_المرور
```

- قم بتغيير `APP_URL` إلى رابط موقعك:
```
APP_URL=https://yourdomain.com
```

- قم بتغيير `APP_ENV` و `APP_DEBUG`:
```
APP_ENV=production
APP_DEBUG=false
```

### 4. تثبيت التبعيات

قم بتشغيل الأوامر التالية عبر SSH أو Terminal في cPanel:

```bash
composer install --no-dev --optimize-autoloader
php artisan key:generate
php artisan migrate --force
php artisan storage:link
npm install
npm run build
```

### 5. إعداد الصلاحيات

قم بتعيين الصلاحيات التالية:
- `storage/` و `bootstrap/cache/`: 775
- جميع الملفات: 644

### 6. إعداد Document Root

في cPanel، قم بتعيين Document Root إلى مجلد `public`:
- اذهب إلى Settings > Document Root
- حدد مجلد `public`

أو استخدم ملف `.htaccess` في المجلد الرئيسي لإعادة التوجيه.

### 7. إعداد Cron Jobs (اختياري)

إذا كنت تستخدم Queue أو Scheduled Tasks، أضف Cron Job:
```
* * * * * cd /path/to/your/project && php artisan schedule:run >> /dev/null 2>&1
```

## ملاحظات مهمة

- تأكد من أن `APP_DEBUG=false` في الإنتاج
- لا ترفع ملف `.env` على GitHub
- تأكد من أن مجلد `storage` قابل للكتابة
- قم بعمل نسخة احتياطية من قاعدة البيانات قبل النشر
