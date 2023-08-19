<?php 
    require_once "../controller/userController.php";
    require_once "../repo/taskRepo.php";
    require_once __DIR__."/../util/sessionUtil.php";

    $userController = UserController::getInstance();

    if(isset($_GET['logout'])) {
        SessionUtil::endSession();
        header("Location: login.php");
    }


    if(isset($_POST['username']) && isset($_POST['password'])) {
        echo $userController->login($_POST['username'], $_POST['password']);
    } else {
        echo "ERROR";
    }
?>