<?php
$conn = new Mysqli("localhost","henoktas_issa","Ethiopia1@","henoktas_todoapp");
if($conn->connect_errno){
    die("Connection Error");
}
?>