# ============================================
# Stage 1: Build frontend assets (Node.js)
# ============================================
FROM node:20-alpine AS frontend-builder

WORKDIR /app

# Copy package files first (for caching)
COPY package.json package-lock.json* ./

# Install npm dependencies
RUN npm ci

# Copy all source code
COPY . .

# Build Tailwind CSS + Vite assets
RUN npm run build

# ============================================
# Stage 2: Install PHP dependencies (Composer)
# ============================================
FROM composer:2 AS composer-builder

WORKDIR /app

COPY composer.json composer.lock ./

RUN composer install \
    --no-dev \
    --no-scripts \
    --no-autoloader \
    --prefer-dist

COPY . .

RUN composer dump-autoload --optimize

# ============================================
# Stage 3: Final production image
# ============================================
FROM php:8.2-fpm-alpine

# Install system dependencies
RUN apk add --no-cache \
    nginx \
    supervisor \
    libpq-dev \
    libzip-dev \
    zip \
    unzip \
    curl

# Install PHP extensions
RUN docker-php-ext-install \
    pdo \
    pdo_pgsql \
    pgsql \
    zip \
    opcache

# Configure PHP for production
RUN mv "$PHP_INI_DIR/php.ini-production" "$PHP_INI_DIR/php.ini"

# Set working directory
WORKDIR /var/www/html

# Copy application code
COPY . .

# Copy composer dependencies from builder
COPY --from=composer-builder /app/vendor ./vendor

# Copy built frontend assets from builder
COPY --from=frontend-builder /app/public/build ./public/build

# Create Nginx config
RUN cat > /etc/nginx/http.d/default.conf << 'EOF'
server {
    listen 80;
    server_name _;
    root /var/www/html/public;
    index index.php;

    client_max_body_size 50M;

    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }

    location ~ \.php$ {
        fastcgi_pass 127.0.0.1:9000;
        fastcgi_index index.php;
        fastcgi_param SCRIPT_FILENAME $document_root$fastcgi_script_name;
        include fastcgi_params;
    }

    location ~ /\.(?!well-known).* {
        deny all;
    }
}
EOF

# Create Supervisor config
RUN cat > /etc/supervisord.conf << 'EOF'
[supervisord]
nodaemon=true
user=root

[program:php-fpm]
command=php-fpm
autostart=true
autorestart=true

[program:nginx]
command=nginx -g "daemon off;"
autostart=true
autorestart=true
EOF

# Set permissions
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache
RUN chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache

# Create entrypoint script
RUN cat > /var/www/html/docker-entrypoint.sh << 'SCRIPT'
#!/bin/sh
set -e

echo "=== Running migrations ==="
php artisan migrate --force

echo "=== Caching config ==="
php artisan config:cache

echo "=== Caching routes ==="
php artisan route:cache

echo "=== Caching views ==="
php artisan view:cache

echo "=== Creating storage link ==="
php artisan storage:link || true

echo "=== Starting application ==="
exec /usr/bin/supervisord -c /etc/supervisord.conf
SCRIPT

RUN chmod +x /var/www/html/docker-entrypoint.sh

EXPOSE 80

ENTRYPOINT ["/var/www/html/docker-entrypoint.sh"]