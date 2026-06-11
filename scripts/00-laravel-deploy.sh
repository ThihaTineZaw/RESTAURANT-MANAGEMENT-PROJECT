#!/bin/sh
set -e

echo "Caching Laravel configuration..."
php artisan config:cache
php artisan route:cache
php artisan view:cache

if [ "$RUN_MIGRATIONS" = "true" ]; then
    echo "Running database migrations..."
    php artisan migrate:fresh --seed  --force
fi

exec "$@"
