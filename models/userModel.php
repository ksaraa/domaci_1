<?php 
class UserModel {
    private $id;
    private $username;
    private $password;

    public function __construct($id, $username, $password) {
        $this->id = $id;
        $this->username = $username;
        $this->password = $password;
    }

    public static function fromJson($json) {
        $data = json_decode($json, true);

        return new self(
            $data['id'],
            $data['username'],
            $data['password']
        );
    }

    public function getId() {
        return $this->id;
    }

    public function getUsername() {
        return $this->username;
    }

    public function setPassword($newPassword) {
        $this->password = $newPassword;
    }

    public function verifyPassword($inputPassword) {
        return $inputPassword == $this->password;
    }

    public function toJson() {
        return json_encode([
            'id' => $this->id,
            'username' => $this->username,
            'password' => $this->password
        ], JSON_UNESCAPED_UNICODE);
    }

    public function toArray() {
        return [
            'id' => $this->id,
            'username' => $this->username,
            'password' => $this->password
        ];
    }
}
?>