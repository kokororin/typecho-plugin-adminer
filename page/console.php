<?php
if (!defined('__TYPECHO_ROOT_DIR__')) {
    exit;
}

$db = Typecho_Db::get();
$dbConfig = $db->getConfig();
$dbConfig = $dbConfig[0];
$dbConfig = unserialize($dbConfig->__toString());

define('TYPECHO_ADMINER_STATIC_PREFIX', Helper::options()->pluginUrl . '/Adminer/adminer/static');
define('TYPECHO_ADMINER_HOST', $dbConfig['host']);
define('TYPECHO_ADMINER_USER', $dbConfig['user']);
define('TYPECHO_ADMINER_PWD', $dbConfig['password']);
define('TYPECHO_ADMINER_DB', $dbConfig['database']);

include __DIR__ . '/../adminer/index.php';
