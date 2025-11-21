#!/bin/sh

echo "== DEBUG: Listing /etc/secrets =="
ls -l /etc/secrets

# Ensure cookies directory exists
mkdir -p /var/www/html/storage/cookies
chmod 777 /var/www/html/storage/cookies

# Ensure yt-dlp directories exist
mkdir -p /var/www/html/storage/app/temp
mkdir -p /var/www/html/storage/app/output

# Make everything writable by the runtime user
chmod -R 777 /var/www/html/storage/app/temp
chmod -R 777 /var/www/html/storage/app/output
chown -R www-data:www-data /var/www/html/storage

# Copy secret cookies file
if [ -f /etc/secrets/cookies.txt ]; then
    echo "Found cookies.txt"
    cp /etc/secrets/cookies.txt /var/www/html/storage/cookies/cookies.txt
elif [ -f /etc/secrets/cookies_txt ]; then
    echo "Found cookies_txt (Render renamed it)"
    cp /etc/secrets/cookies_txt /var/www/html/storage/cookies/cookies.txt
else
    echo "No cookies file found in /etc/secrets"
fi

php-fpm &
caddy run --config /etc/caddy/Caddyfile
