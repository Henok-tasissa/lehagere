<?php
include("database.php");
?>
<?
function registerUser($firstName,$lastName,$birthDate,$gender,$email,$password){
	$ipAddress = $_SERVER['REMOTE_ADDR'];
	$sql = "INSERT INTO user VALUES (NULL,'$firstName','$lastName','$birthDate','$gender','$email',1,0,'NOW','$ipAddress')";
	$query = $db->query($sql);
	if($query){
		var_dump($query);
	}else{
		return false;
	}
}
?>