<?php
// Based on Rollerozxa's router implementation in Principia-Web.
// https://github.com/principia-game/principia-web/blob/master/router.php
namespace BluffingoUpdaterSite;

define("SB_DYNAMIC_PATH", dirname(__DIR__) . '/dynamic');
define("SB_PRIVATE_PATH", dirname(__DIR__) . '/private');
define("SB_VENDOR_PATH", dirname(__DIR__) . '/vendor');
define("SB_GIT_PATH", dirname(__DIR__) . '/.git'); // ONLY FOR makeVersionString() IN Site CLASS.

// SB_PUBLIC_PATH is not needed because all the core functionality is in the private folder.

use Site\Utilities;

$uri = parse_url($_SERVER["REQUEST_URI"], PHP_URL_PATH);
$path = explode('/', $uri);

require_once SB_PRIVATE_PATH . '/class/common.php';
function rewritePHP(): void
{
    if (str_contains($_SERVER["REQUEST_URI"], '.php'))
        Utilities::redirectPerma('%s', str_replace('.php', '', $_SERVER["REQUEST_URI"]));
}

if (isset($path[1]) && $path[1] != '') {
    if ($path[1] == 'index') {
        require(SB_PRIVATE_PATH . '/pages/index.php');
    } elseif ($path[1] == 'api') {
        if (!isset($path[2])) {
            die("Invalid API.");
        } elseif ($path[2] == 'get_versions') {
            if (isset($path[3])) {
                require(SB_PRIVATE_PATH . '/pages/get_versions.php');
            } else {
                die("Missing date.");
            }
        } elseif ($path[2] == 'get_software') {
            require(SB_PRIVATE_PATH . '/pages/get_software.php');
        }
    } else {
        rewritePHP();
    }
} else {
    require(SB_PRIVATE_PATH . '/pages/index.php');
}