<?php

namespace BluffingoUpdaterSite;

use Site\Database;
use Site\SiteException;

if (version_compare(PHP_VERSION, '8.2.0') <= 0) {
    die('<strong>The server is not compatible with your PHP version. This supports PHP 8.2 or newer.</strong>');
}

if (!file_exists(SB_VENDOR_PATH . '/autoload.php')) {
    die('<strong>You are missing the required Composer packages. Please read the installing instructions in the README file.</strong>');
}

if (!file_exists(SB_PRIVATE_PATH . '/conf/config.php')) {
    die('<strong>The configuration file could not be found. Please read the installing instructions in the README file.</strong>');
}

require_once(SB_PRIVATE_PATH . '/conf/config.php');

require_once(SB_VENDOR_PATH . '/autoload.php');

global $host, $user, $pass, $db;

spl_autoload_register(function ($class_name) {
    $class_name = str_replace('\\', '/', $class_name);
    if (file_exists(SB_PRIVATE_PATH . "/class/$class_name.php")) {
        require SB_PRIVATE_PATH . "/class/$class_name.php";
    }
});

try {
    $database = new Database($host, $user, $pass, $db);
} catch (SiteException $e) {
    $e->page();
}