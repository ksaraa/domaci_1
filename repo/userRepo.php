<?php 
require_once __DIR__.'/../models/userModel.php'; 
require_once 'dbConnector.php';

class UserRepository {
    private $db;

    public function __construct(DatabaseConnection $db) {
        $this->db = $db;
    }

    public function getAllUsers() {
        $sql = "SELECT * FROM users";
        $result = $this->db->query($sql);
        $users = [];

        while ($row = $result->fetch_assoc()) {
            $users[] = $this->createUserModelFromRow($row);
        }

        return $users;
    }

    public function getUserById($id) {
        $id = $this->db->escape($id);
        $sql = "SELECT * FROM users WHERE id = $id";
        $result = $this->db->query($sql);
        $row = $result->fetch_assoc();

        return $this->createUserModelFromRow($row);
    }

    public function getUserByName($username) {
        $username = $this->db->escape($username);
        $sql = "SELECT * FROM users WHERE username = '$username'";
        $result = $this->db->query($sql);
        $row = $result->fetch_assoc();

        return $this->createUserModelFromRow($row);
    }

    public function insertUser($username, $password) {
        $username = $this->db->escape($username);
        $hashedPassword = $password;

        $sql = "INSERT INTO users (username, password) VALUES ('$username', '$hashedPassword')";
        $this->db->query($sql);

        $insertId = $this->db->getLastInsertId();
        return $this->getUserById($insertId);
    }

    public function updateUser($id, $newUsername) {
        $id = $this->db->escape($id);
        $newUsername = $this->db->escape($newUsername);

        $sql = "UPDATE users SET username = '$newUsername' WHERE id = $id";
        $this->db->query($sql);

        return $this->getUserById($id);
    }

    private function createUserModelFromRow($row) {
        if (!$row) {
            return null;
        }

        return new UserModel($row['id'], $row['username'], $row['password']);
    }
}

?>