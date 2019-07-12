<?php
include("db.php");
class Model{
    private $userId;
    private $userToken;
    
    public function setUserId($userId){
        $this->userId = $userId;
    }
    public function setUserToken($userToken){
        $this->userToken = $userToken;
    }
    public function getUserId(){
        return $this->userId;
    }
    public function getUserToken(){
        return $this->userToken;
    }

    public function checkLogin(){
        if(isset($_SESSION['userId']) && isset($_SESSION['token'])){
            return true;
        }else{
            return false;
        }
    }
    public function registerUser(){
        global $conn;
        $userId = $this->getUserId();
        $userToken = $this->getUserToken();
        if($userId == "" && $userToken == ""){
            $newToken = md5(rand(1000,9000));
            $sql = "INSERT INTO user VALUES(NULL,'$newToken',NULL)";
            $query = $conn->query($sql);
            if($query){
                $sql = "SELECT * FROM user ORDER BY userId DESC";
                $query = $conn->query($sql);
                $data = $query->fetch_assoc();
                $userId = $data['userId'];
                $token = $data['authentication'];
                $this->login($userId,$token);
                return true;
            }else{
                return false;
            }
        }
    }

    public function login($userId,$token){
        global $conn;
        $sql = "SELECT * FROM user WHERE userId = '$userId' AND authentication = '$token'";
        $query = $conn->query($sql);
        if($query->num_rows == 1){
            $_SESSION['userId'] = $userId;
            $_SESSION['token'] = $token;
            return true;
        }else{
            return false;
        }
    }

    

    public function insertTodo($title,$text,$date){
        global $conn;
        $userId = $_SESSION['userId'];
        $sql = "INSERT INTO todolist VALUES(NULL,'$userId','$title','$text','$date','posted')";
        $query = $conn->query($sql);
        if($query){
            return true;
        }else{
            return false;
        }
    }

    public function updateTodo($listId,$title,$text,$date){
        global $conn;
        $userId = $_SESSION['userId'];
        $token  = $_SESSION['token'];
        $title = $conn->escape_string($title);
        $text = $conn->escape_string($text);
        $date = $conn->escape_string($date);

        $sql = "UPDATE todolist SET todo_title = '$title', todo_text = '$text', todo_date = '$date', todo_status = 'active' WHERE user_id = '$userId' AND id='$listId'";
        $query = $conn->query($sql);
        if($query){
            return true;
        }else{
            return false;
        }
    }

    public function changeTodoStatus($todoId,$status){
        global $conn;
        $userId = $_SESSION['userId'];
        $stat = "";

        switch($status){
            case "completed":
            case "Completed":
                $stat = "completed";
                break;
            case "crossed":
            case "crossed":
                $stat = "crossed";
                break;
            default:
                $stat = "none";
                break;
        }
        $sql = "UPDATE todolist SET todo_status = '$stat' WHERE user_id = '$userId' AND id='$todoId'";
        $query = $conn->query($sql);
        if($query){
            return true;
        }else{
            return false;
        }
    }
    public function deleteTodo($listId){
        global $conn;
        $userId = $_SESSION['userId'];
        $token  = $_SESSION['token'];
        $status = "delete";
        $sql = "DELETE FROM todolist WHERE user_id = '$userId' AND id='$listId'";
        $query = $conn->query($sql);
        if($query){
            echo "Deleted";
            return true;
        }else{
            echo "Not deleted";
            return false;
        }
    }

}

//$model = new Model;
//$model->login(8,"30c8e1ca872524fbf7ea5c519ca397ee");
//$model->deleteTodo(3);
//$model->updateTodo(3,"Updated text","2018/21/11");
//$model->registerUser();
//echo $_SESSION['userId'];
//echo $model->getUserId();
//echo $model->getUSerToken();
//$model->insertTodo("01/12/2018","Sample text");
?>