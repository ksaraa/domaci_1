<?php 
    require_once __DIR__."/../repo/taskRepo.php";
    require_once "userService.php";
    
    class TaskService {
        private $taskRepository;
    
        public function __construct(TaskRepository $taskRepository) {
            $this->taskRepository = $taskRepository;
        }
    
        public function getAllTasks() {
            return $this->taskRepository->getAllTasks();
        }
    
        public function getTaskById($id) {
            return $this->taskRepository->getTaskById($id);
        }
    
        public function createTask($name, UserModel $user, StatusModel $status) {
            return $this->taskRepository->createTask($name, $user->getId(), $status->getId());
        }
    
        public function updateTask($id, $name, $statusId) {
            return $this->taskRepository->updateTask($id, $name, $statusId);
        }

        public function getTasksByUserId($userId) {
            return $this->taskRepository->getTasksByUserId($userId);
        }

        public function createTaskWithUserAndStatus($name, $userId, $statusId) {
            return $this->taskRepository->createTaskWithUserAndStatus($name, $userId, $statusId);
        }

        public function getTasksByStatus($userId, $statusId) {
            $tasks = $this->taskRepository->getTasksByUserId($userId);

            $response = array();
            
            foreach($tasks as $task) {
                if($task->getStatus()->getId() == $statusId) {
                    array_push($response, $task);
                }
            }

            return $response;
        }
    }
?>