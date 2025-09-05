<?php
// HTTP
define('HTTP_SERVER', 'http://localhost/cmsadmin/');
define('HTTP_CATALOG', 'http://localhost/');

// HTTPS
define('HTTPS_SERVER', 'http://localhost/cmsadmin/');
define('HTTPS_CATALOG', 'http://localhost/');

$root = realpath(__DIR__ . '/..');

// DIR
define('DIR_APPLICATION', $root . '/cmsadmin/');
define('DIR_SYSTEM', $root . '/system/');
define('DIR_IMAGE', $root . '/image/');
define('DIR_LANGUAGE', $root . '/cmsadmin/language/');
define('DIR_TEMPLATE', $root . '/cmsadmin/view/template/');
define('DIR_CONFIG', $root . '/system/config/');
define('DIR_CACHE', $root . '/system/storage/cache/');
define('DIR_DOWNLOAD', $root . '/system/storage/download/');
define('DIR_LOGS', $root . '/system/storage/logs/');
define('DIR_MODIFICATION', $root . '/system/storage/modification/');
define('DIR_UPLOAD', $root . '/system/storage/upload/');
define('DIR_CATALOG', $root . '/catalog/');

// DB
define('DB_DRIVER', 'mysqli');
define('DB_HOSTNAME', 'localhost');
define('DB_USERNAME', 'lefkaeid_db2');
define('DB_PASSWORD', 'gt,ZnzvQxK+K');
define('DB_DATABASE', 'lefkaeid_db2');
define('DB_PORT', '3306');
define('DB_PREFIX', '1c0p_');

// REDIS CACHE
define('CACHE_HOSTNAME', '127.0.0.1');
define('CACHE_PORT', '6379');
define('CACHE_PREFIX', 'peir_');
define('CACHE_PASSWORD', '');