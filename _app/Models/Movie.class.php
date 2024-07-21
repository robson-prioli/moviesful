<?php

namespace Models;

use Config\Database;
use Conn;
use PDO;

class Movie
{
    private $conn;
    private $table_name = "movies";

    public $id;
    public $title;
    public $genre;
    public $release_year;
    public $director;
    public $created_at;

    public function __construct()
    {
        $database = new Conn();
        $this->conn = $database->getConnection();
    }

    public function getMovies($filter, $sort, $start, $pageMax)
    {
        $query = "SELECT * FROM " . $this->table_name;

        if ($filter) {
            $query .= " WHERE title LIKE :filter";
        }

        if ($sort) {
            $query .= " ORDER BY title " . ($sort === 'asc' ? 'ASC' : 'DESC');
        }

        $query .= " LIMIT :start, :pageMax";

        $stmt = $this->conn->prepare($query);

        if ($filter) {
            $stmt->bindValue(':filter', '%' . $filter . '%', PDO::PARAM_STR);
        }
        $stmt->bindValue(':start', $start, PDO::PARAM_INT);
        $stmt->bindValue(':pageMax', $pageMax, PDO::PARAM_INT);

        $stmt->execute();
        $movies = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $movies;
    }
}
