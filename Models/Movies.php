<?php
namespace Models;

use PDO;

/**
 * Class Movies
 * @package Models
 */
class Movies extends BaseModel
{
    public function __construct()
    {
        parent::__construct();
        $this->table = 'movies';
    }

    /**
     * @return array
     */
    public function showMovies() : array
    {
        $sql = "SELECT movies.id, movies.title, movies.release_date, 
                actors.fullname AS actor, standards.title AS format
                FROM movies 
                LEFT JOIN standards on (movies.id=movies_standards.movie_id)
                LEFT JOIN actors on (movies.id=actors_movies.movie_id);";
        return $this->pdo->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    }
}