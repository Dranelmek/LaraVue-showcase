#!/bin/sh

echo "== DEBUG: Listing /etc/secrets =="
ls -l /etc/secrets

# Ensure storage/cookies directory exists first
mkdir -p /var/www/html/storage/cookies
chmod 777 /var/www/html/storage/cookies

# Check for Render secret file
if [ -f /etc/secrets/cookies.txt ]; then
    echo "Found cookies.txt"
    cp /etc/secrets/cookies.txt /var/www/html/storage/cookies/cookies.txt
elif [ -f /etc/secrets/cookies_txt ]; then
    echo "Found cookies_txt (Render renamed it)"
    cp /etc/secrets/cookies_txt /var/www/html/storage/cookies/cookies.txt
else
    echo "No cookies file found in /etc/secrets"
fi

# Run services
php-fpm &
caddy run --config /etc/caddy/Caddyfile
