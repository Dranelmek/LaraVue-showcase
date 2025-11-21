#!/bin/sh

# If Render mounted a cookies secret, copy it where www-data can read it
if [ -f /etc/secrets/cookies.txt ]; then
    cp /etc/secrets/cookies.txt /var/www/html/storage/cookies/cookies.txt
    chmod 644 /var/www/html/storage/cookies/cookies.txt
fi

php-fpm &
caddy run --config /etc/caddy/Caddyfile
