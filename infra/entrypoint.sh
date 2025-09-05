#!/bin/bash
set -e

echo "🔧 Starting OpenCart container setup..."

# Function to create directory with proper permissions
create_dir() {
    local dir=$1
    echo "  📁 Creating directory: $dir"
    mkdir -p "$dir"
    chown -R www-data:www-data "$dir"
    chmod -R 775 "$dir"
}

# VQMod setup
echo "🔧 Setting up VQMod..."
create_dir "/var/www/html/vqmod"

# System storage & logs
echo "🔧 Setting up system storage..."
create_dir "/var/www/html/system/storage/logs"
create_dir "/var/www/html/system/cache"

# Ensure log file exists
touch /var/www/html/system/storage/logs/openbay.log
chown www-data:www-data /var/www/html/system/storage/logs/openbay.log

# Image directories
echo "🔧 Setting up image directories..."
create_dir "/var/www/html/image/cache"
create_dir "/var/www/html/image/catalog"

# Journal3 theme directories
echo "🔧 Setting up Journal3 theme..."
create_dir "/var/www/html/catalog/view/theme/journal3/assets"
create_dir "/var/www/html/catalog/view/theme/journal3/assets_minified"
create_dir "/var/www/html/catalog/view/theme/journal3/theme_cache"

echo "✅ Directory setup complete!"

# Wait for database to be ready (optional)
echo "🔄 Waiting for database connection..."
until php -r "new PDO('mysql:host=${DB_HOST:-mariadb};dbname=${DB_DATABASE:-opencart}', '${DB_USERNAME:-opencart}', '${DB_PASSWORD}');" 2>/dev/null; do
    echo "  ⏳ Database not ready, waiting 2 seconds..."
    sleep 2
done
echo "✅ Database connection established!"

echo "🚀 Starting PHP-FPM..."
php-fpm &

echo "🌐 Starting Caddy web server..."
exec caddy run --config /etc/caddy/Caddyfile --adapter caddyfile
