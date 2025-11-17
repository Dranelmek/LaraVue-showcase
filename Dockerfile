# --- Stage 1: Build Frontend Assets (Node.js) ---
FROM node:20-alpine AS frontend-builder

# Set working directory
WORKDIR /app

# Copy package.json and install dependencies
COPY package.json package-lock.json ./
RUN npm install

# Copy application files (excluding those in .dockerignore)
COPY . .

# Build the frontend assets for production
RUN npm run build


# --- Stage 2: PHP Composer Dependencies (PHP CLI) ---
FROM php:8.2-cli AS composer

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Set working directory
WORKDIR /app

# Copy Composer files
COPY composer.json composer.lock ./

# Install PHP dependencies (production only)
RUN composer install --no-dev --prefer-dist --optimize-autoloader


# --- Stage 3: PHP-FPM Application Server ---
FROM php:8.2-fpm-alpine AS app

# Install PHP extensions and system dependencies
# Adjust these based on your specific Laravel requirements (e.g., gd, bcmath, redis, etc.)
RUN apk add --no-cache \
    nginx \
    supervisor \
    libzip-dev \
    libpng-dev \
    jpeg-dev \
    oniguruma-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j$(nproc) \
        pdo_mysql \
        zip \
        mbstring \
        exif \
        pcntl \
        gd

# ⏱️ Configure PHP Maximum Execution Time (5 minutes = 300 seconds)
# This creates a custom .ini file to override the default setting.
RUN echo "max_execution_time = 300" > /usr/local/etc/php/conf.d/docker-php-maxexectime.ini \
    && echo "upload_max_filesize = 100M" > /usr/local/etc/php/conf.d/docker-php-uploadsize.ini \
    && echo "post_max_size = 100M" >> /usr/local/etc/php/conf.d/docker-php-uploadsize.ini

# Set working directory
WORKDIR /var/www/html

# Copy the Laravel source code, excluding vendor
COPY . .

# Copy installed Composer dependencies and built assets from previous stages
COPY --from=composer /app/vendor /var/www/html/vendor
COPY --from=frontend-builder /app/public/build /var/www/html/public/build
COPY --from=frontend-builder /app/public/mix-manifest.json /var/www/html/public/mix-manifest.json
# Note: Adjust paths above if you're using Vite instead of Mix

# Copy Nginx config file
# You will need to create a `nginx.conf` file in your project root.
COPY nginx.conf /etc/nginx/nginx.conf

# Set permissions
RUN chown -R www-data:www-data /var/www/html/storage \
    && chown -R www-data:www-data /var/www/html/bootstrap/cache

# Expose the port for the web server
EXPOSE 80

# The CMD should be defined in a `supervisord.conf` file or an entrypoint script
# to run both php-fpm and nginx, as Render expects a single command.
# For simplicity, we'll use a single command here, but a dedicated entrypoint script
# is often better for a combined image.
CMD ["/bin/sh", "-c", "supervisord -c /etc/supervisor/conf.d/supervisord.conf"]