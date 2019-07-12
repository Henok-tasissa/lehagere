<?php
if(!isset($_SESSION)){
	session_start();
}
require("./database.php");

class User{
	private $firstName;
	private $lastName;
	private $birthDate;
	private $gender;
	private $email;
	private $password;
	private $status;
	private $country = "Ethiopia";
	private $imageId;
	private $ipAddress;
	private $verifyEmail=0;
	private $authentication;


	public function setFirstName($firstName){
	    global $conn;
		$firstName = ucfirst($firstName);
		$this->firstName = mysqli_real_escape_string($conn,$firstName);
	}
	
	public function setLastName($lastName){
	    global $conn;
		$lastName = ucfirst($lastName);
		$this->lastName = mysqli_real_escape_string($conn,$lastName);
	}
	public function setBirthDate($birthDate){
	    global $conn;
		$this->birthDate = mysqli_real_escape_string($conn,$birthDate);
	}
	public function setGender($gender){
	    global $conn;
		$this->gender = mysqli_real_escape_string($conn,$gender);
	}
	public function setEmail($email){
	    global $conn;
		$this->email = mysqli_real_escape_string($conn,strtolower($email));
	}
	public function setPassword($password){
	    global $conn;
		$this->password = mysqli_real_escape_string($conn,$password);
	}
	public function setImageId($imageId=1){
	    global $conn;
		$this->imageId = mysqli_real_escape_string($conn,$imageId);
	}
	public function setCountry($country="Ethiopia"){
	    global $conn;
		$country = ucfirst($country);
		$this->country = mysqli_real_escape_string($conn,$country);
	}
	public function setVerifyEmail($verifyEmail=0){
	    global $conn;
		$this->verifyEmail = mysqli_real_escape_string($conn,$verifyEmail);
	}
	public function setStatus($status){
	    global $conn;
		$this->status = mysqli_real_escape_string($conn,$status);
	}

	public function setAuthentication(){
	    global $conn;
		$randomNum = rand(2012,9999);
		$hash = md5($randomNum);
		$this->authentication = $hash;
	}

	public function getFirstName(){
		return $this->firstName;
	}
	public function getLastName(){
		return $this->lastName;
	}
	public function getBirthDate(){
		return $this->birthDate;
	}
	public function getGender(){
		return $this->gender;
	}
	public function getEmail(){
		return $this->email;
	}
	public function getPassword(){
		return $this->password;
	}
	public function getCountry(){
		return $this->country;
	}
	public function getImageId(){
		return $this->imageId;
	}
	public function getVerifyEmail(){
		return $this->verifyEmail;
	}
	public function getIpAddress(){
		return $_SERVER['REMOTE_ADDR'];
	}
	public function getAuthentication(){
		return $this->authentication;
	}
	public function getStatus(){
		return $this->status;
	}


	public function getToken(){
		global $conn;
		$userId = $_SESSION['user_id'];
		$sql = "SELECT authentication FROM user WHERE user_id='$userId'";
		$query = $conn->query($sql);
		if($query->num_rows==1){
			 
			$data = $query->fetch_assoc();
			$token = $data['authentication'];
			return $token;
		}
	}
	/*
		Returns user session id if it exist
	*/
	public function userSessionId(){
		if(isset($_SESSION['user_id'])){
			return $_SESSION['user_id'];
		}else{
			return 0;
		}
	}

	/*
		Checks if email exist in the database
		@param email address from the form
	*/
	public function emailExist($email){
		global $conn;
		$sql = "SELECT * FROM user WHERE email_address = '$email'";
		$query = $conn->query($sql);
		if($query){
			if($query->num_rows<1){
				return false;
			}else{
				return true;
			}
		}
	}

	/*
		Registeres user to the database
	*/
	public function register(){
			$firstName=$this->getFirstName();
			$lastName=$this->getLastName();
			$birthDate=$this->getBirthDate();
			$gender=$this->getGender();
			$email= strtolower($this->getEmail());
			$password=md5($this->getPassword());
			$country=$this->getCountry();
			$imageId=$this->getImageId();
			$ipAddress=$this->getIpAddress();
			$verifyEmail=$this->getVerifyEmail();
			$authentication = $this->getAuthentication();
			$sql = "INSERT INTO user 
				VALUES (
					NULL,'$firstName','$lastName','$birthDate','$gender','$email','$password','$country','$imageId','$verifyEmail',NULL,'$ipAddress','$authentication','Please, share lehagere for friends.'
				)";
		global $conn;
		$query = $conn->query($sql);
		if($query){
			return true;
		}else{
			return false;
		}
	}

	public function login($email,$password){
		global $conn;
		$password = md5($password);
		$sql = "SELECT * FROM user WHERE email_address = '$email' AND password = '$password'";
		$query = $conn->query($sql);
		if($query){
			if($query->num_rows == 1){
				$user = $query->fetch_assoc();
				$_SESSION['user_id'] = $user['user_id'];
				return true;
			}else{
				return false;
			}
		}
	}

	public function loginWithToken($userId,$token){
		global $conn;
		$sql = "SELECT * FROM user WHERE user_id='$userId' AND authentication='$token'";
		$query = $conn->query($sql);
		if($query->num_rows==1){
			$_SESSION['user_id'] = $userId;
			return true;
		}else{
			return false;
		}
	}

