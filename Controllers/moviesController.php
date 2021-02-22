<?php
namespace Controllers;

use ErrorException;
use Models\Movies;
use System\View;
use Validators\AddMovieValidator;

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

    public function actionDelete()
    {
        if (!isset($_POST['id'])) {
            $this->setJSON('error', 'ID not set');
        }

        if ($this->model->deleteMovie($_POST['id'])) {
            $this->setJSON('success', true);
        }
    }

    /**
     * @throws ErrorException
     */
    public function actionAdd()
    {
        View::render('add');
    }

    /**
     * save single movie
     */
    public function actionSave()
    {
        $validator = new AddMovieValidator();

        if (is_string($error = $validator->validate($_POST))) {
            $this->setJSON('error', $error);
        } else {
            if (is_string($error = $this->model->addMovie($_POST))) {
                $this->setJSON('error', $error);
            }
            else {
                $this->redirect301('/movies/list');
            }
        }
    }

}