#!/bin/sh

echo "== DEBUG: Listing /etc/secrets =="
ls -l /etc/secrets

# Ensure storage/cookies directory exists
mkdir -p /var/www/html/storage/cookies
chmod 777 /var/www/html/storage/cookies

# Copy the cookies file from Render secret
if [ -f /etc/secrets/cookies.txt ]; then
    echo "Found cookies.txt"
    cp /etc/secrets/cookies.txt /var/www/html/storage/cookies/cookies.txt
elif [ -f /etc/secrets/cookies_txt ]; then
    echo "Found cookies_txt (Render renamed it)"
    cp /etc/secrets/cookies_txt /var/www/html/storage/cookies/cookies.txt
else
    echo "No cookies file found in /etc/secrets"
fi

if [ -f /var/www/html/storage/cookies/cookies.txt ]; then
    echo "Setting permissions on cookies.txt"
    chmod 644 /var/www/html/storage/cookies/cookies.txt
    chown www-data:www-data /var/www/html/storage/cookies/cookies.txt 2>/dev/null || true
fi

# Run services
php-fpm &
caddy run --config /etc/caddy/Caddyfile
