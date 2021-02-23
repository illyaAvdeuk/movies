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

    /**
     * method for ajax responses
     *
     * @param string $status
     * @param $response
     * @return bool
     */
    public function setJSON(string $status, $response)
    {
        switch ($status) {
            case 'success':
                echo json_encode(['success' => true]);
                return true;
                break;
            case 'error':
            default:
                echo json_encode(['error' => $response]);
                return true;
                break;
        }
    }
}