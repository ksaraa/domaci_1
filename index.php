<?php
require_once __DIR__ . '/controller/userController.php';
require_once __DIR__ . '/controller/taskContoller.php';
require_once __DIR__ . '/controller/statusController.php';

$userController = UserController::getInstance();
$taskController = TaskController::getInstance();
$statusContoller = StatusController::getInstance();

if (!$userController->isLogin()) {
  header("Location: login.php");
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <title>Bootstrap Example</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">

</head>

<body>

  <div class="container">
    <div class="row">
      <a href="api/login.php?logout">Sing out</a>
    </div>
    
    <div class="row">
      <form class="mb-2 mt-2">
      <div class="form-check form-check-inline">
        <input class="form-check-input" type="radio" name="selected-status" id="selected-status-0" value="0" checked="checked"/>
        <label class="form-check-label" for="selected-status-0">ALL</label>
      </div>

      <?php 
        $statuses = $statusContoller->getAllStatuses();
        $statusesArray = json_decode($statuses);

        foreach ($statusesArray as $status) {
          $statusModel = StatusModel::fromJson(json_encode($status));
          echo "<div class='form-check form-check-inline'>".
          "<input class='form-check-input' type='radio' name='selected-status' id='selected-status-".$statusModel->getId()."' value='".$statusModel->getId()."'/>".
          "<label class='form-check-label' for='selected-status-0'>".$statusModel->getStatus()."</label>".
          "</div>";
        }
      ?>
      </form>
    </div>

    <div class="row">
      <table class="table" id="tasks-table">
        <thead scope="row">
          <th scope="col">Id</th>
          <th scope="col">Name</th>
          <th scope="col">Status</th>
          <th scope="col">Edit</th>
        </thead>
        <?php
        $tasks = $taskController->getAllForUser();
        $tasksArray = json_decode($tasks);

        if ($tasksArray === null) {
          echo "Failed to Load tasks";
        } else {
          foreach ($tasksArray as $task) {
            $taskModedl = TaskModel::fromJson(json_encode($task));
            echo "<tr>" .
              "<td>" . $taskModedl->getTaskId() . "</td>" .
              "<td>" . $taskModedl->getName() . "</td>" .
              "<td>" . $taskModedl->getStatus()->getStatus() . "</td>" .
              "<td>" . "<a href='task.php?id=".$taskModedl->getTaskId()."'>Edit</a>" . "</td>" .
              "</tr>";
          }
        }
        ?>
      </table>
    </div>
  </div>

  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  <script src="js/tasks.js"></script>
</body>

</html>