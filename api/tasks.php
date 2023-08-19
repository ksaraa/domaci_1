<?php 
    require_once __DIR__."/../controller/taskContoller.php";

    $taskController = TaskController::getInstance();

    if(isset($_GET['status_id'])) {
        echo $taskController->getByStatusId($_GET['status_id']);
    }

    if(isset($_POST['task_id'])) {
        $taskId = $_POST['task_id'];
        $name = $_POST['task_name'];
        $statusId = $_POST['task_status'];
        
        echo $taskController->handleTask($taskId, $name, $statusId);
    }
?>