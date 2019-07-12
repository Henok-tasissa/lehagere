<?php
session_start();
include("./class/user.class.php");
include("./database.php");
if($_SERVER['REQUEST_METHOD'] == 'POST'){
	$firstName = $_POST['firstName'];
	$lastName = $_POST['lastName'];
	$email = $_POST['userEmail'];	
	$password = $_POST['userPassword'];
	$birthDate = $_POST['birthDate'];
	$gender = $_POST['gender'];

	if(!empty($firstName) && !empty($lastName) && !empty($email) && !empty($birthDate) && !empty($gender) && !empty($password)){
			$user = new User;
			if(!$user->emailExist($email)){
				$user->setFirstName($firstName);
				$user->setLastName($lastName);
				$user->setEmail($email);
				$user->setPassword($password);
				$user->setBirthDate($birthDate);
				$user->setGender($gender);
				if($gender=="Male"){
					$user->setImageId(1);
				}else{
					$user->setImageId(0);					
				}
				$user->setAuthentication();
				$register = $user->register();
				if($register){
					$registerStatus = [
						"type"=>"register",
						"status"=>true,
						"message"=>"Successfully registered."
					];
					echo json_encode($registerStatus);
					//header("location: http://localhost/wetalk/index.php?register=true");
				}else{
					$registerStatus = [
						"type"=>"register",
						"status"=>false,
						"message"=>"Not registered."
					];
					echo json_encode($registerStatus);
				}
			}else{
				$registerStatus = [
					"type"=>"register",
					"status"=>false,
					"message"=>"Email is already used."
				];
				echo json_encode($registerStatus);
				//header("location: http://localhost/ethiopianbet/index.html");
			}
	}else{
		$registerStatus = [
			"type"=>"register",
			"status"=>false,
			"message"=>"Some fields are empty."
		];
		echo json_encode($registerStatus);
	}

}
?>