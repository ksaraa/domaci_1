<?php 
class TaskModel {
    private $taskId;
    private $name;
    private $user;
    private $status;

    public function __construct($taskId, $name, $user, $status) {
        $this->taskId = $taskId;
        $this->name = $name;
        $this->user = $user;
        $this->status = $status;
    }

    public static function fromJson($json) {
        $data = json_decode($json, true);

        $user = UserModel::fromJson(json_encode($data['user']));
        $status = StatusModel::fromJson(json_encode($data['status']));

        return new self(
            $data['taskId'],
            $data['name'],
            $user,
            $status
        );
    }

    public function getTaskId() {
        return $this->taskId;
    }

    public function getName() {
        return $this->name;
    }

    public function getUser() {
        return $this->user;
    }

    public function getStatus() {
        return $this->status;
    }

    public function setStatus($newStatus) {
        $this->status = $newStatus;
    }

    public function toJson() {
        return json_encode([
            'taskId' => $this->taskId,
            'name' => $this->name,
            'user' => $this->user->toArray(),
            'status' => $this->status->toArray()
        ], JSON_UNESCAPED_UNICODE);
    } 
}
?>