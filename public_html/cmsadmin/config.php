<?php
// HTTP - Use environment variable for flexible URLs
define('HTTP_SERVER', getenv('OPENCART_ADMIN_URL') ?: 'http://localhost/cmsadmin/');
define('HTTP_CATALOG', getenv('OPENCART_URL') ?: 'http://localhost/');

// HTTPS - Same as HTTP for your setup
define('HTTPS_SERVER', getenv('OPENCART_ADMIN_URL') ?: 'http://localhost/cmsadmin/');
define('HTTPS_CATALOG', getenv('OPENCART_URL') ?: 'http://localhost/');

$root = realpath(__DIR__ . '/..');

// DIR - Update paths for standard OpenCart structure
define('DIR_APPLICATION', $root . '/admin/');
define('DIR_SYSTEM', $root . '/system/');
define('DIR_IMAGE', $root . '/image/');
define('DIR_LANGUAGE', $root . '/admin/language/');
define('DIR_TEMPLATE', $root . '/admin/view/template/');
define('DIR_CONFIG', $root . '/system/config/');
define('DIR_CACHE', $root . '/system/storage/cache/');
define('DIR_DOWNLOAD', $root . '/system/storage/download/');
define('DIR_LOGS', $root . '/system/storage/logs/');
define('DIR_MODIFICATION', $root . '/system/storage/modification/');
define('DIR_UPLOAD', $root . '/system/storage/upload/');
define('DIR_CATALOG', $root . '/catalog/');

// DB - Use Docker environment variables
define('DB_DRIVER', 'mysqli');
define('DB_HOSTNAME', getenv('DB_HOST') ?: 'mariadb');
define('DB_USERNAME', getenv('DB_USERNAME') ?: 'opencart');
define('DB_PASSWORD', getenv('DB_PASSWORD') ?: 'password');
define('DB_DATABASE', getenv('DB_DATABASE') ?: 'opencart');
define('DB_PORT', '3306');
define('DB_PREFIX', '1c0p_');  // Keep your existing prefix

// REDIS CACHE - Use Docker Redis container
define('CACHE_HOSTNAME', getenv('REDIS_HOST') ?: 'redis');
define('CACHE_PORT', getenv('REDIS_PORT') ?: '6379');
define('CACHE_PREFIX', 'peir_');  // Keep your existing prefix
define('CACHE_PASSWORD', getenv('REDIS_PASSWORD') ?: '');

?>
