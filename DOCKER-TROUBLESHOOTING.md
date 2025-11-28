# دليل حل مشاكل Docker Image - BizConsult

## 📋 ملخص المشاكل والحلول

هذا الدليل يوثق جميع المشاكل التي واجهناها أثناء بناء وتشغيل Docker image والحلول التي تم تطبيقها.

---

## 🔴 المشكلة 1: حجم Docker Image كبير جداً

### السبب:
- استخدام Debian-based images بدلاً من Alpine
- عدم فصل build dependencies عن production dependencies
- عدم حذف node_modules و composer cache بعد البناء

### الحل:
1. **استخدام Alpine-based images:**
   - `php:8.2-fpm-alpine` بدلاً من `php:8.2-fpm`
   - `composer:latest` (Alpine-based)
   - `node:20-alpine` للبناء

2. **تحسين Multi-Stage Build:**
   - **Stage 1 (node-builder)**: بناء frontend assets فقط
   - **Stage 2 (composer-builder)**: تثبيت PHP dependencies فقط
   - **Stage 3 (base)**: PHP runtime مع extensions
   - **Stage 4 (production)**: الصورة النهائية المحسّنة

3. **حذف Build Dependencies:**
   - حذف `g++`, `make`, `autoconf` بعد تثبيت extensions
   - عدم تضمين `nodejs`, `npm` في production
   - تنظيف npm و composer cache

### النتيجة:
- تقليل حجم الـ image من ~800-1000MB إلى ~200-300MB (تقليل بنسبة 60-70%)

---

## 🔴 المشكلة 2: خطأ `composer:2-alpine: not found`

### السبب:
- الـ tag `composer:2-alpine` غير موجود في Docker Hub

### الحل:
- استخدام `composer:latest` بدلاً منه (وهو Alpine-based بالفعل)

### الملفات المعدلة:
- `Dockerfile` - السطر 25

---

## 🔴 المشكلة 3: خطأ `libjpeg-dev (no such package)`

### السبب:
- في Alpine، اسم الحزمة مختلف: `libjpeg-turbo-dev` وليس `libjpeg-dev`

### الحل:
- تغيير `libjpeg-dev` إلى `libjpeg-turbo-dev`

### الملفات المعدلة:
- `Dockerfile` - السطر 58

---

## 🔴 المشكلة 4: خطأ 404 Not Found

### السبب:
1. **مسار Nginx خاطئ**: Nginx في Alpine يستخدم `/etc/nginx/conf.d/` وليس `/etc/nginx/sites-available/`
2. **fastcgi_pass خاطئ**: كان يشير إلى `app:9000` بدلاً من `127.0.0.1:9000` (لأن PHP-FPM في نفس container)

### الحل:
1. **تصحيح مسار Nginx config:**
   ```dockerfile
   COPY docker/nginx/default.conf /etc/nginx/conf.d/default.conf
   ```

2. **تصحيح fastcgi_pass:**
   ```nginx
   fastcgi_pass 127.0.0.1:9000;
   ```

### الملفات المعدلة:
- `Dockerfile` - السطر 125
- `docker/nginx/default.conf` - السطر 53

---

## 🔴 المشكلة 5: خطأ `"server" directive is not allowed here`

### السبب:
- ملف `nginx.conf` الرئيسي في Alpine لا يحتوي على `http` block
- Nginx يحتاج `http` block قبل استخدام `server` directive

### الحل:
- إنشاء ملف `nginx.conf` كامل يحتوي على `http` block

### الملفات المعدلة:
- `docker/nginx/nginx.conf` - ملف جديد
- `Dockerfile` - السطر 125 (نسخ nginx.conf)

### محتوى nginx.conf:
```nginx
user nginx;
worker_processes auto;
error_log /var/log/nginx/error.log warn;
pid /var/run/nginx.pid;

events {
    worker_connections 1024;
}

http {
    include /etc/nginx/mime.types;
    default_type application/octet-stream;
    log_format main '$remote_addr - $remote_user [$time_local] "$request" '
                    '$status $body_bytes_sent "$http_referer" '
                    '"$http_user_agent" "$http_x_forwarded_for"';
    access_log /var/log/nginx/access.log main;
    sendfile on;
    tcp_nopush on;
    tcp_nodelay on;
    keepalive_timeout 65;
    types_hash_max_size 2048;
    client_max_body_size 20M;
    include /etc/nginx/conf.d/*.conf;
}
```

---

## 🔴 المشكلة 6: خطأ 500 Internal Server Error - `Class "Redis" not found`

### السبب:
- PHP Redis extension غير مثبت في الـ image
- Laravel يحاول استخدام Redis للـ cache و sessions لكن extension غير موجود

### الحل:

#### الحل السريع (للـ Container الحالي):
```bash
# تغيير CACHE_DRIVER و SESSION_DRIVER إلى file
docker exec bizconsult_test_app sh -c 'sed -i "s/CACHE_DRIVER=redis/CACHE_DRIVER=file/" /var/www/html/.env'
docker exec bizconsult_test_app sh -c 'sed -i "s/SESSION_DRIVER=redis/SESSION_DRIVER=file/" /var/www/html/.env'
docker exec bizconsult_test_app php artisan config:clear
```

