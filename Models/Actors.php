<?php
namespace Models;

/**
 * Class Actors
 * @package Models
 */
class Actors extends BaseModel
{
    /**
     * @param string $fullName
     * @param $movieId
     * @return string
     */
    public function addActor(string $fullName, int $movieId)
    {
        /** adding actor */
        $sql = "INSERT INTO actors (fullName) VALUES (?)";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$fullName]);
        $actorId = (int)$this->pdo->lastInsertId();
        /** union movies with actor */
        if ($movieId) {
            $this->addMovieToActor($movieId, $actorId);
        }
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
                if ($actorId = $this->actorExists($actor)) {
                    $this->addMovieToActor($movieId, (int)$actorId);
                    continue;
                }
                $this->addActor($actor, $movieId);
            }
        }
    }

    /**
     * @param string $fullName
     * @return bool|string
     */
    private function actorExists(string $fullName)
    {
        $sql = 'SELECT id FROM actors WHERE fullName = :fullName';

        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':fullName', $fullName);
        $stmt->execute();

        if(is_array($actor = $stmt->fetch($this->pdo::FETCH_ASSOC))){
            return $actor['id'];
        }
        return false;
    }

    /**
     * @param int $movieId
     * @param int $actorId
     */
    public function addMovieToActor(int $movieId, int $actorId)
    {
        $sql = "INSERT INTO actors_movies (movie_id, actor_id) VALUES (?, ?)";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$movieId, $actorId]);
    }

}