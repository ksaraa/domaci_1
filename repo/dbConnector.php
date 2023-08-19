<?php 
class DatabaseConnection {
    private static $instance = null;
    private $connection;

    private $host = "localhost";
    private $username = "root";
    private $password = "";
    private $database = "to_do_tracker";

    private function __construct() {
        $this->connection = new mysqli($this->host, $this->username, $this->password, $this->database);
        if ($this->connection->connect_error) {
            die("Connection failed: " . $this->connection->connect_error);
        }
    }

    public static function getInstance() {
        if (self::$instance === null) {
            self::$instance = new DatabaseConnection();
        }
        return self::$instance;
    }

    public function query($sql) {
        return $this->connection->query($sql);
    }

    public function escape($value) {
        return $this->connection->real_escape_string($value);
    }

    public function getLastInsertId() {
        return $this->connection->insert_id;
    }
}
?>