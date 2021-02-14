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
        $sql = "SELECT * FROM {$this->table}";
        return $this->pdo->query($sql)->fetchAll(PDO::FETCH_ASSOC);
    }
}