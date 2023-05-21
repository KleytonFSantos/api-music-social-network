#!/usr/bin/env bash
echo "Running composer"
composer global require hirak/prestissimo
composer install --no-dev --working-dir=/var/www/html

# shellcheck disable=SC2164
chmod -R 777 /var/www/html/
chmod -R 775 /var/www/html/
mkdir -p /var/www/html/storage/framework/{sessions,views,cache}
chmod -R 775 /var/www/html/storage/framework/

echo "Caching config..."
php artisan config:clear
php artisan view:clear

echo "Caching routes..."
php artisan route:cache

echo "Running migrations..."
php artisan migrate --force



echo "Setting cache permissions..."
chmod -R 777 /var/www/html/storage/framework/cache
chmod -R 777 /var/www/html/storage/framework/views/
chmod -R 775 /var/www/html/storage/framework/views/
chmod -R 777 /var/www/html/storage/framework
chmod -R 775 /var/www/html/storage/framework
chmod -R 775 /var/www/html/storage/framework/cache
chmod -R 775 /var/www/html/bootstrap/cache
chmod -R 777 /var/www/html/bootstrap/cache
