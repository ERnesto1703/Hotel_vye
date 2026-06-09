FROM php:8.2-apache

# Install system dependencies
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install gd pdo pdo_mysql mysqli bcmath

# Install Composer (multi-stage)
COPY --from=composer:2.7 /usr/bin/composer /usr/bin/composer

# Set working directory
WORKDIR /var/www/html

# Copy application source
COPY . /var/www/html

# Install PHP dependencies (no dev)
RUN composer install --no-dev --optimize-autoloader

# Cache Laravel config, routes and views
RUN php artisan config:cache && php artisan route:cache && php artisan view:cache

# Set proper permissions for storage and cache directories
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

# Expose port 80 (default for Apache)
EXPOSE 80

# Start Apache in foreground
CMD ["apache2-foreground"]
