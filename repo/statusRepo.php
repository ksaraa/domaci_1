<?php

require_once 'dbConnector.php';
require_once __DIR__.'/../models/statusModel.php';

class StatusRepository {
    private $db;

    public function __construct(DatabaseConnection $db) {
        $this->db = $db;
    }

    public function getAllStatuses() {
        $sql = "SELECT * FROM statuses";
        $result = $this->db->query($sql);
        $statuses = [];

        while ($row = $result->fetch_assoc()) {
            $statuses[] = $this->createStatusModelFromRow($row);
        }

        return $statuses;
    }

    public function getStatusById($id) {
        $id = $this->db->escape($id);
        $sql = "SELECT * FROM statuses WHERE id = $id";
        $result = $this->db->query($sql);

        return $this->createStatusModelFromRow($result->fetch_assoc());
    }

    private function createStatusModelFromRow($row) {
        if (!$row) {
            return null;
        }

        return new StatusModel($row['id'], $row['status']);
    }
}
?>
