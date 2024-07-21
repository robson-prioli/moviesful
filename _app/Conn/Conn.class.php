<?php



class Conn {
    private static $instance = null;
    private $connection;

    private $host = DB_HOST;
    private $dbName = DB_DATABASE;
    private $username = DB_USERNAME;
    private $password = DB_USERPASS;

    private function __construct() {
        try {
            $this->connection = new PDO("mysql:host={$this->host};dbname={$this->dbName}", $this->username, $this->password);
            $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die('Database connection failed: ' . $e->getMessage());
        }
    }

    public static function getInstance() {
        if (self::$instance === null) {
            self::$instance = new Conn();
        }
        return self::$instance;
    }

    public function getConnection() {
        return $this->connection;
    }
}