<?php

require_once __DIR__.'/../models/taskModel.php';
require_once 'dbConnector.php';
require_once 'userRepo.php';
require_once 'statusRepo.php';

class TaskRepository {
    private $db;
    private $userRepository;
    private $statusRepository;

    public function __construct(DatabaseConnection $db) {
        $this->db = $db;
        $this->userRepository = new UserRepository($this->db);
        $this->statusRepository = new StatusRepository($this->db);
    }

    public function getAllTasks() {
        $sql = "SELECT * FROM tasks";
        $result = $this->db->query($sql);
        $tasks = [];

        while ($row = $result->fetch_assoc()) {
            $tasks[] = $this->createTaskModelFromRow($row);
        }

        return $tasks;
    }

    public function getTaskById($id) {
        $id = $this->db->escape($id);
        $sql = "SELECT * FROM tasks WHERE task_id = $id";
        $result = $this->db->query($sql);

        return $this->createTaskModelFromRow($result->fetch_assoc());
    }

    public function createTask($name, $userId, $statusId) {
        $name = $this->db->escape($name);
        $userId = $this->db->escape($userId);
        $statusId = $this->db->escape($statusId);

        $sql = "INSERT INTO tasks (name, user_id, status_id) VALUES ('$name', $userId, $statusId)";
        $result = $this->db->query($sql);

        if ($result) {
            return $this->db->getLastInsertId();
        } else {
            return null;
        }
    }

    public function updateTask($id, $name, $statusId) {
        $id = $this->db->escape($id);
        $name = $this->db->escape($name);
        $statusId = $this->db->escape($statusId);

        $sql = "UPDATE tasks SET name = '$name', status_id = $statusId WHERE task_id = $id";
        return $this->db->query($sql);
    }

    public function getTasksByUserId($userId) {
        $userId = $this->db->escape($userId);
        $sql = "SELECT * FROM tasks WHERE user_id = $userId";
        $result = $this->db->query($sql);
        $tasks = [];

        while ($row = $result->fetch_assoc()) {
            $tasks[] = $this->createTaskModelFromRow($row);
        }

        return $tasks;
    }

    public function createTaskWithUserAndStatus($name, $userId, $statusId) {
        $name = $this->db->escape($name);
        $userId = $this->db->escape($userId);
        $statusId = $this->db->escape($statusId);

        $sql = "INSERT INTO tasks (name, user_id, status_id) VALUES ('$name', $userId, $statusId)";
        $result = $this->db->query($sql);

        if ($result) {
            return $this->db->getLastInsertId();
        } else {
            return null;
        }
    }

    private function createTaskModelFromRow($row) {
        if (!$row) {
            return null;
        }

        $userModel = $this->getUserModelById($row['user_id']);
        $statusModel = $this->getStatusById( $row['status_id']);

        return new TaskModel($row['task_id'], $row['name'], $userModel, $statusModel);
    }

    private function getUserModelById($userId) {
        return $this->userRepository->getUserById($userId);
    }

    private function getStatusById($satusId) {
        return $this->statusRepository->getStatusById($satusId);
    }
}
?>
