FROM php:8.3-cli-alpine

# تثبيت متطلبات النظام وامتدادات قواعد البيانات لـ Laravel
RUN apk add --no-cache git unzip libzip-dev sqlite-dev \
    && docker-php-ext-install pdo pdo_mysql pdo_sqlite zip

WORKDIR /app
COPY . .

# تثبيت Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# تثبيت حزم المشروع وتخطي فحص البيئة الصارم
RUN composer install --no-dev --optimize-autoloader --no-interaction

EXPOSE 10000

CMD php artisan serve --host=0.0.0.0 --port=10000