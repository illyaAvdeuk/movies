<?php
namespace Models;

use Exception;
use PDO;

/**
 * Class Actors
 * @package Models
 */
class Actors extends BaseModel
{
    /**
     * @param string $fullName
     * @param int $movieId
     * @return string
     */
    public function addActor(string $fullName, int $movieId)
    {
        /** adding actor */
        $sql = "INSERT INTO actors (fullName) VALUES (?)";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$fullName]);
        $actorId = $this->pdo->lastInsertId();
//        $this->addMovieToActor($movieId, $actorId);
        $sql2 = "INSERT INTO actors_movies (movie_id, actor_id) VALUES (?, ?)";
        $stmt2 = $this->pdo->prepare($sql2)->execute([$movieId, $actorId]);
//        $stmt2;

    }

    /**
     * @param array $actors
     * @param int $movieId
     * @return string
     */
    public function addActors(array $actors, int $movieId)
    {


        if (!empty($actors)) {

            foreach ($actors as $actor) {

//                if ($this->actorExists($actor)) {
//                    continue;
//                }
                if (is_string($error = $this->addActor($actor, $movieId))) {
                    return $error;
                }
            }
        }
    }

    /**
     * @param string $fullName
     * @return bool
     */
    private function actorExists(string $fullName) : bool
    {
        $sql = 'SELECT id FROM actors WHERE fullName = :fullName';

        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':fullName', $fullName);
        $stmt->execute();

        if($stmt->fetch(PDO::FETCH_ASSOC)){
            return true;
        }
        return false;
    }
    /**
     * @param int $movieId
     * @param int $actorId
     * @return string
     */
    public function addMovieToActor(int $movieId, int $actorId)
    {
        $sql = "INSERT INTO actors_movies (movie_id, actor_id) VALUES (?, ?)";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$movieId, $actorId]);
    }

}