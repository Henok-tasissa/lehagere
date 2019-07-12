<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Credentials: true');
//session_start();
include("db.php");

class View{
    /*
    View
        -token and user id of logged in user
        -Allposts
        -Posts By date
    */

    public function getLoggedInUser(){
        $userId= $_SESSION['userId'];
        $token= $_SESSION['token'];
        $userInfo = [
            "userId"=>$userId,
            "token"=>$token
        ];
        $userInfo =  json_encode($userInfo);
        return $userInfo;
    }

    public function getAllTodo($userId,$token){
        global $conn;
        //$userId = $_SESSION['userId'];
        //$token = $_SESSION['token'];

        $sql = "SELECT * FROM todolist WHERE user_id='$userId' ORDER BY id DESC";
        $query = $conn->query($sql);
        if($query->num_rows>0){
            $todo = array();
            while($data = $query->fetch_assoc()){
                $todo[] = $data;
            }
             return json_encode($todo);
        }else{
            return "false";
        }
    }
    public function getSingleTodo($userId,$todoId){
        global $conn;
        $sql = "SELECT * FROM todolist WHERE user_id = '$userId' AND id = '$todoId'";
        $query = $conn->query($sql);
        if($query->num_rows == 1){
            return json_encode($query->fetch_assoc());
        }else{
            return false;
        }
    }
    public function getTodoByDate($date){
        global $conn;
        $userId= $_SESSION['userId'];
        $sql = "SELECT * FROM todolist WHERE user_id='$userId' AND todo_date='$date'";
        $query = $conn->query($sql);
        if($query->num_rows>0){
            return json_encode($query->fetch_assoc());
        }else{
            return false;
        }
    }
    public function getTodoActive($status){
        global $conn;
        $userId= $_SESSION['userId'];
        $sql = "SELECT * FROM todolist WHERE user_id='$userId' AND todo_status='$status'";
        $query = $conn->query($sql);
        if($query->num_rows>0){
            return json_encode($query->fetch_assoc());
        }else{
            return false;
        }
    }
}

//$vw = new View;
//echo $vw->getAllTodo();
//echo $vw->getLoggedInUser();nt4
//echo $vw->getTodoActive("posted");
