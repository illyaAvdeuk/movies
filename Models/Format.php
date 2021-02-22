<?php
namespace Models;

use Exception;
use PDO;

/**
 * Class Format
 * @package Models
 */
class Format extends BaseModel
{
    public function addFormat($formatTitle, $movie_ids = [])
    {
        /** adding standard */
        $sql = "INSERT INTO standards (title) VALUES (?)";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([$formatTitle]);
        $formatID = $this->pdo->lastInsertId();

        $this->addMoviesToFormat($movie_ids, $formatID);
    }

    /**
     * @param string $title
     * @return bool
     */
    public function formatExists(string $title) : bool
    {
        $sql = 'SELECT id FROM standards WHERE title = :title';

        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':title', $title);
        $stmt->execute();

        if(is_array($format = $stmt->fetch(PDO::FETCH_ASSOC))){
            return $format['id'];
        }
        return false;
    }

    /** if standard has movies - connect them by standards_movies table
     *
     * @param array $movie_ids
     * @param int $formatId
     */
    public function addMoviesToFormat(array $movie_ids, int $formatId)
    {
        if (!empty($movie_ids)) {
            foreach ($movie_ids as $movie_id) {
                $sql = "INSERT INTO movies_standards (movie_id, standard_id) VALUES (?, ?)";
                $stmt = $this->pdo->prepare($sql);
                $stmt->execute([$movie_id, $formatId]);
            }
        }
    }
}