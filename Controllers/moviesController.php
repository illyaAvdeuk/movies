<?php
namespace Controllers;

use ErrorException;
use Models\Movies;
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
        $movies = new Movies();
        $films = $movies->showMovies();
        print_r($films);
        View::render('movies');
    }
}