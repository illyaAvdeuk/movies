<?php
namespace Controllers;

use ErrorException;
use System\View;

/**
 * Class homeController
 * @package Controllers
 */
class homeController
{
    /**
     * @throws ErrorException
     */
    public function actionMain()
    {
        // Рендер главной страницы портала

        View::render('index');
    }
}