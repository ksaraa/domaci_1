<?php 
    require_once __DIR__ ."/../service/userService.php";
    require_once  __DIR__ ."/../repo/userRepo.php";

    class UserController {
        private static $instance = null;
        private $userService;

        private function __construct() {
            $this->userService = new UserService(new UserRepository(DatabaseConnection::getInstance()));
        }

        public static function getInstance() {
            if (self::$instance === null) {
                self::$instance = new UserController();
            }
            return self::$instance;
        }

        public function login($username, $password) {
            $user = $this->userService->login($username, $password);
            if($user != null) {
                return $user->getId();
            } else {
                return "ERROR";
            }
        }

        public function isLogin() {
            if($this->userService->isLogin()) {
                return true;
            } else {
                return false;
            }
        }

    }
?>