<?php
namespace Controllers;

use ErrorException;
use Models\Install;
use System\View;

/**
 * Class installController
 * @package Controllers
 */
class installController extends BaseController
{
    /**
     * installController constructor.
     */
    public function __construct()
    {
        $this->model =  new Install();
    }

    /**
     * action to create mysql tables
     *
     * @throws ErrorException
     */
    public function actionStart()
    {
        $result = $this->model->createTables();
        if ($result) {
            View::render('error', ['message' => $result]);
        }
        $this->redirect301('/home/main');
    }
}