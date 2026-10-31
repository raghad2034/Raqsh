FROM php:8.3-cli-alpine

# تثبيت متطلبات PostgreSQL وامتدادات PHP اللازمة
RUN apk add --no-cache git unzip libzip-dev postgresql-dev \
    && docker-php-ext-install pdo pdo_pgsql zip

WORKDIR /app
COPY . .

# تثبيت Composer وحزم المشروع
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
RUN composer install --no-dev --optimize-autoloader --no-interaction

EXPOSE 10000

# تشغيل الـ Migrations لإنشاء الجداول في Supabase ثم بدء الخادم
CMD php artisan config:cache && php artisan route:cache && php artisan view:cache && php artisan serve --host=0.0.0.0 --port=10000