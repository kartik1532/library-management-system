#!/bin/sh

set -e

echo "Starting Laravel application..."

# Ensure Laravel storage directories exist
mkdir -p /var/www/html/storage/framework/cache
mkdir -p /var/www/html/storage/framework/sessions
mkdir -p /var/www/html/storage/framework/views
mkdir -p /var/www/html/storage/logs
mkdir -p /var/www/html/bootstrap/cache

# Create the public storage symlink if it doesn't already exist
php artisan storage:link || true

# Cache Laravel configuration
php artisan config:cache

# Cache routes
php artisan route:cache

# Cache Blade views
php artisan view:cache

# Make sure Laravel can write to required directories
chown -R www-data:www-data /var/www/html/storage
chown -R www-data:www-data /var/www/html/bootstrap/cache

echo "Starting PHP-FPM..."
php-fpm -D

echo "Starting Nginx..."
nginx -g "daemon off;"