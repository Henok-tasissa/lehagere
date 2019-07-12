<?php
session_start();
include("database.php");
include("class/user.class.php");
include("class/post.class.php");
if($_SERVER['REQUEST_METHOD'] == "POST"){
	$user = new User;
	$userPost = new Post;//Initialize post object
	
	if($_POST['type'] == "insertPost"){
		insertPost();
	}else if($_POST['type'] == "updatePost"){
		updatePost();
	}else if($_POST['type']=="deletePost"){
		$postId = $conn->escape_string($_POST['postId']);
		return $userPost->deletePost($postId);
	}else if($_POST['type']=="likePost"){
		$postId = $conn->escape_string($_POST['postId']);
		return $userPost->likePost($postId);
	}else if($_POST['type'] == "unLikePost"){
			$postId = $_POST['postId'];
			return $userPost->unLikePost($postId);
	}else if($_POST['type'] == "postComment"){
			$postId = $_POST['postId'];
			$commentText = $_POST['commentText'];
			echo $userPost->insertComment($postId,$commentText);
	}else if($_POST['type'] == "likeComment"){
			$commentId = $_POST['commentId'];
			$userPost->likePostComment($commentId);
	}else if($_POST['type'] == "unLikeComment"){
			$commentId = $_POST['commentId'];
			$userPost->unLikePostComment($commentId);
	}else if($_POST['type'] == "postStatus"){
			$statusText = $user->setStatus($_POST['statusText']);
			$user->postStatus($statusText);
	}else if($_POST['type'] == "updateProfile"){
		updateProfile();
	}else if($_POST['type'] == "uploadProfileImage"){
		//var_dump($_FILES);
		$user->changeProfileImage();
	}

}

function updateProfile(){
	if(!empty($_POST['firstName']) && !empty($_POST['lastName']) && !empty($_POST['gender']) && !empty($_POST['dateOfBirth'])){
		$user = new User;
		$user->setFirstName($_POST['firstName']);
		$user->setLastName($_POST['lastName']);
		$user->setGender($_POST['gender']);
		$user->setBirthDate($_POST['dateOfBirth']);
		$user->updateProfile();
	}
}
function insertPost(){
	if(!empty($_POST['category']) && ($_POST['category']!=0) && !empty($_POST['postText'])){
			global $conn;
			$category = $_POST['category'];
			$postTitle = $_POST['postTitle'];
			$postText = $_POST['postText'];

			$userPost = new Post;
			$userPost->setPostCategory($category);
			$userPost->setPostTitle($postTitle);
			$userPost->setPostText($postText);
			$userPost->setCommentMode();
			$userPost->setVisibility();
			$userPost->setPublicityMode();
			$post = $userPost->insertPost();

			if($post){
				$message = [
					"type"=>"post",
					"status" => true,
					"message" => "Successfully posted."
				];
				$jsonPost = json_encode($message);
				return $jsonPost;
			}else{
				$message = [
					"type"=>"post",
					"status" => false,
					"message" => "Unable to post."
				];
				$jsonPost = json_encode($message);
				return $jsonPost;
			}
		}
}

function updatePost(){
	if(!empty($_POST['category']) && ($_POST['category']!=0) && !empty($_POST['postText'])){
			global $conn;
			$category = $_POST['category'];
			$postTitle = $_POST['postTitle'];
			$postText = $_POST['postText'];
			$postId = $_POST['postId'];

			$userPost = new Post;
			$userPost->setPostCategory($category);
			$userPost->setPostTitle($postTitle);
			$userPost->setPostText($postText);
			$userPost->setCommentMode();
			$userPost->setVisibility();
			$userPost->setPublicityMode();
			$post = $userPost->updatePost($postId);

			if($post){
				$message = [
					"type"=>"post",
					"status" => true,
					"message" => "Successfully posted."
				];
	
				$jsonPost = json_encode($message);
				return $jsonPost;
			}else{
				$message = [
					"type"=>"post",
					"status" => false,
					"message" => "Unable to post."
				];
				$jsonPost = json_encode($message);
				return $jsonPost;
			}
		}
}
?>