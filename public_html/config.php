<?php
// HTTP - Use environment variable (no hardcoded domain)
define('HTTP_SERVER', getenv('OPENCART_URL') ?: 'http://localhost/');

// HTTPS - Same as HTTP for your setup
define('HTTPS_SERVER', getenv('OPENCART_URL') ?: 'http://localhost/');

// DIR - These stay the same (internal paths)
define('DIR_APPLICATION', __DIR__ . '/catalog/');
define('DIR_SYSTEM', __DIR__ . '/system/');
define('DIR_IMAGE', __DIR__ . '/image/');
define('DIR_LANGUAGE', __DIR__ . '/catalog/language/');
define('DIR_TEMPLATE', __DIR__ . '/catalog/view/theme/');
define('DIR_CONFIG', __DIR__ . '/system/config/');
define('DIR_CACHE', __DIR__ . '/system/storage/cache/');
define('DIR_DOWNLOAD', __DIR__ . '/system/storage/download/');
define('DIR_LOGS', __DIR__ . '/system/storage/logs/');
define('DIR_MODIFICATION', __DIR__ . '/system/storage/modification/');
define('DIR_UPLOAD', __DIR__ . '/system/storage/upload/');

// DB - Use Docker environment variables
define('DB_DRIVER', 'mysqli');
define('DB_HOSTNAME', getenv('DB_HOST') ?: 'mariadb');
define('DB_USERNAME', getenv('DB_USERNAME') ?: 'opencart');
define('DB_PASSWORD', getenv('DB_PASSWORD') ?: 'password');
define('DB_DATABASE', getenv('DB_DATABASE') ?: 'opencart');
define('DB_PORT', '3306');
define('DB_PREFIX', '1c0p_');

// CDN - Use environment variable (defaults to same as main URL)
define('CDN_HTTPS_SERVER', getenv('OPENCART_CDN_URL') ?: getenv('OPENCART_URL') ?: 'http://localhost/');

// REDIS CACHE - Use Docker Redis container
define('CACHE_HOSTNAME', getenv('REDIS_HOST') ?: 'redis');
define('CACHE_PORT', getenv('REDIS_PORT') ?: '6379');
define('CACHE_PREFIX', 'peir_');  // Keep your existing prefix
define('CACHE_PASSWORD', getenv('REDIS_PASSWORD') ?: '');

// Debugger - Use environment variable for easy toggle
if (getenv('APP_DEBUG') === 'true') {
    define('IS_DEBUG', true);
}
?>