<?php
namespace Controllers;

use ErrorException;
use Models\ImportHelper;
use Models\Movies;
use PhpOffice\PhpWord\Exception\Exception;
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

    /**
     * action for movies ajax delete
     */
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
     * vies for adding single movies
     *
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
            if ($this->model->movieExists($_POST['title'], $_POST['release_date'])) {
                $this->setJSON('error', sprintf('%s already exists in database for year %s', $_POST['title'], $_POST['release_date']));
            }

            if (is_string($error = $this->model->addMovie($_POST))) {
                $this->setJSON('error', $error);
            } else {
                $this->setJSON('success', true);
            }
        }
    }

    /**
     * show view for uploads page
     *
     * @throws ErrorException
     */
    public function actionUpload()
    {
        View::render('uploads');
    }

    /**
     * import movies from file
     *
     * @throws Exception
     */
    public function actionImport()
    {
        if (!isset($_FILES['file'])) {
            $this->setJSON('error', 'Add file first');
        }

        if ( 0 < $_FILES['file']['error'] ) {
            $this->setJSON('error', $_FILES['file']['error']);
        } else {
            $path = ROOT_DIR.'/temp/' . $_FILES['file']['name'];
            move_uploaded_file($_FILES['file']['tmp_name'], $path);

            $importHelper = new ImportHelper();
            $parsedMovies = $importHelper->parse($path);

            if (!empty($parsedMovies)) {
                if (is_string($error = $this->model->addMovies($parsedMovies))) {
                    $this->setJSON('error', $error);
                } else {
                    $this->setJSON('success', true);
                }
            }
            unlink($path);
        }
    }

}