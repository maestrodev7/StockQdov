#!/bin/bash
set -e # Exit immediately if a command exits with a non-zero status

# Wait for the database to be available
echo "Waiting for MySQL to be fully ready..."
until mysqladmin --protocol=tcp ping -h"db" -u root -pmonMotDePasseSecurise --silent; do
  echo "MySQL is unavailable - sleeping"
  sleep 2
done
echo "MySQL is fully ready."


# Install dependencies
COMPOSER_MEMORY_LIMIT=-1 composer install --no-dev --optimize-autoloader
echo "Composer install exit code: $?"

# Run migrations and seeders
php artisan migrate --force
php artisan storage:link

# Set file permissions
chown -R www-data:www-data /var/www/storage /var/www/bootstrap/cache
chmod -R 755 /var/www/public
find /var/www/storage -type d -exec chmod 775 {} \;
find /var/www/storage -type f -exec chmod 664 {} \;


# Démarrer Supervisor
exec php-fpm
