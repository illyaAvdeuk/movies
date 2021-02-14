<?php
declare(strict_types=1);

use System\App;

require_once __DIR__ . '/System/autoload.php';
require_once __DIR__ . '/System/config.php';

try {
    App::run();
} catch (ErrorException $e) {
    header("HTTP/1.0 404 Not Found");
    echo 'Выброшено исключение: ',  $e->getMessage(), "\n";
}