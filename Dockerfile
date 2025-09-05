# Base stage with common dependencies
FROM php:7.1-fpm as base
# Fix apt sources for Debian Buster (archived)
RUN sed -i 's|deb.debian.org|archive.debian.org|g' /etc/apt/sources.list \
    && sed -i 's|security.debian.org|archive.debian.org|g' /etc/apt/sources.list \
    && sed -i '/buster-updates/d' /etc/apt/sources.list \
    && apt-get update
# Install system dependencies
RUN apt-get install -y \
    libpng-dev libjpeg-dev libzip-dev unzip curl \
    && docker-php-ext-configure gd --with-jpeg-dir=/usr/include/ \
    && docker-php-ext-install pdo pdo_mysql mysqli gd zip \
    && pecl install redis-3.1.6 && docker-php-ext-enable redis
# Install Caddy
RUN curl -fsSL https://github.com/caddyserver/caddy/releases/download/v2.7.6/caddy_2.7.6_linux_amd64.tar.gz \
  | tar -xz -C /usr/bin caddy && chmod +x /usr/bin/caddy
# Tune PHP-FPM pool settings
RUN sed -i 's/^pm.max_children = .*/pm.max_children = 20/' /usr/local/etc/php-fpm.d/www.conf && \
    sed -i 's/^pm.start_servers = .*/pm.start_servers = 5/' /usr/local/etc/php-fpm.d/www.conf && \
    sed -i 's/^pm.min_spare_servers = .*/pm.min_spare_servers = 3/' /usr/local/etc/php-fpm.d/www.conf && \
    sed -i 's/^pm.max_spare_servers = .*/pm.max_spare_servers = 10/' /usr/local/etc/php-fpm.d/www.conf
# Set working directory (but don't copy files - they'll be mounted)
WORKDIR /var/www/html
# Copy entrypoint script
COPY infra/entrypoint.sh /entrypoint.sh
RUN chmod +x /entrypoint.sh
EXPOSE 80

# Development stage
FROM base as dev
# Install xdebug for development
RUN pecl install xdebug-2.9.8 && docker-php-ext-enable xdebug
COPY infra/xdebug/xdebug.ini /usr/local/etc/php/conf.d/xdebug.ini
COPY infra/caddy/Caddyfile.dev /etc/caddy/Caddyfile
ENTRYPOINT ["/entrypoint.sh"]

# Production stage
FROM base as prod
# Production optimizations (no xdebug)
RUN echo "opcache.enable=1" >> /usr/local/etc/php/conf.d/opcache.ini && \
    echo "opcache.memory_consumption=128" >> /usr/local/etc/php/conf.d/opcache.ini && \
    echo "opcache.max_accelerated_files=10000" >> /usr/local/etc/php/conf.d/opcache.ini
# Copy production Caddyfile
COPY infra/caddy/Caddyfile.prod /etc/caddy/Caddyfile
ENTRYPOINT ["/entrypoint.sh"]