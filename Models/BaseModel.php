<?php
namespace Models;

use PDO;
use PDOException;

/**
 * Class BaseModel
 * @package Models
 */
class BaseModel
{
    protected PDO $pdo;

    /**
     * BaseModel constructor.
     */
    public function __construct()
    {
        try {
            $dsn = "mysql:host=".DBHOST.";dbname=".DBNAME.";";
            // Создаем экземпляр класса для работы с БД
            $this->pdo = new PDO($dsn, DBUSER, DBPWD);
        } catch(PDOException $e) {
            echo "Error: ".$e->getMessage();
        }
    }
}