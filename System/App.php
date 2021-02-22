<?php
namespace System;

use ErrorException;

/**
* Главный класс приложения
*
* @return void
*/
class App
{
    /**
     * Запуск приложения
    *
    * @throws ErrorException
     */
    public static function run()
    {
        /** get result of request */
        $path = $_SERVER['REQUEST_URI'];
        $url_components = parse_url($path);

        /** url components without $_GET params*/
        $pathParts = explode('/', $url_components['path']);

        $controller = $pathParts[1];
        $action = $pathParts[2];

        /** id for action **/
        $id = '';
        if (isset($pathParts[3])) {
            $id = $pathParts[3];
        }

        /** controller namespace */
        $controller = 'Controllers\\' . $controller . 'Controller';
        /** name for action method */
        $action = 'action' . ucfirst($action);

        // Если класса не существует, выбрасывем исключение
        if (!class_exists($controller)) {
            throw new ErrorException("Page {$path} does not exist");
        }

        // Создаем экземпляр класса контроллера
        $objController = new $controller;

        // Если действия у контроллера не существует, выбрасываем исключение
        if (!method_exists($objController, $action)) {
            throw new ErrorException('action does not exist');
        }

         // Вызываем действие контроллера
         $objController->$action($id);
    }
}

