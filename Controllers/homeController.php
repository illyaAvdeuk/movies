<?php
namespace Controllers;

use ErrorException;
use Models\Movies;
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

    public function actionMovies()
    {
        // Создаем модель
        $model = new Movies();

        // Получаем данные используя модель
        $data = $model->showMovies();

        // Передаем данные представлению для их отображения
        View::render('movies', [
            'data' => $data,
        ]);
    }
}