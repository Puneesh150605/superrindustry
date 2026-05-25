FROM php:8.4-apache

# 1. Install system dependencies
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    sqlite3 \
    libsqlite3-dev

# 2. Clear cache
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# 3. Install PHP extensions
RUN docker-php-ext-install pdo_sqlite mbstring exif pcntl bcmath gd

# 4. Install Node.js (Required for Vite / Tailwind)
RUN curl -fsSL https://deb.nodesource.com/setup_20.x | bash - \
    && apt-get install -y nodejs

# 5. Enable Apache mod_rewrite for Laravel routing
RUN a2enmod rewrite

# 6. Set DocumentRoot to Laravel's public directory
ENV APACHE_DOCUMENT_ROOT /var/www/html/public
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf

# 7. Get latest Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# 8. Set working directory
WORKDIR /var/www/html

# 9. Copy existing application directory
COPY . /var/www/html

# 10. Install PHP Dependencies (No dev packages for production)
RUN composer install --optimize-autoloader --no-dev

# 11. Install Node Dependencies and Build Assets
RUN npm install
RUN npm run build

# 12. Backup the populated database for the persistent disk mount
RUN cp /var/www/html/database/database.sqlite /initial_db.sqlite

# 13. Set proper permissions for Laravel
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache /var/www/html/database
RUN chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache /var/www/html/database

# 14. Make entrypoint script executable
RUN chmod +x /var/www/html/entrypoint.sh

# Expose port 80 and start Apache via Entrypoint
EXPOSE 80
CMD ["/var/www/html/entrypoint.sh"]
