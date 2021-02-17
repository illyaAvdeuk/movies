<?php
namespace Controllers;

use Models\BaseModel;

/**
 * Class BaseController
 * @package Controllers
 */
abstract class BaseController
{
    protected BaseModel $model;

    /**
     * @param string $url
     */
    protected function redirect301(string $url) {
        header("HTTP/1.1 301 Moved Permanently");
        header("Location: {$url}");
        exit();
    }
}