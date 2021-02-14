<?php
namespace Controllers;

use Models\Install;

/**
 * Class installController
 * @package Controllers
 */
class installController
{

    public function actionStart()
    {
        $installation = new Install();
        $installation->createTables();
    }
}