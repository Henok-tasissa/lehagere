<?php
session_start();
include("./class/user.class.php");
include("./database.php");

if($_SERVER['REQUEST_METHOD'] == 'POST'){
	$user = new User;//Initialize object


	if(isset($_POST['type'])){
		if($_POST['type']=="loginUser"){
			$email = $conn->escape_string($_POST['email']);	
			$password = $conn->escape_string($_POST['password']);
			$rememberMe = "";
			if(isset($_POST['rememberMe'])){
				if($_POST['rememberMe'] == true){
					$rememberMe = true;
				}else{
					$rememberMe = false;
				}
			}

			if(!empty($email) && !empty($password)){
					if($user->login($email,$password)){
						$user->addOnlineStatus();
						$logInUser = $user->userSessionId();
						$token = $user->getToken();
						$successLog = [
							"status"=>true,
							"message"=>"Successfully Logged In",
							"remember_me"=>$rememberMe,
							"user_id"=>$logInUser,
							"token"=>$token
						];
						echo json_encode($successLog);
					}else{
						$errorLog = [
							"status"=>false,
							"message"=>"Login Error!"
						];
						echo json_encode($errorLog);
					}
			}else{
				echo "Fields are empty";
				//header("location: http://localhost/ethiopianbet/index.html");
			}
		}else if($_POST['type'] == "loginWithToken"){
			$userId = $conn->escape_string($_POST['userId']);	
			$token = $conn->escape_string($_POST['token']);
			if($user->loginWithToken($userId,$token)){
					$user->addOnlineStatus();
					$logInUser = $user->userSessionId();
					$token = $user->getToken();
					$successLog = [
						"status"=>"true",
						"message"=>"Successfully Logged In With Token",
						"user_id"=>$logInUser,
						"token"=>$token
					];
					echo json_encode($successLog);
				}else{
					$errorLog = [
						"status"=>"false",
						"message"=>"Login With Token Error!"
					];
					echo json_encode($errorLog);
			}
		}
	}
}
?>