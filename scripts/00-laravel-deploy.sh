#!/usr/bin/env bash
echo "Running composer"
composer install --no-dev --working-dir=/var/www/html

echo "Optimizing Laravel..."
php artisan optimize:clear
echo "Clearing config..."
php artisan config:clear
echo "Clearing cache..."
php artisan cache:clear
echo "Caching config..."
php artisan config:cache
echo "Caching routes..."
php artisan route:cache

echo "Running migrations..."
php artisan migrate:fresh --seed

