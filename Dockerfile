# ============================================
# Dockerfile for BizConsult Laravel Application
# Optimized for smaller image size using Alpine
# ============================================

ARG APP_ENV=local

# ============================================
# Stage 1: Builder - لبناء Assets و Dependencies
# ============================================
FROM node:20-alpine AS node-builder

WORKDIR /app

# نسخ ملفات Node.js وبناء Assets
COPY package.json package-lock.json ./
RUN npm ci && npm cache clean --force

COPY . .
RUN npm run build

# ============================================
# Stage 2: PHP Builder - لتثبيت PHP Dependencies
# ============================================
FROM composer:latest AS composer-builder

WORKDIR /app

# نسخ ملفات Composer
COPY composer.json composer.lock ./

# تثبيت PHP Dependencies (بدون dev dependencies للـ production)
RUN composer install \
    --no-interaction \
    --prefer-dist \
    --ignore-platform-reqs \
    --optimize-autoloader \
    --no-scripts \
    --no-dev \
    && composer clear-cache

# ============================================
# Stage 3: Base PHP Image - مع جميع Extensions
# ============================================
FROM php:8.2-fpm-alpine AS base

ARG APP_ENV=local

# تثبيت System Dependencies الأساسية فقط
RUN apk add --no-cache --virtual .build-deps \
    $PHPIZE_DEPS \
    git \
    curl \
    unzip \
    zip \
    libzip-dev \
    libpng-dev \
    libjpeg-turbo-dev \
    freetype-dev \
    icu-dev \
    oniguruma-dev \
    zlib-dev \
    mariadb-dev \
    && apk add --no-cache \
    libzip \
    libpng \
    libjpeg-turbo \
    freetype \
    icu \
    oniguruma \
    zlib \
    mariadb-client \
    supervisor \
    nginx

# تثبيت PHP Extensions
RUN docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-configure intl \
    && docker-php-ext-install -j$(nproc) \
    gd \
    intl \
    pdo_mysql \
    mysqli \
    mbstring \
    exif \
    pcntl \
    bcmath \
    zip

# تثبيت Redis Extension
# PECL يحتاج autoconf و g++ (موجودان بالفعل في build-deps)
RUN pecl install redis && docker-php-ext-enable redis

# تنظيف Build Dependencies (بعد تثبيت Redis)
RUN apk del .build-deps

# إعداد Opcache
RUN echo "opcache.enable=1" >> /usr/local/etc/php/conf.d/opcache.ini \
    && echo "opcache.memory_consumption=128" >> /usr/local/etc/php/conf.d/opcache.ini \
    && echo "opcache.interned_strings_buffer=8" >> /usr/local/etc/php/conf.d/opcache.ini \
    && echo "opcache.max_accelerated_files=4000" >> /usr/local/etc/php/conf.d/opcache.ini \
    && echo "opcache.revalidate_freq=2" >> /usr/local/etc/php/conf.d/opcache.ini \
    && echo "opcache.fast_shutdown=1" >> /usr/local/etc/php/conf.d/opcache.ini

# تعيين Working Directory
WORKDIR /var/www/html

# نسخ باقي ملفات المشروع أولاً
COPY . .

# نسخ PHP Dependencies من Composer Builder (تم تحسين autoloader بالفعل)
COPY --from=composer-builder /app/vendor ./vendor

# نسخ Built Assets من Node Builder
COPY --from=node-builder /app/public/build ./public/build

# ضبط Permissions
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html/storage \
    && chmod -R 755 /var/www/html/bootstrap/cache

# ============================================
# Stage 4: Production Image - النهائي المحسّن
# ============================================
FROM base AS production

# نسخ إعدادات Nginx و Supervisor
# نسخ ملف nginx.conf الرئيسي (يحتوي على http block)
COPY docker/nginx/nginx.conf /etc/nginx/nginx.conf
# نسخ ملف server config
COPY docker/nginx/default.conf /etc/nginx/conf.d/default.conf
COPY docker/supervisord.conf /etc/supervisor/conf.d/supervisord.conf

# حذف ملف Nginx الافتراضي إذا كان موجوداً
RUN rm -f /etc/nginx/conf.d/default.conf.bak 2>/dev/null || true

# إنشاء مجلدات السجلات المطلوبة
RUN mkdir -p /var/log/nginx /var/log/php-fpm \
    && touch /var/log/nginx/access.log /var/log/nginx/error.log \
    && touch /var/log/php-fpm.err.log /var/log/php-fpm.out.log \
    && chmod 755 /var/log/nginx /var/log/php-fpm

# التحقق من صحة إعدادات Nginx (يجب أن ينجح)
RUN nginx -t

# فتح Port 80
EXPOSE 80

# تشغيل Supervisor (PHP-FPM + Nginx)
CMD ["/usr/bin/supervisord", "-c", "/etc/supervisor/conf.d/supervisord.conf"]
