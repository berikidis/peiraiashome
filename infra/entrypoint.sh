#!/bin/bash
set -e

echo "🔧 Ensuring required directories and files exist..."

# VQMod setup
mkdir -p /var/www/html/vqmod
chown -R www-data:www-data /var/www/html/vqmod
chmod -R 775 /var/www/html/vqmod

# System storage & logs
mkdir -p /var/www/html/system/storage/logs
touch /var/www/html/system/storage/logs/openbay.log
chown -R www-data:www-data /var/www/html/system/storage
chmod -R 775 /var/www/html/system/storage

# Image cache/catalog folders
mkdir -p /var/www/html/image/cache
mkdir -p /var/www/html/image/catalog
chown -R www-data:www-data /var/www/html/image
chmod -R 775 /var/www/html/image

# Journal3 asset folders
mkdir -p /var/www/html/catalog/view/theme/journal3/assets
chown -R www-data:www-data /var/www/html/catalog/view/theme/journal3/assets
chmod -R 775 /var/www/html/catalog/view/theme/journal3/assets

# Optional: other Journal3 temp folders (uncomment if used)
mkdir -p /var/www/html/catalog/view/theme/journal3/assets_minified
mkdir -p /var/www/html/catalog/view/theme/journal3/theme_cache
chown -R www-data:www-data /var/www/html/catalog/view/theme/journal3/assets_minified
chown -R www-data:www-data /var/www/html/catalog/view/theme/journal3/theme_cache
chmod -R 775 /var/www/html/catalog/view/theme/journal3/assets_minified
chmod -R 775 /var/www/html/catalog/view/theme/journal3/theme_cache

mkdir -p /var/www/html/system/cache
chown -R www-data:www-data /var/www/html/system/cache
chmod -R 775 /var/www/html/system/cache

echo "🚀 Starting PHP-FPM..."
php-fpm &

echo "🌐 Starting Caddy..."
exec caddy run --config /etc/caddy/Caddyfile --adapter caddyfile
