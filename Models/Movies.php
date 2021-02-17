<?php
namespace Models;

use PDO;

/**
 * Class Movies
 * @package Models
 */
class Movies extends BaseModel
{
    /**
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
}