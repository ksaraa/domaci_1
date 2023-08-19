<?php 
class StatusModel {
    private $id;
    private $status;

    public function __construct($id, $status) {
        $this->id = $id;
        $this->status = $status;
    }

    public static function fromJson($json) {
        $data = json_decode($json, true);

        return new self(
            $data['id'],
            $data['status']
        );
    }

    public function getId() {
        return $this->id;
    }

    public function getStatus() {
        return $this->status;
    }

    public function setStatus($newStatus) {
        $this->status = $newStatus;
    }

    public function toJson() {
        return json_encode([
            'id' => $this->id,
            'status' => $this->status
        ], JSON_UNESCAPED_UNICODE);
    }

    public function toArray() {
        return [
            'id' => $this->id,
            'status' => $this->status
        ];
    }
}
?>