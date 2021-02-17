<?php
namespace Models;

use PDOException;

/**
 * Class Install
 * @package Models
 */
class Install extends BaseModel
{
    /**
     * create all tables for application
     *
     * @return string
     */
    public function createTables()
    {
        $sql = "
             CREATE TABLE IF NOT EXISTS movies(
             id INT( 11 ) AUTO_INCREMENT PRIMARY KEY,
             title VARCHAR( 200 ) NOT NULL,              
             release_date YEAR (4) NOT NULL);
             -- actors table
             CREATE TABLE IF NOT EXISTS actors(
             id INT( 11 ) AUTO_INCREMENT PRIMARY KEY,
             fullName VARCHAR( 200 ) NOT NULL);
             -- standards table
             CREATE TABLE IF NOT EXISTS standards(
                id INT( 11 ) AUTO_INCREMENT PRIMARY KEY,
                title VARCHAR( 30 ) NOT NULL);
             
             CREATE TABLE IF NOT EXISTS actors_movies(
                movie_id INT( 11 ) NOT NULL,
                actor_id INT( 11 ) NOT NULL,
                CONSTRAINT fk_movie_a 
                    FOREIGN KEY (movie_id)
                    REFERENCES movies(id)
                    ON DELETE CASCADE,
                CONSTRAINT fk_actor 
                    FOREIGN KEY (actor_id)
                    REFERENCES actors(id)
                    ON DELETE CASCADE                                  
             );
             
             CREATE TABLE IF NOT EXISTS movies_standards(
                movie_id INT( 11 ) NOT NULL,
                standard_id INT( 11 ) NOT NULL,
                CONSTRAINT fk_movie_s 
                    FOREIGN KEY (movie_id)
                    REFERENCES movies(id)
                    ON DELETE CASCADE,
                CONSTRAINT fk_standard 
                    FOREIGN KEY (standard_id)
                    REFERENCES standards(id)
                    ON DELETE CASCADE                                     
             );";

        try {
            $this->pdo->exec($sql);
        } catch(PDOException $e) {
            return $e->getMessage();
        }
    }
}