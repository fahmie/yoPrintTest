FROM php:8.1-apache

# Install system packages and PHP extensions
RUN apt-get update && apt-get install -y \
    git curl zip unzip libzip-dev \
    sqlite3 libsqlite3-dev \
    supervisor \
    && docker-php-ext-install pdo pdo_sqlite zip pcntl \
    && pecl install redis && docker-php-ext-enable redis

RUN echo "upload_max_filesize = 50M" >> /usr/local/etc/php/php.ini \
 && echo "post_max_size = 50M" >> /usr/local/etc/php/php.ini \
 && echo "memory_limit = 128M" >> /usr/local/etc/php/php.ini

# Enable Apache mod_rewrite
RUN a2enmod rewrite

# Install Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Install Node.js 18 and npm
RUN curl -fsSL https://deb.nodesource.com/setup_18.x | bash - \
    && apt-get install -y nodejs

# Set working directory
WORKDIR /var/www

# Copy package.json and install npm dependencies
COPY package*.json ./
RUN npm install

# Copy full Laravel app code
COPY . .

# Build Vite assets
RUN npm run build

# Create SQLite database file
RUN mkdir -p /var/www/database \
    && touch /var/www/database/database.sqlite \
    && chmod -R 775 /var/www/database

# Set Laravel specific permissions
RUN chmod -R 775 storage bootstrap/cache

# Set ownership to www-data for entire Laravel app
RUN chown -R www-data:www-data /var/www

# Set Apache public root to /var/www/public
ENV APACHE_DOCUMENT_ROOT /var/www/public
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf

# Copy Supervisor configuration
COPY supervisord.conf /etc/supervisord.conf

# Expose Apache port
EXPOSE 80

# Run Supervisor
CMD ["/usr/bin/supervisord", "-c", "/etc/supervisord.conf"]
