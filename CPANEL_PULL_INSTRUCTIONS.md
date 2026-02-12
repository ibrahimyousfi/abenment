# تعليمات سحب آخر التحديثات من GitHub في cPanel

## الطريقة الأولى: استخدام واجهة Git في cPanel

### الخطوات:

1. **اذهب إلى Git Version Control في cPanel**

2. **اختر المستودع الخاص بك** (اسمه: `a`)

3. **انقر على "Pull or Deploy"**

4. **اختر Branch: `main`**

5. **انقر على "Update from Remote"** أو **"Pull"**

6. **انتظر حتى يتم سحب التحديثات**

## الطريقة الثانية: استخدام Terminal/SSH في cPanel

### الخطوات:

1. **افتح Terminal من cPanel**
   - اذهب إلى: Advanced > Terminal
   - أو SSH إلى الخادم

2. **انتقل إلى مجلد المشروع:**
   ```bash
   cd /home/swissleg/a
   ```

3. **تحقق من الفرع الحالي:**
   ```bash
   git branch
   ```

4. **سحب آخر التحديثات:**
   ```bash
   git pull origin main
   ```

5. **إذا ظهرت رسالة خطأ عن تغييرات محلية:**
   ```bash
   git stash
   git pull origin main
   git stash pop
   ```

## بعد سحب التحديثات:

### 1. تثبيت التبعيات الجديدة (إن وجدت):
```bash
composer install --no-dev --optimize-autoloader
```

### 2. تشغيل Migrations الجديدة (إن وجدت):
```bash
php artisan migrate --force
```

### 3. مسح الكاش:
```bash
php artisan config:clear
php artisan cache:clear
php artisan view:clear
php artisan route:clear
```

### 4. بناء الأصول (إن كانت هناك تغييرات في CSS/JS):
```bash
npm install
npm run build
```

## ملاحظات مهمة:

⚠️ **احذر:** قبل سحب التحديثات، تأكد من:
- عمل نسخة احتياطية من قاعدة البيانات
- عمل نسخة احتياطية من ملف `.env`
- عمل نسخة احتياطية من مجلد `storage/` إذا كان يحتوي على ملفات مهمة

## حل المشاكل:

### إذا ظهر خطأ "Your local changes would be overwritten":
```bash
# احفظ التغييرات المحلية
git stash

# اسحب التحديثات
git pull origin main

# استرجع التغييرات المحلية
git stash pop
```

### إذا ظهر خطأ "Permission denied":
```bash
# تحقق من الصلاحيات
chmod -R 775 storage bootstrap/cache
```

### إذا لم تظهر التحديثات:
```bash
# احصل على آخر التحديثات
git fetch origin

# اعرض الفروقات
git log HEAD..origin/main

# اسحب التحديثات
git pull origin main
```

## التحقق من التحديثات:

بعد السحب، تحقق من:
```bash
git log --oneline -5
```

يجب أن ترى آخر commit:
```
744f795 Add cPanel deployment files and configuration
2045386 Initial commit: Gym Management Platform
```