	/*
		- creates user online status if don't exist
		- updates user online status if exist
		@param Online(1),Offline(2) and busy(3)
		@param default = online
	*/
	public function addOnlineStatus($status='Online'){
		$onlineStatus;
		switch ($status) {
			case 'Online':
			case 'online':
			case 1:
				$onlineStatus = 1;
				break;
			case 'Offline':
			case 'offline':
			case 2:
				$onlineStatus = 2;
				break;
			case 'Busy':
			case 'busy':
			case 3:
				$onlineStatus = 3;
				break;
			default:
				$onlineStatus = 1;
				break;
		}
		global $conn;
		$userId = $this->userSessionId();
		$sql = "SELECT * FROM user_online_status WHERE user_id = '$userId'";
		$query = $conn->query($sql);
		if($query->num_rows==1){
			$sql = "UPDATE user_online_status SET status_type_id = '$onlineStatus', user_status_date = NULL WHERE user_id = $userId";
			$query = $conn->query($sql);
			if($query){
				return true;
			}else{
				return false;
			}
		}else{
			$sql = "INSERT INTO user_online_status VALUES(NULL,'$userId','$onlineStatus',NULL)";
			$query = $conn->query($sql);
			if($query){
				return true;
			}else{
				return false;
			}
		}
	}

	public function viewProfile(){
		global $conn;
		$userId = $_SESSION['user_id'];
		$sql = "SELECT user_id, first_name, last_name, date_of_birth, gender, email_address, country, image, verify_email, status FROM user WHERE user_id = '$userId'";
		$query= $conn->query($sql);
		if($query){
			$user = array();
			while($userData = $query->fetch_assoc()){
			    $userData['first_name'] = ucfirst(strtolower($userData['first_name']));
				$userData['last_name'] = ucfirst(strtolower($userData['last_name']));
				$userData['post_number'] = $this->getNumberOfPosts($userId);				
				$user[] = $userData;
			}
			$jsonUser = json_encode($user);
			return $jsonUser;
		}
	}
	public function viewUserProfile($userId){
		global $conn;
		$sql = "SELECT user_id, first_name, last_name, date_of_birth, gender, email_address, country, image, verify_email,status FROM user WHERE user_id = '$userId'";
		$query= $conn->query($sql);
		if($query){
			$user = array();
			while($userData = $query->fetch_assoc()){
			    $userData['first_name'] = ucfirst(strtolower($userData['first_name']));
				$userData['last_name'] = ucfirst(strtolower($userData['last_name']));
				$userData['post_number'] = $this->getNumberOfPosts($userId);
				
				$user[] = $userData;
			}
			$jsonUser = json_encode($user);
			return $jsonUser;
		}
	}

	public function updateProfile(){
		global $conn;
		$userId = $_SESSION['user_id'];
		$firstName = $this->getFirstName();
		$lastName = $this->getLastName();
		$birthDate = $this->getBirthDate();
		$gender = $this->getGender();
		$sql = "UPDATE user SET first_name = '$firstName', last_name = '$lastName', gender = '$gender', date_of_birth='$birthDate' WHERE user_id='$userId'";
		$query= $conn->query($sql);
		if($query){
			$message = [
				"type"=>"update",
				"status" => true,
				"message" => "Profile updated successfully."
			];

			$jsonUser = json_encode($message);
			return $jsonUser;
		}else{
			$message = [
				"type"=>"update",
				"status" => false,
				"message" => "There was an error updating the information."
			];

			$jsonUser = json_encode($message);
			return $jsonUser;
		}
	}

	public function getNumberOfPosts($userId){
		global $conn;
		$sql = "SELECT * FROM user_post WHERE user_id = '$userId' AND visibility=1";
		$query = $conn->query($sql);
		return $query->num_rows;
	}

	public function postStatus(){
		global $conn;
		$statusText = $this->getStatus();
		$userId = $_SESSION['user_id'];
		$sql = "UPDATE user SET status ='$statusText' WHERE user_id='$userId'";
		$query = $conn->query($sql);		
		if($query){
			$message = [
				"type"=>"Update status",
				"status" => true,
				"message" => "Successfully updated status."
			];

			$jsonUser = json_encode($message);
			return $jsonUser;
		}else{
			$message = [
				"type"=>"Update status",
				"status" => false,
				"message" => "There was an error updating the status."
			];

			$jsonUser = json_encode($message);
			return $jsonUser;
		}
	}

	public function changeProfileImage(){
		$errors= array();
		$file_name = $_FILES['image']['name'];
		$file_size =$_FILES['image']['size'];
		$file_tmp =$_FILES['image']['tmp_name'];
		$file_type=$_FILES['image']['type'];
		$file_ext=strtolower(end(explode('.',$_FILES['image']['name'])));
		
		$expensions= array("jpeg","jpg","png");
		
		if(in_array($file_ext,$expensions)=== false){
			$errors[]="extension not allowed, please choose a JPEG or PNG file.";
		}
		
		if($file_size > 2097152){
			$errors[]='File size must be excately 2 MB';
		}
		
		if(empty($errors)==true){
			$file_name = time().$file_name;
			if($this->updateUserImage($file_name)){
				move_uploaded_file($file_tmp,"../images/".$file_name);
				header("location: ../myprofile.php?img=success");
			}else{
				echo "Fail to upload image, please try again.";
			}
		}else{
			print_r($errors);
		}
	}
	public function updateUserImage($imageName){
		global $conn;
		$userId = $_SESSION['user_id'];
		$sql = "UPDATE user SET image ='$imageName' WHERE user_id='$userId'";
		$query = $conn->query($sql);		
		if($query){
			return true;
		}else{
			return false;
		}
	}
}