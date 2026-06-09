FROM php:8.4-apache

# Install system dependencies
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    libpng-dev \
    libjpeg-dev \
    libzip-dev \
    zlib1g-dev \
    libfreetype6-dev \
    pkg-config \
    libicu-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install gd pdo pdo_mysql mysqli bcmath intl zip \
    && rm -rf /var/lib/apt/lists/*

# Change Apache Document Root to public/ and enable mod_rewrite
ENV APACHE_DOCUMENT_ROOT /var/www/html/public
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf
RUN a2enmod rewrite

# Install Composer (multi-stage)
COPY --from=composer:2.7 /usr/bin/composer /usr/bin/composer

# Set working directory
WORKDIR /var/www/html

# Copy application source
COPY . /var/www/html

# Install PHP dependencies (no dev)
RUN composer install --no-dev --optimize-autoloader

# Skipping config, route and view cache during build (handled at runtime)
# RUN php artisan config:cache && php artisan route:cache && php artisan view:cache

# Set proper permissions for storage and cache directories
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

# Expose port 80 (default for Apache)
EXPOSE 80

# Start Apache in foreground
CMD ["apache2-foreground"]