#### الحل الدائم:
- تثبيت Redis extension في Dockerfile:
  ```dockerfile
  RUN pecl install redis && docker-php-ext-enable redis
  ```

### الملفات المعدلة:
- `Dockerfile` - السطر 91-92
- `fix-redis-container.sh` - script للحل السريع

---

## 🔴 المشكلة 7: خطأ `redis-dev (no such package)`

### السبب:
- محاولة تثبيت `redis-dev` من Alpine repositories لكنه غير موجود

### الحل:
- إزالة `redis-dev` من build-deps
- PECL يمكنه تثبيت Redis extension بدون redis-dev

### الملفات المعدلة:
- `Dockerfile` - إزالة `redis-dev` من السطر 64

---

## 📁 الملفات التي تم إنشاؤها/تعديلها

### ملفات Docker:
1. **Dockerfile** - تحسين شامل:
   - استخدام Alpine images
   - Multi-stage build محسّن
   - إضافة Redis extension
   - إصلاح إعدادات Nginx

2. **docker/nginx/nginx.conf** - ملف جديد:
   - ملف nginx.conf كامل مع http block

3. **docker/nginx/default.conf** - تعديل:
   - تصحيح fastcgi_pass إلى 127.0.0.1:9000

### ملفات الاختبار:
1. **docker-compose.test.yml** - للاختبار السريع
2. **TESTING.md** - دليل خطوة بخطوة
3. **test-script.sh** - script للاختبار التلقائي
4. **.env.example** - ملف متغيرات البيئة

### Scripts للإصلاح:
1. **fix-nginx.sh** - إصلاح إعدادات Nginx
2. **fix-nginx-conf.sh** - إصلاح nginx.conf
3. **fix-redis-container.sh** - حل مؤقت لمشكلة Redis
4. **check-status.sh** - التحقق من الحالة
5. **view-logs.sh** - عرض السجلات

---

## ✅ الحلول النهائية المطبقة

### 1. تحسين حجم Image:
- ✅ استخدام Alpine-based images
- ✅ Multi-stage build محسّن
- ✅ حذف build dependencies من production

### 2. إصلاح Nginx:
- ✅ إنشاء nginx.conf كامل
- ✅ تصحيح مسار config files
- ✅ تصحيح fastcgi_pass

### 3. إصلاح Redis:
- ✅ تثبيت Redis extension في Dockerfile
- ✅ حل مؤقت: تغيير CACHE_DRIVER و SESSION_DRIVER إلى file

### 4. إصلاح Dependencies:
- ✅ تصحيح أسماء الحزم في Alpine
- ✅ إزالة dependencies غير موجودة

---

## 🚀 خطوات البناء النهائية

```bash
# 1. بناء الـ image
docker build -t ibrahimaamer/bizconsult:latest --target production .

# 2. رفع الـ image
docker push ibrahimaamer/bizconsult:latest

# 3. اختبار الـ image
docker-compose -f docker-compose.test.yml up -d

# 4. إعداد Laravel
docker exec bizconsult_test_app php artisan key:generate --force
docker exec bizconsult_test_app php artisan migrate --force
```

---

## 📝 ملاحظات مهمة

1. **Alpine vs Debian:**
   - Alpine أصغر بكثير لكن أسماء الحزم مختلفة
   - بعض الحزم قد لا تكون متوفرة في Alpine

2. **Nginx في Alpine:**
   - يستخدم `/etc/nginx/conf.d/` وليس `/etc/nginx/sites-available/`
   - يحتاج `http` block في nginx.conf الرئيسي

3. **PHP-FPM في Production:**
   - يعمل على `127.0.0.1:9000` داخل container
   - لا يحتاج network بين containers

4. **Redis Extension:**
   - يمكن تثبيته عبر PECL بدون redis-dev
   - أو استخدام file driver كحل بديل

---

## 🔧 أوامر مفيدة للتصحيح

```bash
# التحقق من حالة Containers
docker-compose -f docker-compose.test.yml ps

# عرض السجلات
docker logs bizconsult_test_app --tail 50

# التحقق من Nginx
docker exec bizconsult_test_app nginx -t

# التحقق من PHP Extensions
docker exec bizconsult_test_app php -m | grep redis

# عرض سجلات Laravel
docker exec bizconsult_test_app sh -c "cat /var/www/html/storage/logs/laravel.log" | tail -50
```

---

## 📊 النتائج النهائية

- ✅ حجم Image: ~200-300MB (بدلاً من ~800-1000MB)
- ✅ Nginx يعمل بشكل صحيح
- ✅ PHP-FPM يعمل بشكل صحيح
- ✅ Redis extension مثبت
- ✅ جميع المشاكل تم حلها

---

**تم إنشاء هذا الدليل بتاريخ: 2025-11-28**

