# ============================================================
# Stage 1: Build frontend assets (Vite)
# ============================================================
FROM node:24-alpine AS build-assets

WORKDIR /app

COPY package.json package-lock.json ./
RUN npm install

COPY . .
RUN npm run build


# ============================================================
# Stage 2: PHP + ffmpeg + node + yt-dlp
# ============================================================
FROM php:8.2-fpm-alpine

# Install system dependencies
RUN apk add --no-cache \
    git \
    wget \
    curl \
    bash \
    make \
    libc-dev \
    libxml2-dev \
    build-base \
    linux-headers \
    ffmpeg \
    python3 \
    py3-pip \
    nodejs \
    npm \
    caddy

# Install PHP extensions
RUN docker-php-ext-install pdo_mysql opcache bcmath

# Install Composer
RUN wget https://getcomposer.org/installer -O composer-setup.php \
    && php composer-setup.php --install-dir=/usr/local/bin --filename=composer \
    && rm composer-setup.php

# Install yt-dlp (from Alpine package repo)
RUN apk add --no-cache yt-dlp

# Ensure php-fpm can access storage
WORKDIR /var/www/html
COPY . .

# Create required directories
RUN mkdir -p storage/app/temp storage/app/output \
    && chown -R www-data:www-data storage \
    && chmod -R 775 storage

# Copy built assets
COPY --from=build-assets /app/public/build /var/www/html/public/build
COPY --from=build-assets /app/node_modules /var/www/html/node_modules

# PHP execution time settings
RUN echo "max_execution_time = 300" > /usr/local/etc/php/conf.d/zz-max-exec-time.ini

# Install PHP dependencies
RUN composer install --no-dev --optimize-autoloader

# Additional permissions
RUN chown -R www-data:www-data bootstrap/cache \
    && chmod -R 775 bootstrap/cache

# Caddy config
COPY Caddyfile /etc/caddy/Caddyfile

# Runtime-writable SQLite DB
RUN touch /tmp/laravel.sqlite && chmod 666 /tmp/laravel.sqlite

EXPOSE 8080
CMD ["sh", "-c", "php-fpm & caddy run --config /etc/caddy/Caddyfile"]
