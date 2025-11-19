# --- Stage 1: Build Assets (Vite & NPM) ---
FROM node:24-alpine AS build-assets

# Set working directory for the asset build stage
WORKDIR /app

# Install dependencies for Node.js/NPM
COPY package.json package-lock.json ./
RUN npm install

# Copy all project files
COPY . .

# Build the frontend assets using Vite
# Ensure your package.json has a "build" script that calls vite build
RUN npm run build

# --- Stage 2: Production PHP/FPM Server ---
# Use a lightweight PHP FPM image that includes necessary extensions (e.g., GD, MySQLi/PDO)
FROM php:8.2-fpm-alpine

# Install essential system dependencies and PHP extensions
# We install git, common, and composer
RUN apk add --no-cache \
    git \
    wget \
    make \
    curl \
    libc-dev \
    libxml2-dev \
    build-base \
    linux-headers \
    php82-sockets \
    $([ $(apk search --purge -s pcre-dev | grep -q 'pcre' ; echo $?) -eq 0 ] && echo 'pcre-dev') \
    $([ $(apk search --purge -s zlib-dev | grep -q 'zlib' ; echo $?) -eq 0 ] && echo 'zlib-dev') \
    && docker-php-ext-install \
    pdo_mysql \
    opcache \
    bcmath \
    # REMOVED: sockets (now installed via apk add php82-sockets)
    && wget https://getcomposer.org/installer -O composer-setup.php \
    && php composer-setup.php --install-dir=/usr/local/bin --filename=composer \
    && rm composer-setup.php

RUN apk add --no-cache curl git caddy \
    && docker-php-ext-install pdo_mysql opcache bcmath

# Install additional tools + ffmpeg + python
RUN apk add --no-cache \
    ffmpeg \
    python3 \
    py3-pip

# Install yt-dlp (static Linux binary)
RUN curl -L https://github.com/yt-dlp/yt-dlp/releases/latest/download/yt-dlp \
    -o /usr/local/bin/yt-dlp && \
    chmod +x /usr/local/bin/yt-dlp

# Install Node.js (needed by yt-dlp for YouTube JS decryption)
RUN apk add --no-cache nodejs npm

# Symlink to node in /usr/local/bin for yt-dlp
RUN ln -s /usr/bin/node /usr/local/bin/node
RUN ln -s /usr/bin/npm /usr/local/bin/npm

# Set working directory for the application
WORKDIR /var/www/html

# Copy the rest of the application files
COPY . .

# Create necesarry temp and output folders
RUN mkdir -p /var/www/html/storage/app/temp \
    && mkdir -p /var/www/html/storage/app/output \
    && chown -R www-data:www-data /var/www/html/storage \
    && chmod -R 775 /var/www/html/storage

# Copy the built assets from the first stage
COPY --from=build-assets /app/public/build /var/www/html/public/build
COPY --from=build-assets /app/node_modules /var/www/html/node_modules

# --- Configure PHP ---
# Set the maximum execution time to 5 minutes (300 seconds)
# This is the key setting you requested.
RUN echo "max_execution_time = 300" > /usr/local/etc/php/conf.d/zz-max-exec-time.ini

# Install PHP dependencies
RUN composer install --no-dev --optimize-autoloader

# Set appropriate permissions (important for caching and storage)
RUN chown -R www-data:www-data /var/www/html/storage \
    && chown -R www-data:www-data /var/www/html/bootstrap/cache \
    && chmod -R 775 /var/www/html/storage \
    && chmod -R 775 /var/www/html/bootstrap/cache
    
RUN chmod -R 775 database && chown -R www-data:www-data database

# Caddy config
COPY Caddyfile /etc/caddy/Caddyfile

EXPOSE 8080
CMD ["sh", "-c", "php-fpm & caddy run --config /etc/caddy/Caddyfile"]