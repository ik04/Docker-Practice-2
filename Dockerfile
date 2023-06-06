FROM php:8.1-fpm

RUN apt-get update && apt-get install -y \
    zip \
    unzip \
    libzip-dev \
    libonig-dev \
    libgd-dev \
    sqlite3 \
    libsqlite3-dev \
    && docker-php-ext-install zip pdo_mysql gd pdo_sqlite \
    && apt-get clean

WORKDIR /var/www/html

COPY . /var/www/html

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer \
    && composer install --optimize-autoloader --no-dev

RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache \
    && chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache

EXPOSE 8000

CMD cp .env.example .env \
    && php artisan migrate --force\
    && php artisan serve --host=0.0.0.0 --port=8000
