<?php
namespace Models;

use Exception;
use PDO;

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
        try {
            $this->pdo->beginTransaction();

            $sql = "INSERT INTO movies (title, release_date) VALUES (?, ?)";
            $stmt = $this->pdo->prepare($sql);
            $stmt->execute([$data['title'], $data['release_date']]);
            $movieId = $this->pdo->lastInsertId();

            if (isset($data['actors']) && !empty($data['actors'])) {
                $actorsList = explode(',', $data['actors']);

                foreach ($actorsList as $actor) {
                    $actorN = new Actors();
                    $actorN->addActor($actor, $movieId);
                }



//                $actors = new Actors();
//                if (is_string($error = $actors->addActors($actorsList, $movieId))){
//                    return $error;
//                }

            }

//            if (isset($data['format'])) {
//                $format = new Format();
//                if (!$format->formatExists($data['format'])) {
//                    $format->addFormat($data['format'], [$movieId]);
//                }
//            }

            $this->pdo->commit();

        } catch(Exception $e) {
            $this->pdo->rollBack();
            return $e->getMessage();
        }
        return true;
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
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * get single movie
     *
     * @param int $id
     * @return array
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

        return $stmt->fetch(PDO::FETCH_ASSOC);
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
        $stmt->bindParam(':title', $title, PDO::PARAM_STR);
        $stmt->bindParam(':release_date', $release_date);
        $stmt->execute();

        if(is_array($stmt->fetch(PDO::FETCH_ASSOC))){
            return true;
        }
        return false;
    }
}