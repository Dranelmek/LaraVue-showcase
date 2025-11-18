# 1. Start PHP-FPM in the background
/usr/sbin/php-fpm -D

# 2. Update the Nginx configuration to listen on the dynamic $PORT
#    (Assuming your Nginx config has a placeholder like 80 or $PORT)
sed -i "s|80|$PORT|g" /etc/nginx/sites-available/default

# 3. Start Nginx in the foreground. This process MUST stay alive.
/usr/sbin/nginx -g 'daemon off;'