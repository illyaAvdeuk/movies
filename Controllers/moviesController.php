<?php
namespace Controllers;

use ErrorException;
use Models\DocxConverter;
use Models\Movies;
use PhpOffice\PhpWord\IOFactory;
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

    /**
     * show view for uploads page
     * @throws ErrorException
     */
    public function actionUpload()
    {
        $source = "/home/developer/Test/Controllers/tz.docx";

        $objReader = IOFactory::createReader('Word2007');

        $phpWord = $objReader->load($source);

        $arrays = [];
        $data = [];
        foreach($phpWord->getSections() as $section) {
            $arrays = $section->getElements();
            $text = '';
            foreach ($arrays as $e) {
                if (get_class($e) === 'PhpOffice\PhpWord\Element\TextRun') {
                    foreach ($e->getElements() as $text) {
                        if (!empty($text->getText())) {
                            $data[] = $text->getText();
//                            $text .= $text->getText();
                        }
                    }
                }
            }

            $text = implode(' ',$data);
            $text = str_replace([' :',' ,','  '], [':',',',' '], $text);
            $text = str_replace(['Title', 'Release  Year', 'Format', 'Stars'], ['|Title', ':Release Year', ':Format', ':Stars'], $text);


            $data = array_filter(explode('|', $text));
            foreach ($data as &$string) {
                $string = array_filter(explode(':', $string));
            }

            $parsedMovies = [];
            foreach ($data as $movieOrder => $movie) {
                foreach ($movie as $index => $movieElement ) {
                    if ($movieElement === 'Title') {
                        $parsedMovies[$movieOrder]['title'] = htmlspecialchars_decode((trim($movie[$index+1])), ENT_QUOTES);
                        unset($movie[$index+1]);
                    } elseif ($movieElement === 'Release Year') {
                        $parsedMovies[$movieOrder]['release_date'] = trim($movie[$index+1]);
                        unset($movie[$index+1]);
                    } elseif ($movieElement === 'Format') {
                        $parsedMovies[$movieOrder]['format'] = trim($movie[$index+1]);
                        unset($movie[$index+1]);
                    } elseif ($movieElement === 'Stars') {
                        $parsedMovies[$movieOrder]['actors'] = strip_tags(str_replace([', ', '  '],[',', ' '],trim($movie[$index+1])));
                        unset($movie[$index+1]);
                    }
                }
            }

            if (!empty($parsedMovies)) {
                $movies = new Movies();
                $movies->addMovies($parsedMovies);
            }

        }
        View::render('uploads', ['text' => $parsedMovies]);
    }

}