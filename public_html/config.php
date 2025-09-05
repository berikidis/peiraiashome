<?php
// HTTP
define('HTTP_SERVER', 'http://localhost/');

// HTTPS
define('HTTPS_SERVER', 'http://localhost/');

// DIR
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

// DB
define('DB_DRIVER', 'mysqli');
define('DB_HOSTNAME', 'localhost');
define('DB_USERNAME', 'lefkaeid_db2');
define('DB_PASSWORD', 'gt,ZnzvQxK+K');
define('DB_DATABASE', 'lefkaeid_db2');
define('DB_PORT', '3306');
define('DB_PREFIX', '1c0p_');

// CDN
define('CDN_HTTPS_SERVER', 'https://cdn.peiraiashome.gr/');

// REDIS CACHE
define('CACHE_HOSTNAME', '127.0.0.1');
define('CACHE_PORT', '6379');
define('CACHE_PREFIX', 'peir_');
define('CACHE_PASSWORD', '');

// Debugger
// define('IS_DEBUG', true);