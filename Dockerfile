# === STAGE 1: Frontend Build ===
FROM node:20-alpine AS frontend-builder
WORKDIR /app

# Copy package files and install frontend dependencies
COPY package*.json ./
RUN npm ci

# Copy Vite configuration and source files
COPY vite.config.js tailwind.config.js* postcss.config.js* ./
COPY resources/ ./resources/
COPY public/ ./public/

# Compile assets into public/build
RUN npm run build

# === STAGE 2: Production PHP/Nginx Application ===
FROM richarvey/nginx-php-fpm:3.1.6
WORKDIR /var/www/html

# Copy the entire backend application source code
COPY . .

# Copy compiled Vite assets from Stage 1 into the production public directory
COPY --from=frontend-builder /app/public/build ./public/build

# Base image configurations for Render
ENV WEBROOT /var/www/html/public
ENV PHP_ERRORS_STDERR 1
ENV RUN_SCRIPTS 1
ENV REAL_IP_HEADER 1

# Production Laravel environment defaults
ENV APP_ENV production
ENV APP_DEBUG false
ENV LOG_CHANNEL stderr
ENV COMPOSER_ALLOW_SUPERUSER 1

# Run optimized Composer installation for production
RUN composer install --no-interaction --optimize-autoloader --no-dev

# Set permissions for Laravel directories
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

# Make entrypoint script executable
RUN chmod +x /var/www/html/docker-entrypoint.sh
ENTRYPOINT ["/var/www/html/docker-entrypoint.sh"]

# Boot up the web server
CMD ["/start.sh"]
