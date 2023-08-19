<?php 
    require_once __DIR__ ."/../service/statusService.php";
    require_once  __DIR__ ."/../repo/statusRepo.php";

    class StatusController {
        private static $instance = null;
        private $statusService;

        private function __construct() {
            $this->statusService = new StatusService(new StatusRepository(DatabaseConnection::getInstance()));
        }

        public static function getInstance() {
            if (self::$instance === null) {
                self::$instance = new StatusController();
            }
            return self::$instance;
        }

        public function getAllStatuses() {
            return $this->createResponseArray($this->statusService->getAllStatuses());
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