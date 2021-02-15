<?php
namespace Controllers;

use ErrorException;
use System\View;

/**
 * Class moviesController
 * @package Controllers
 */
class moviesController
{
    /**
     * @throws ErrorException
     */
    public function actionList()
    {
        View::render('movies');
    }
}