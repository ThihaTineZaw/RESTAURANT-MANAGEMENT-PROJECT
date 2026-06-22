#!/usr/bin/env bash

echo "Running composer..."
composer install --no-dev --optimize-autoloader --working-dir=/var/www/html

echo "Generating optimized autoload..."
composer dump-autoload --optimize

echo "Clearing Laravel cache..."
php artisan optimize:clear

echo "Linking storage..."
php artisan storage:link || true

echo "Running migrations..."
php artisan migrate:refresh --force

echo "Running seeders..."
php artisan db:seed --force



echo "Caching Laravel..."
php artisan config:cache
php artisan route:cache
php artisan view:cache

echo "Deployed successfully"
