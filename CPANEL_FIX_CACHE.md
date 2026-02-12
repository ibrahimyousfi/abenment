# حل مشكلة Cache Table Not Found

## المشكلة:
```
SQLSTATE[42S02]: Base table or view not found: 1146 Table 'swissleg_abonnements.cache' doesn't exist
```

## الحل:

### 1. تشغيل Migrations أولاً:

```bash
php artisan migrate --force
```

هذا الأمر سينشئ جميع الجداول المطلوبة بما فيها جدول `cache`.

### 2. بعد تشغيل Migrations، يمكنك مسح الكاش:

```bash
php artisan config:clear
php artisan cache:clear
php artisan view:clear
php artisan route:clear
```

### 3. إذا استمرت المشكلة، استخدم:

```bash
# مسح كاش التكوين فقط (لا يحتاج قاعدة بيانات)
php artisan config:clear

# مسح كاش العرض
php artisan view:clear

# مسح كاش المسارات
php artisan route:clear

# لتشغيل migrations
php artisan migrate --force
```

## ملاحظة:

في Laravel، عندما يكون `CACHE_STORE=database` في ملف `.env`، فإن `php artisan cache:clear` يحتاج إلى جدول `cache` في قاعدة البيانات. لذلك يجب تشغيل migrations أولاً.
