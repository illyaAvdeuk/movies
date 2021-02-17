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

        // Получаем URL запроса
        $path = $_SERVER['REQUEST_URI'];
        // получаем path без $_GET параметров
        $url_components = parse_url($path);

        // Разбиваем URL на части
        $pathParts = explode('/', $url_components['path']);
        // Получаем имя контроллера
        $controller = $pathParts[1];
        // Получаем имя действия
        $action = $pathParts[2];
        // айди для action, если он нужен
        $id = $pathParts[3];

        // Формируем пространство имен для контроллера
        $controller = 'Controllers\\' . $controller . 'Controller';
        // Формируем наименование действия
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

