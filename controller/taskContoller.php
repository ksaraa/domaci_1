<?php 
    require_once __DIR__ ."/../service/taskService.php";
    require_once  __DIR__ ."/../repo/taskRepo.php";
    class TaskController {
        private static $instance = null;
        private $taskService;
        private $userService;

        private function __construct() {
            $this->taskService = new TaskService(new TaskRepository(DatabaseConnection::getInstance()));
            $this->userService = new UserService(new UserRepository(DatabaseConnection::getInstance()));

        }

        public static function getInstance() {
            if (self::$instance === null) {
                self::$instance = new TaskController();
            }
            return self::$instance;
        }

        public function getAllTasks() {
            $tasks =  $this->taskService->getAllTasks();
            
            return $this->createResponseArray($tasks);
        }

        public function getAllForUser() {
            $tasks =  $this->taskService->getTasksByUserId($this->userService->getCurrentUserId());

            return $this->createResponseArray($tasks);
        }

        public function getById($taskId) {
            return $this->taskService->getTaskById($taskId)->toJson()."";
        }

        public function getByStatusId($statusId) {
            if($statusId == 0) {
                return $this->getAllForUser();
            } else {
                return $this->createResponseArray($this->taskService->getTasksByStatus($this->userService->getCurrentUserId(), $statusId));
            }
        }

        public function handleTask($taskId, $name, $statusId) {
            $userId = $this->userService->getCurrentUserId();
            if($taskId == '-1') {
                return $this->taskService->createTaskWithUserAndStatus($name, $userId, $statusId);
            } else {
                $status = $this->taskService->updateTask($taskId, $name, $statusId);
                return $status? $taskId : "-1";
            }
        }

        private function createResponseArray($tasks) {
            $response = "[";

            foreach($tasks as $task) {
               $response = $response.$task->toJson().",";
            }

            $response = rtrim($response, ",");
            $response = $response."]";
            
            return $response;
        }

    }
?>