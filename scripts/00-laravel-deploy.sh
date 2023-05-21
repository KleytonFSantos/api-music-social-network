#!/usr/bin/env bash
echo "Running composer"
composer global require hirak/prestissimo
composer install --no-dev --working-dir=/var/www/html

# shellcheck disable=SC2164
mkdir -p /var/www/html/storage/framework/{sessions,views,cache}
chmod -R 775 framework

echo "Caching config..."
php artisan cache:clear
php artisan config:clear
php artisan view:clea

echo "Caching routes..."
php artisan route:cache

echo "Running migrations..."
php artisan migrate --force



echo "Setting cache permissions..."
chmod -R 777 /var/www/html/storage/framework/cache
chmod -R 777 /var/www/html/storage/framework
chmod -R 775 /var/www/html/storage/framework
chmod -R 775 /var/www/html/storage/framework/cache
chmod -R 775 /var/www/html/bootstrap/cache
chmod -R 777 /var/www/html/bootstrap/cache
