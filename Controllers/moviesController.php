<?php
namespace Controllers;

use ErrorException;
use Models\Movies;
use System\View;

/**
 * Class moviesController
 * @package Controllers
 */
class moviesController extends BaseController
{
    /**
     * moviesController constructor.
     */
    public function __construct()
    {
        $this->model = new Movies();
    }

    /**
     * List of all movies
     *
     * @throws ErrorException
     */
    public function actionList()
    {
        $params = [];
        if (isset($_GET['order_by']) && isset($_GET['sort'])&& !empty($_GET['order_by']) && !empty($_GET['sort'])) {
            $params = [
                'order_by' => $_GET['order_by'],
                'sort' => $_GET['sort'],
            ];
        }

        if (isset($_GET['search']) && !empty($_GET['search'])) {
            $params['search'] = $_GET['search'];
        }

        View::render('movies', $this->model->getMovies($params));
    }

    /**
     * @param int $id
     * @throws ErrorException
     */
    public function actionShow(int $id)
    {
        $movie = $this->model->getMovie($id);
        if ($movie) {
            View::render('movie', $movie);
        } else {
            View::render('404', ['message' => "Movie with id {$id} not found"]);
        }
    }

    /**
     * @param int $id
     * @throws ErrorException
     */
    public function actionDelete(int $id)
    {
        if ($this->model->deleteMovie($id)) {
            View::render('movies', $this->model->getMovies());
        }
        View::render('movies', ['message' => "An error occurred while deleting a movie with ID {$id}"]);
    }

    public function actionAdd()
    {

    }

}