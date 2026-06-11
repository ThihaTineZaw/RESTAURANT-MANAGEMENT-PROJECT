#!/usr/bin/env bash
set -e

echo "Running composer..."
composer install --no-dev --optimize-autoloader --no-interaction --working-dir=/var/www/html

echo "Caching config..."
php artisan config:cache

echo "Caching routes..."
php artisan route:cache

echo "Running migrations..."
php artisan migrate --seed --force