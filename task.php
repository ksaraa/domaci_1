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

$task = new TaskModel("-1", "", null, null);
$selectDisabled = true;
$statuses = $statusContoller->getAllStatuses();
$statusesArray = json_decode($statuses);

if (isset($_GET['id'])) {
    $task = TaskModel::fromJson($taskController->getById($_GET['id']));
    $selectDisabled = false;
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
        <a href="index.php">Home</a>
      <a href="api/login.php?logout">Sing out</a>
    </div>
        <div class="row">
            <h3 class="mt-3 text-success text-center">TASK</h3>
            <p class="text-center" id="msg"></p>
            <form id="task-form" action="" method="post">
                <div class="mb-3 mt-3">
                    Id:<br />
                    <input type="text" class="form-control" name="task_id" readOnly="readOnly"
                        value="<?php echo $task->getTaskId() ?>">
                </div>
                <div class="mb-3 mt-3">
                    Name:<br />
                    <input type="text" class="form-control" name="task_name" value="<?php echo $task->getName() ?>">
                </div>
                <div class="mb-3 mt-3">
                    <?php
                        $statusField = "";
                        if (!$selectDisabled) {
                            $statusField .= "<select name='task_status' class='form-select'>";
                        }
                        foreach ($statusesArray as $status) {
                            $statusModel = StatusModel::fromJson(json_encode($status));
                            if ($selectDisabled) {
                                if ($statusModel->getStatus() == "open") {
                                    $statusField = "<input type='hidden' name='task_status' value='" . $statusModel->getId() . "'>";
                                }
                            } else {
                                $selected = !$selectDisabled && $statusModel->getId() == $task->getStatus()->getId() ? "selected" : "";
                                $statusField .= "<option value='" . $statusModel->getId() . "' " . $selected . ">" . $statusModel->getStatus() . "</option>";
                            }
                        }
                        if (!$selectDisabled) {
                            $statusField .= "</select>";
                        }
                        echo $statusField;
                    ?>
                </div>
                <button type="submit" class="btn btn-primary">SAVE</button>
            </form>
        </div>

    </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="js/tasks.js"></script>
</body>

</html>