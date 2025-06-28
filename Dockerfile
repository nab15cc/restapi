FROM php:8.2-apache

# Install dependencies
RUN apt-get update && apt-get install -y \
    git unzip zip sqlite3 libsqlite3-dev libzip-dev \
    && docker-php-ext-install pdo pdo_sqlite zip

# Enable Apache mod_rewrite
RUN a2enmod rewrite

# Set document root to /var/www/html/public
ENV APACHE_DOCUMENT_ROOT=/var/www/html/public

# Update Apache config to use new document root
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf \
    && sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf

# Copy project files
COPY . /var/www/html

# Set working directory
WORKDIR /var/www/html

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Install Laravel dependencies
RUN composer install --no-dev --optimize-autoloader

# Set Laravel permissions
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html/storage \
    && chmod -R 755 /var/www/html/bootstrap/cache

EXPOSE 80
