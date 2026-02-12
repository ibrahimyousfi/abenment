# Gym Management Platform

نظام إدارة شامل لصالات الألعاب الرياضية مبني على Laravel 12.

## المميزات

- **إدارة الصالات**: نظام متعدد الصالات مع إدارة المشتركين
- **إدارة الأعضاء**: تسجيل الأعضاء، الاشتراكات، والتجديدات
- **أنواع التدريب**: إدارة أنواع التدريب والخطط المختلفة
- **الجلسات التدريبية**: جدولة الجلسات والحجوزات
- **إدارة المدربين**: إدارة المدربين وجدولهم
- **نقطة البيع (POS)**: نظام بيع المنتجات
- **الفواتير والمدفوعات**: إدارة الفواتير والمدفوعات
- **المصاريف**: تتبع المصاريف والتقارير المالية
- **المعدات**: إدارة المعدات وسجلات الصيانة
- **لوحة تحكم Super Admin**: إدارة جميع الصالات من لوحة واحدة

## المتطلبات

- PHP >= 8.2
- Composer
- Node.js & NPM
- SQLite أو MySQL/MariaDB

## التثبيت

1. استنساخ المشروع:
```bash
git clone https://github.com/ibrahimyousfi/abenment.git
cd abenment
```

2. تثبيت التبعيات:
```bash
composer install
npm install
```

3. إعداد ملف البيئة:
```bash
cp .env.example .env
php artisan key:generate
```

4. إعداد قاعدة البيانات:
```bash
# إذا كنت تستخدم SQLite (افتراضي)
touch database/database.sqlite

# أو قم بتعديل .env لاستخدام MySQL/MariaDB
php artisan migrate
php artisan db:seed
```

5. إنشاء رابط التخزين:
```bash
php artisan storage:link
```

6. بناء الأصول:
```bash
npm run build
```

7. تشغيل الخادم:
```bash
php artisan serve
```

## الاستخدام

### إنشاء حساب Super Admin

قم بتشغيل Seeder لإنشاء حساب Super Admin:
```bash
php artisan db:seed --class=SuperAdminSeeder
```

### الوصول

- **Super Admin**: `/super-admin`
- **Gym Admin**: `/gym-admin`
- **الصفحة الرئيسية**: `/`

## البنية

```
app/
├── Http/
│   ├── Controllers/
│   │   ├── GymAdmin/      # Controllers لإدارة الصالة
│   │   └── SuperAdmin/     # Controllers للإدارة العامة
│   ├── Middleware/         # Middleware مخصص
│   └── Requests/           # Form Requests
├── Models/                  # Eloquent Models
└── Notifications/           # Notifications

resources/
├── views/                   # Blade Templates
└── css/                     # CSS Files

routes/
├── web.php                  # Routes العامة
├── gym_admin.php            # Routes إدارة الصالة
└── super_admin.php          # Routes Super Admin
```

## الاختبارات

```bash
php artisan test
```

## التقنيات المستخدمة

- **Backend**: Laravel 12
- **Frontend**: Blade Templates, Tailwind CSS, Alpine.js
- **Database**: SQLite/MySQL/MariaDB
- **Build Tool**: Vite

## الترخيص

هذا المشروع مفتوح المصدر ومتاح تحت رخصة MIT.

## المساهمة

نرحب بمساهماتكم! يرجى فتح Issue أو Pull Request.

## الدعم

للدعم والاستفسارات، يرجى فتح Issue في المستودع.
