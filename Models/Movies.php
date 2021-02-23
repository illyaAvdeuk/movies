<?php
namespace Models;

use Validators\AddMovieValidator;

/**
 * Class Movies
 * @package Models
 */
class Movies extends BaseModel
{
    /**
     * @param $data
     * @return bool|string
     */
    public function addMovie($data)
    {
        $sql = "INSERT INTO movies (title, release_date) VALUES (?, ?)";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$data['title'], $data['release_date']]);
        $movieId = (int)$this->pdo->lastInsertId();

        if (isset($data['actors']) && !empty($data['actors'])) {
            $actorsList = explode(',', $data['actors']);
            $actors = new Actors();
            if (is_string($error = $actors->addActors($actorsList, $movieId))) {
                return $error;
            }
        }

        if (isset($data['format'])) {
            $format = new Format();
            if (is_string($formatId = $format->formatExists($data['format']))) {
                $format->addMoviesToFormat([$movieId],$formatId);
            } else {
                $format->addFormat($data['format'], [$movieId]);
            }
        }
        return true;
    }

    /**
     * @param array $movies
     * @return bool|string
     */
    public function addMovies(array $movies)
    {
        $validator = new AddMovieValidator();
        if (!empty($movies)) {
            foreach($movies as $movie) {
                if (is_string($error = $validator->validate($movie))) {
                    return $error;
                }
                $this->addMovie($movie);
            }
        }
    }

    /**
     * @param array $params
     * @return array
     */
    public function getMovies($params = []) : array
    {
        $where = '';
        if (isset($params['search']) && !empty($params['search'])) {
            $where = " WHERE m.title LIKE '%{$params['search']}%' OR a.fullName LIKE '%{$params['search']}%'";
        }

        $sql = "SELECT DISTINCT m.id, m.title, m.release_date, GROUP_CONCAT(a.fullName) as actors, s.title as format
                FROM movies m
                         LEFT JOIN movies_standards ms on (m.id = ms.movie_id)
                         LEFT JOIN standards s on (ms.standard_id = s.id)
                         LEFT JOIN actors_movies am on (m.id = am.movie_id)
                         LEFT JOIN actors a on am.actor_id = a.id
                         {$where}
                GROUP BY s.title, m.id";

        if (isset($params['order_by']) && $params['order_by'] === 'title') {
            $sql .= " ORDER BY m.title {$params['sort']}";
        }

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll($this->pdo::FETCH_ASSOC);
    }

    /**
     * get single movie
     *
     * @param int $id
     * @return array|boolean
     */
    public function getMovie(int $id)
    {
        $sql = "SELECT DISTINCT m.id, m.title, m.release_date, GROUP_CONCAT(a.fullName) as actors, s.title as format
                FROM movies m
                         LEFT JOIN movies_standards ms on (m.id = ms.movie_id)
                         LEFT JOIN standards s on (ms.standard_id = s.id)
                         LEFT JOIN actors_movies am on (m.id = am.movie_id)
                         LEFT JOIN actors a on am.actor_id = a.id
                WHERE m.id = :id
                GROUP BY s.title, m.id LIMIT 1;";

        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->execute();

        $result = $stmt->fetch($this->pdo::FETCH_ASSOC);

        if (is_array($result)) {
            return $result;
        }
        return false;
    }

    /**
     * delete movie
     *
     * @param int $id
     * @return bool
     */
    public function deleteMovie(int $id) : bool
    {
        $stmt = $this->pdo->prepare( "DELETE FROM movies WHERE id =:id" );
        $stmt->bindParam(':id', $id);
        $stmt->execute();

        if (!$stmt->rowCount()) {
            return false;
        }
        return true;
    }

    /**
     * @param string $title
     * @param $release_date
     * @return bool
     */
    public function movieExists(string $title, $release_date) : bool
    {
        $sql = 'SELECT id FROM movies WHERE title = :title AND release_date = :release_date';

        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':title', $title, $this->pdo::PARAM_STR);
        $stmt->bindParam(':release_date', $release_date);
        $stmt->execute();

        if(is_array($stmt->fetch($this->pdo::FETCH_ASSOC))){
            return true;
        }
        return false;
    }
}