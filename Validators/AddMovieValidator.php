<?php
namespace Validators;

use Models\Movies;

/**
 * Class AddMovieValidator
 * @package Validators
 */
class AddMovieValidator extends Validator
{
    private Movies $model;

    /**
     * AddMovieValidator constructor.
     */
    public function __construct()
    {
        $this->model = new Movies();
    }

    /**
     * @param array $data
     * @return bool|string
     */
    public function validate(array $data)
    {
        if (!isset($data['title']) || empty($data['title'])) {
            return $this->isRequired('Title of film');
        }

        if (!isset($data['release_date']) || empty($data['release_date'])) {
            return $this->isRequired('Year');
        }

        if ($this->model->movieExists($data['title'], $data['release_date'])) {
            return sprintf('%s already exists in database for year %s', $data['title'], $data['release_date']);
        }

        if (isset($data['actors'])) {
            return $this->checkString($data['actors'], 'Actors list');
        }

        if (isset($data['format'])) {
            return $this->checkString($data['format'], 'Format');
        }
        return true;
    }
}