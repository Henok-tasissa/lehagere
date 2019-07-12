<?php
require_once('config.php');
$conn = new mysqli(HOST_NAME,HOST_USER,HOST_PASSWORD,DATABASE_NAME);
if($conn->connect_errno){
	die("Can't connect to database!");
}
 mysqli_set_charset($conn,"utf8");
?>