# Use PHP with Apache
FROM php:8.2-apache

# Install system dependencies
RUN apt-get update && apt-get install -y \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    libpq-dev \
    libzip-dev \
    zip \
    unzip \
    git \
    curl \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install gd pdo pdo_pgsql zip bcmath

# Enable Apache mod_rewrite
RUN a2enmod rewrite

# Set working directory
WORKDIR /var/www/html

# Copy application files
COPY . .

# Ensure storage directories exist and have correct permissions
RUN mkdir -p storage/app/public/properties \
    storage/framework/sessions \
    storage/framework/views \
    storage/framework/cache \
    storage/logs \
    bootstrap/cache

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Install dependencies (ignoring dev)
RUN composer install --no-dev --optimize-autoloader

# Create storage link
RUN php artisan storage:link

# Set permissions
RUN chown -R www-data:www-data storage bootstrap/cache public/storage
RUN chmod -R 775 storage bootstrap/cache

# Update Apache config to serve from public/, allow symlinks, and fix 400 Bad Request (LimitRequestFieldSize)
RUN sed -i 's!/var/www/html!/var/www/html/public!g' /etc/apache2/sites-available/000-default.conf \
    && echo "ServerName localhost" >> /etc/apache2/apache2.conf \
    && echo "LimitRequestFieldSize 65536" >> /etc/apache2/apache2.conf \
    && echo "LimitRequestLine 65536" >> /etc/apache2/apache2.conf \
    && printf '<Directory /var/www/html/public>\n\tOptions Indexes FollowSymLinks\n\tAllowOverride All\n\tRequire all granted\n</Directory>\n' >> /etc/apache2/apache2.conf

# Clean up any potential cached config/routes and link storage
RUN php artisan config:clear \
    && php artisan route:clear \
    && php artisan view:clear \
    && php artisan storage:link || true

# Expose port
EXPOSE 80

# Build assets with Vite
RUN apt-get install -y nodejs npm \
    && npm install \
    && npm run build

# Start Command
CMD php artisan config:clear && php artisan migrate --force && apache2-foreground
