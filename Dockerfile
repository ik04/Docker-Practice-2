FROM php:8.1-fpm

# Install required packages
RUN apt-get update && apt-get install -y \
    zip \
    unzip \
    libzip-dev \
    libonig-dev \
    libgd-dev \
    sqlite3 \
    libsqlite3-dev \
    nginx \
    && docker-php-ext-install zip pdo_mysql gd pdo_sqlite \
    && apt-get clean

# Configure Nginx
COPY nginx/default.conf /etc/nginx/sites-available/default

# Set the working directory
WORKDIR /var/www/html

# Copy application files
COPY . /var/www/html

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer \
    && composer install --optimize-autoloader --no-dev

# Set file permissions
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache \
    && chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache

# Expose ports
EXPOSE 80

# Start services
CMD cp .env.example .env \
    && php artisan migrate --force \
    && service nginx start \
    && php-fpm
