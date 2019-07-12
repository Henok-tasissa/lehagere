<?php
session_start();
include("database.php");
include("class/post.class.php");
include("class/user.class.php");
header('Content-Type: application/json');

if($_SERVER['REQUEST_METHOD'] == "GET"){
	$userPost = new Post;//Initialize object
	$user = new User;

	if(isset($_GET['type'])){
		if($_GET['type'] == "getCategories"){
			echo $userPost->viewCategories();
		}

		if($_GET['type'] == "viewAllPost"){
			echo $userPost->viewAllPost($_GET['requestLimit']);
		}
		if($_GET['type'] == "viewAllPostForOffline"){
			echo $userPost->viewAllPostForOffline($_GET['requestLimit']);
		}
		if($_GET['type'] == "viewPostByCategory"){
			$categoryId = $conn->escape_string($_GET['categoryId']);
			echo $userPost->viewPostByCategory($categoryId,$_GET['requestLimit']);
		}

		if($_GET['type'] == "viewPostByCategoryForOffline"){
			$categoryId = $conn->escape_string($_GET['categoryId']);
			echo $userPost->viewPostByCategoryForOffline($categoryId,$_GET['requestLimit']);
		}

		if($_GET['type'] == "viewSinglePost"){
			echo $userPost->viewSinglePost($_GET['postId']);
		}

		if($_GET['type'] == "viewSinglePostForOffline"){
			echo $userPost->viewSinglePostForOffline($_GET['postId']);
		}

		if($_GET['type']== "viewComments"){
			$postId = $conn->escape_string($_GET['postId']);
			echo $userPost->viewComments($postId);
		}

		if($_GET['type']== "viewCommentsForOffline"){
			$postId = $conn->escape_string($_GET['postId']);
			echo $userPost->viewCommentsForOffline($postId);
		}

		if($_GET['type'] == "getUserSession"){
			echo $_SESSION['user_id'];
		}


		if($_GET['type'] == "userProfileInfo"){
			if(isset($_GET['uid'])){
				if(isset($_SESSION['user_id'])){
					if($_GET['uid'] == $_SESSION['user_id']){
						echo $user->viewProfile();
					}else{
						echo $user->viewUserProfile($_GET['uid']);
					}
				}else{
					echo $user->viewUserProfile($_GET['uid']);
				}
			}else{
				echo $user->viewProfile();
			}
		}

		if($_GET['type'] == "postByUserId"){
			if(isset($_GET['uid'])){
				if(isset($_SESSION['user_id'])){
					if($_GET['uid'] == $_SESSION['user_id']){
						echo $userPost->viewPostByUserId($_GET['uid']);
					}else{
						echo $userPost->viewPostByUserId($_GET['uid']);
					}
				}else{
					echo $userPost->viewPostByUserIdForOffline($_GET['uid']);
				}
			}else{
				$error = [
					"type"=>"error",
					"message"=>"User Doesn't exist",
					"error"=>true
				];
				echo $error;
			}
		}

		if($_GET['type'] == "postByMe"){
			$userId = $_SESSION['user_id'];
			echo $userPost->viewPostByUserId($userId);
		}
	}else{
		echo "Error";
	}
}

?>