#!/usr/bin/env bash
echo "Running composer"
composer global require hirak/prestissimo
composer install --no-dev --working-dir=/var/www/html

echo "Caching config..."
php artisan config:cache

echo "Caching routes..."
php artisan route:cache

echo "Running migrations..."
php artisan migrate --force

echo "Setting cache permissions..."
chmod -R 777 /var/www/html/storage/framework/cache
chmod -R 775 storage/framework/cache
chmod -R 775 bootstrap/cache
chmod -R 777 /var/www/html/bootstrap/cache
