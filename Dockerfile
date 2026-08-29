# ==========================================
# STAGE 1: Frontend Asset Compilation (Vite)
# ==========================================
FROM node:20-alpine AS frontend-builder
WORKDIR /app

COPY package*.json ./
RUN npm ci

COPY resources/ ./resources/
COPY vite.config.js tailwind.config.js* postcss.config.js* ./
RUN npm run build

# ==========================================
# STAGE 2: Composer Dependencies Installation
# ==========================================
FROM composer:2.7 AS composer-builder
WORKDIR /app

COPY composer.json composer.lock ./
RUN composer install \
    --no-dev \
    --no-interaction \
    --prefer-dist \
    --no-scripts \
    --no-autoloader

COPY . .
RUN composer dump-autoload --optimize --no-dev --classmap-authoritative

# ==========================================
# STAGE 3: Final Production Runner Image
# ==========================================
FROM php:8.2-fpm-alpine AS runner

# Install system dependencies & Nginx & Supervisor & PHP Extensions
RUN apk add --no-cache \
    nginx \
    supervisor \
    curl \
    libpng-dev \
    libzip-dev \
    zip \
    unzip \
    oniguruma-dev \
    freetype-dev \
    libjpeg-turbo-dev \
    busybox-suid \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j$(nproc) \
        pdo_mysql \
        mbstring \
        opcache \
        bcmath \
        zip \
        gd \
        pcntl \
    && apk add --no-cache --virtual .build-deps $PHPIZE_DEPS \
    && pecl install redis \
    && docker-php-ext-enable redis \
    && apk del .build-deps \
    && rm -rf /tmp/pear /var/cache/apk/*

WORKDIR /var/www/html

# Copy Configuration files
COPY docker/nginx/default.conf /etc/nginx/http.d/default.conf
COPY docker/php/local.ini /usr/local/etc/php/conf.d/local.ini
COPY docker/php/opcache.ini /usr/local/etc/php/conf.d/opcache.ini
COPY docker/supervisord.conf /etc/supervisord.conf
COPY docker/entrypoint.sh /usr/local/bin/entrypoint.sh

RUN sed -i 's/\r$//' /usr/local/bin/entrypoint.sh && chmod +x /usr/local/bin/entrypoint.sh

# Copy Application Source from Composer Builder
COPY --from=composer-builder /app /var/www/html

# Copy Compiled Frontend Assets from Node Builder
COPY --from=frontend-builder /app/public/build /var/www/html/public/build

# Set Ownership & Permissions
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache

EXPOSE 80

ENTRYPOINT ["/usr/local/bin/entrypoint.sh"]
CMD ["/usr/bin/supervisord", "-c", "/etc/supervisord.conf"]
