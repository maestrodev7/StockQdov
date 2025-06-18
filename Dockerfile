FROM php:8.2-fpm

RUN apt-get update && apt-get install -y \
    libpng-dev \
    libjpeg62-turbo-dev \
    libfreetype6-dev \
    libzip-dev \
    zip \
    unzip \
    default-mysql-client \
    curl \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install gd pdo pdo_mysql pcntl zip

# Set working directory
WORKDIR /var/www

# Copy application code (excluding vendor)
COPY . /var/www

COPY --from=composer /usr/bin/composer /usr/bin/composer


# Set file permissions
RUN chown -R www-data:www-data /var/www/storage /var/www/bootstrap/cache \
    && chmod -R 755 /var/www/public \
    && chmod -R 775 /var/www/storage /var/www/bootstrap/cache

# Copy entrypoint script
COPY entrypoint.sh /entrypoint.sh
RUN chmod +x /entrypoint.sh

# Expose port
EXPOSE 9000

CMD ["/entrypoint.sh"]
