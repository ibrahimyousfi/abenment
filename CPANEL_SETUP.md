# إعداد المشروع على cPanel

## الطريقة الأولى: تعيين Document Root إلى مجلد public (موصى به)

### الخطوات:

1. **في cPanel، اذهب إلى:**
   - File Manager > Settings
   - أو Advanced > Document Root Settings

2. **قم بتعيين Document Root إلى:**
   ```
   public_html/public
   ```
   أو إذا كان المشروع في مجلد فرعي:
   ```
   public_html/your-folder/public
   ```

3. **بهذه الطريقة لا تحتاج ملف .htaccess في المجلد الرئيسي**

## الطريقة الثانية: استخدام .htaccess لإعادة التوجيه

إذا لم تستطع تغيير Document Root، استخدم ملف `.htaccess` الموجود في المجلد الرئيسي.

### تأكد من:
- ملف `.htaccess` موجود في المجلد الرئيسي
- mod_rewrite مفعل في الاستضافة

## إعداد قاعدة البيانات

1. **أنشئ قاعدة بيانات من cPanel:**
   - اذهب إلى MySQL Databases
   - أنشئ قاعدة بيانات جديدة
   - أنشئ مستخدم جديد
   - اربط المستخدم بقاعدة البيانات

2. **عدّل ملف `.env`:**
   ```env
   DB_CONNECTION=mysql
   DB_HOST=localhost
   DB_PORT=3306
   DB_DATABASE=اسم_قاعدة_البيانات
   DB_USERNAME=اسم_المستخدم
   DB_PASSWORD=كلمة_المرور
   ```

## تثبيت المشروع

### عبر SSH (إن كان متاحاً):

```bash
cd ~/public_html
composer install --no-dev --optimize-autoloader
php artisan key:generate
php artisan migrate --force
php artisan storage:link
npm install
npm run build
```

### عبر File Manager و Terminal في cPanel:

1. افتح Terminal من cPanel
2. انتقل إلى مجلد المشروع
3. نفذ الأوامر أعلاه

## إعداد الصلاحيات

قم بتعيين الصلاحيات التالية عبر File Manager:

- `storage/` → 775
- `bootstrap/cache/` → 775
- `public/` → 755

## إعداد متغيرات البيئة

في ملف `.env`:

```env
APP_NAME="Gym Management Platform"
APP_ENV=production
APP_DEBUG=false
APP_URL=https://yourdomain.com

DB_CONNECTION=mysql
DB_HOST=localhost
DB_DATABASE=your_database
DB_USERNAME=your_username
DB_PASSWORD=your_password

MAIL_MAILER=smtp
MAIL_HOST=mail.yourdomain.com
MAIL_PORT=587
MAIL_USERNAME=noreply@yourdomain.com
MAIL_PASSWORD=your_email_password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=noreply@yourdomain.com
MAIL_FROM_NAME="${APP_NAME}"
```

## إنشاء رابط التخزين

```bash
php artisan storage:link
```

## تشغيل Migrations

```bash
php artisan migrate --force
```

## إنشاء حساب Super Admin

```bash
php artisan db:seed --class=SuperAdminSeeder
```

## ملاحظات مهمة

1. **تأكد من PHP Version >= 8.2:**
   - في cPanel: Select PHP Version
   - اختر PHP 8.2 أو أحدث

2. **تأكد من تفعيل Extensions:**
   - OpenSSL
   - PDO
   - Mbstring
   - Tokenizer
   - XML
   - Ctype
   - JSON
   - BCMath

3. **لا ترفع:**
   - ملف `.env`
   - مجلد `vendor/` (ثبت عبر composer)
   - مجلد `node_modules/` (ثبت عبر npm)
   - ملفات `storage/` المؤقتة

4. **رفع فقط:**
   - جميع ملفات المشروع عدا ما ذكر أعلاه
   - بعد الرفع، قم بتثبيت التبعيات عبر SSH/Terminal

## حل المشاكل الشائعة

### خطأ 500 Internal Server Error:
- تحقق من الصلاحيات على `storage/` و `bootstrap/cache/`
- تحقق من ملف `.env` وصحة البيانات
- تحقق من سجلات الأخطاء في `storage/logs/`

### خطأ Route not found:
- تأكد من أن `mod_rewrite` مفعل
- تحقق من ملف `.htaccess` في مجلد `public/`

### خطأ Database Connection:
- تحقق من معلومات قاعدة البيانات في `.env`
- تأكد من أن المستخدم لديه صلاحيات على قاعدة البيانات
