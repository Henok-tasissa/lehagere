<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Credentials: true');
header('Content-Type: application/json');
session_start();
include("db.php");
include("model.php");
include("view.php");
$model = new Model;
$view = new View;
global $conn;
if($_SERVER['REQUEST_METHOD'] == "POST"){
    if(isset($_POST['type'])){
        if($_POST['type'] == "postTodo"){
            if($model->checkLogin()){
                $todoTitle = $conn->escape_string($_POST['todoTitle']);
                $todoText = $conn->escape_string($_POST['todoText']);
                $todoDate = $conn->escape_string($_POST['todoDate']);
                $model->insertTodo($todoTitle,$todoText,$todoDate);
                echo "Todo inserted";
            }else{
                $model->registerUser();
                $todoTitle = $conn->escape_string($_POST['todoTitle']);
                $todoText = $conn->escape_string($_POST['todoText']);
                $todoDate = $conn->escape_string($_POST['todoDate']);
                $model->insertTodo($todoTitle,$todoText,$todoDate);
                echo "Todo inserted";
            }
        }else if($_POST['type'] == "loginWithToken"){
            $userId = $conn->escape_string($_POST['userId']);
            $token = $conn->escape_string($_POST['token']);
            $login = $model->login($userId,$token);
            if(!$login){
                $model->registerUser();
            }else{
                echo "Logged in";
            }
        }else if($_POST['type'] == "registerAndLogin"){
            $model->registerUser();
            $userInfo = [
                "userId"=>$_SESSION['userId'],
                "token"=>$_SESSION['token']
            ];

            echo json_encode($userInfo);
        }else if($_POST['type'] == "updateTodo"){
            $todoId = $_POST['todoId'];
            $todoDate = $_POST['todoDate'];
            $todoTitle = $_POST['todoTitle'];
            $todoText = $_POST['todoText'];
            if($model->updateTodo($todoId, $todoTitle,$todoText,$todoDate)){
                echo "True";
            }else{
                echo "false";
            }
        }else if($_POST['type']=="updateStatus"){
            $todoId = $conn->escape_string($_POST['todoId']);
            $todoStatus = $conn->escape_string($_POST['todoStatus']);
            if($model->changeTodoStatus($todoId,$todoStatus)){
                echo "true";
            }else{
                echo "false";
            }
        }else if($_POST['type']=="removeTodo"){
            $todoId = $conn->escape_string($_POST['todoId']);
            if($model->deleteTodo($todoId)){
                echo "true";
            }else{
                echo "false";
            }
        }else if($_POST['type'] == "viewAllTodo"){
            $userId = $conn->escape_string($_POST['userId']);
            $token = $conn->escape_string($_POST['token']);
            echo $view->getAllTodo($userId,$token);

            /*if($model->checkLogin()){
                echo $view->getAllTodo($_SESSION['userId'],$_SESSION['token']);
            }else{
                echo 123;
            }*/
        }else if($_POST['type'] == "getSingleTodo"){
            $userId = $conn->escape_string($_POST['userId']);
            $todoId = $conn->escape_string($_POST['todoId']);
            echo $view->getSingleTodo($userId,$todoId);
        }
    }
}else if($_SERVER['REQUEST_METHOD'] == "GET"){
    if(isset($_GET['type'])){
        if($_GET['type'] == "viewAllTodo"){
            var_dump($_GET);
            echo $view->getAllTodo($_SESSION['userId'],$_SESSION['token']);

            /*if($model->checkLogin()){
                echo $view->getAllTodo($_SESSION['userId'],$_SESSION['token']);
            }else{
                echo 123;
            }*/
        }else if($_GET['type'] == "getSingleTodo"){
            $userId = $conn->escape_string($_GET['userId']);
            $todoId = $conn->escape_string($_GET['todoId']);
            echo $view->getSingleTodo($userId,$todoId);
        }
    }
}