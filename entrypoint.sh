#!/bin/sh

echo "== DEBUG: Listing /etc/secrets =="
ls -l /etc/secrets

# Ensure storage/cookies directory exists first
mkdir -p /var/www/html/storage/cookies
chmod 755 /var/www/html/storage/cookies

COOKIES_TARGET="/var/www/html/storage/cookies/cookies.txt"

# Check for Render secret file
if [ -f /etc/secrets/cookies.txt ]; then
    echo "Found cookies.txt"
    cp /etc/secrets/cookies.txt "$COOKIES_TARGET"
elif [ -f /etc/secrets/cookies_txt ]; then
    echo "Found cookies_txt (Render renamed it)"
    cp /etc/secrets/cookies_txt "$COOKIES_TARGET"
else
    echo "No cookies file found in /etc/secrets"
fi

# Fix permissions ONLY if the file exists
if [ -f "$COOKIES_TARGET" ]; then
    echo "Setting correct permissions on cookies.txt"

    # Try chown to www-data, but fallback if user doesn't exist
    if id www-data >/dev/null 2>&1; then
        chown www-data:www-data "$COOKIES_TARGET"
    else
        echo "www-data user not found, leaving owner as-is"
    fi

    chmod 644 "$COOKIES_TARGET"
fi

# Run services
php-fpm &
caddy run --config /etc/caddy/Caddyfile
