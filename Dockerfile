# === STAGE 1: Frontend Build ===
FROM node:20-alpine AS frontend-builder
WORKDIR /app
COPY package*.json ./
RUN npm ci
COPY vite.config.js tailwind.config.js* postcss.config.js* ./
COPY resources/ ./resources/
COPY public/ ./public/
RUN npm run build

# === STAGE 2: PHP Dependency Builder (Free-Tier Memory Save) ===
FROM composer:2.8 AS php-builder
WORKDIR /app
# Only copy dependency definitions first to maximize layer caching
COPY composer.json composer.lock ./
# Install without dev tools, ignoring platform restrictions to keep memory usage under ~100MB
RUN composer install --no-interaction --optimize-autoloader --no-dev --no-scripts --ignore-platform-reqs --no-audit

# === STAGE 3: Final Production Image ===
FROM richarvey/nginx-php-fpm:3.1.6
WORKDIR /var/www/html

# Copy your application source files
COPY . .

# Inject the pre-built items from Stage 1 and Stage 2
COPY --from=frontend-builder /app/public/build ./public/build
COPY --from=php-builder /app/vendor ./vendor

# Render Specific Environment Configurations
ENV WEBROOT /var/www/html/public
ENV PHP_ERRORS_STDERR 1
ENV RUN_SCRIPTS 1
ENV REAL_IP_HEADER 1
ENV APP_ENV production
ENV APP_DEBUG false
ENV LOG_CHANNEL stderr

# Fix directory permissions for Laravel
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

# Make entrypoint script executable
RUN chmod +x /var/www/html/docker-entrypoint.sh
ENTRYPOINT ["/var/www/html/docker-entrypoint.sh"]

# Start Nginx & PHP-FPM
CMD ["/start.sh"]
