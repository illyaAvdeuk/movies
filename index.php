<?php
declare(strict_types=1);

use System\App;

require_once __DIR__ . '/System/autoload.php';
require_once __DIR__ . '/System/config.php';
require_once __DIR__ . '/vendor/autoload.php';

define('ROOT_DIR', __DIR__);

try {
    App::run();
} catch (ErrorException $e) {
    header("HTTP/1.0 404 Not Found");
    echo 'Выброшено исключение: ',  $e->getMessage(), "\n";
}