<?php
include("./database.php");
//session_start();

class Post{
	private $postCategory;
	private $postTitle;
	private $postText;
	private $commentMode;
	private $publicityMode;
	private $visibility;
	private $commentText;
	
	public function setPostCategory($postCategory){
        global $conn;
		$this->postCategory = mysqli_real_escape_string($conn,$postCategory);
	}
	public function setPostTitle($postTitle){
        global $conn;
		$this->postTitle = mysqli_real_escape_string($conn,$postTitle);
	}
	public function setPostText($postText){
        global $conn;
		$this->postText = mysqli_real_escape_string($conn,$postText);
	}
	public function setCommentMode($commentMode = 1){
        global $conn;
		$this->commentMode = mysqli_real_escape_string($conn,$commentMode);
	}
	public function setPublicityMode($publicityMode = 1){
        global $conn;
		$this->publicityMode = mysqli_real_escape_string($conn,$publicityMode);
	}
	public function setVisibility($visibility = 1){
        global $conn;
		$this->visibility = mysqli_real_escape_string($conn,$visibility);
	}
	public function setCommentText($commentText){
        global $conn;
		$this->commentText = mysqli_real_escape_string($conn,$commentText);
	}

	public function getPostCategory(){
		return $this->postCategory;
	}
	public function getPostTitle(){
		return $this->postTitle;
	}
	public function getPostText(){
		return $this->postText;
	}
	public function getCommentMode(){
		return $this->commentMode;
	}
	public function getPublicityMode(){
		return $this->publicityMode;
	}
	public function getVisibility(){
		return $this->visibility;
	}
	public function getCommentText(){
		return $thi->commentText;
	}
	/*
		postes to database
	*/
	public function insertPost(){
		global $conn;
		$userId = $_SESSION['user_id'];
		$categoryId = $this->getPostCategory();
		$postTitle = $this->getPostTitle();
		$postText = $this->getPostText();
		$commentMode = $this->getCommentMode();
		$publicityMode = $this->getPublicityMode();
		$visibility = $this->getVisibility();
		$sql = "INSERT INTO user_post VALUES (NULL,'$userId','$categoryId','$postTitle','$postText','$commentMode','$publicityMode','$visibility',NULL,NULL)";
		$query = $conn->query($sql);
		if($query){
			return true;
		}else{
			return false;
		}
	}
	
	/*Updates post*/
	public function updatePost($postId){
		global $conn;
		$userId = $_SESSION['user_id'];
		$categoryId = $this->getPostCategory();
		$postTitle = $this->getPostTitle();
		$postText = $this->getPostText();
		$commentMode = $this->getCommentMode();
		$publicityMode = $this->getPublicityMode();
		$visibility = $this->getVisibility();
		$sql = "UPDATE user_post SET category_id = '$categoryId', post_title='$postTitle', post_text = '$postText' WHERE post_id = '$postId' AND user_id= '$userId'";
		$query = $conn->query($sql);
		if($query){
			return true;
		}else{
			return false;
		}
	}

	/*Deletes a single post / changes the visibility*/
	public function deletePost($postId){
		global $conn;
		$userId = $_SESSION['user_id'];
		$visibility = 0;
		$sql = "UPDATE user_post
				SET visibility = '$visibility', post_update_date = NULL 
				WHERE post_id = '$postId' AND user_id= '$userId'";
		$query = $conn->query($sql);
		if($query){
			return true;
		}else{
			return false;
		}
	}

	/*Adds comment to a post*/
	public function insertComment($postId,$commentText){
		global $conn;
		$userId = $_SESSION['user_id'];
		$visibility = 1;
		$sql = "INSERT INTO comment VALUES(NULL,'$userId','$postId','$commentText','$visibility',NULL)";
		$query = $conn->query($sql);
		if($query){
			return true;
		}else{
			return false;
		}
	}
	/*View Comments*/
	public function viewComments($postId){
		global $conn;
		$comments = array();
		$sql = "SELECT * FROM comment WHERE post_id='$postId'";
		$query = $conn->query($sql);
		$numComment = $query->num_rows;
		while($comment = $query->fetch_assoc()){
			$userInfo = $this->viewUserProfile($comment['user_id']);
			$comment['user_info'] = $userInfo;
			$comment['num_comment'] = $numComment;
			$comment['num_like'] = $this->numCommentLike($comment['comment_id']);
			$comment['num_unlike'] = $this->numCommentUnLike($comment['comment_id']);
			$comment['like'] = $this->checkLikeComment($comment['comment_id']);
			$comment['unlike'] = $this->checkUnLikeComment($comment['comment_id']);
			$comment['comment_text'] = nl2br($comment['comment_text']);
			$comments[] = $comment;
		}
		$jsonComments = json_encode($comments);
		return $jsonComments;
	}

	/*View Comments for offline*/
	public function viewCommentsForOffline($postId){
		global $conn;
		$comments = array();
		$sql = "SELECT * FROM comment WHERE post_id='$postId'";
		$query = $conn->query($sql);
		$numComment = $query->num_rows;
		while($comment = $query->fetch_assoc()){
			$userInfo = $this->viewUserProfile($comment['user_id']);
			$comment['user_info'] = $userInfo;
			$comment['num_comment'] = $numComment;
			$comment['num_like'] = $this->numCommentLike($comment['comment_id']);
			$comment['num_unlike'] = $this->numCommentUnLike($comment['comment_id']);
			$comment['comment_text'] = nl2br($comment['comment_text']);
			$comments[] = $comment;
		}
		$jsonComments = json_encode($comments);
		return $jsonComments;
	}

	/*Returns number of comments for one post*/
	public function countComment($postId){
		global $conn;
		$sql = "SELECT * FROM comment WHERE post_id='$postId'";
		$query = $conn->query($sql);
		return $query->num_rows;
	}


	/*Returns all categories*/
	public function viewCategories(){
		global $conn;
		$categories = array();
		$sql = "SELECT * FROM category";
		$query = $conn->query($sql);

		while($category = $query->fetch_assoc()){
			$categories[] = $category;
		}
		$jsonCategory = json_encode($categories);
		return $jsonCategory;
	}
	public function getCategoryName($id){
		global $conn;
		$sql = "SELECT * FROM category";
		$query = $conn->query($sql);

		while($category = $query->fetch_assoc()){
			if($category['category_id'] == $id){
				return $category['category_name'];
			}
		}
	}
	
	/*Returns all the posts*/
	public function viewAllPost($limit){
		global $conn;
		$sql = "SELECT * FROM user_post WHERE visibility = 1 ORDER BY post_date DESC LIMIT $limit";
		$query = $conn->query($sql);
		if($query){
			$posts = array();
			while($post = $query->fetch_assoc()){
				$numLikes = $this->numLike($post['post_id']);
				$numUnLikes = $this->numUnLike($post['post_id']);
				$likeStatus = $this->checkLikeStatus($post['post_id']);
				$unLikeStatus = $this->checkUnLikeStatus($post['post_id']);
				$userInfo = $this->viewUserProfile($post['user_id']);
				$numComment = $this->countComment($post['post_id']);
				$postType = "Post";
				$post['num_likes'] = $numLikes;
				$post['num_unlikes'] = $numUnLikes;
				$post['like'] = $likeStatus;
				$post['unlike'] = $unLikeStatus;
				$post['user_info'] = $userInfo;
				$post['post_type'] = $postType;
				$post['num_comments'] = $numComment;
				$post['category_name'] = $this->getCategoryName($post['category_id']);
				$post['post_text'] = nl2br($post['post_text']);
				$posts[] = $post;
				
			}
			$jsonPosts = json_encode($posts);
			return $jsonPosts;
		}
	}

	
	/*View all posts for offline use*/
	public function viewAllPostForOffline($limit){
			global $conn;
			$sql = "SELECT * FROM user_post WHERE visibility = 1 ORDER BY post_date DESC LIMIT $limit";
			$query = $conn->query($sql);
			if($query){
				$posts = array();
				while($post = $query->fetch_assoc()){
					$numLikes = $this->numLike($post['post_id']);
					$numUnLikes = $this->numUnLike($post['post_id']);
					$userInfo = $this->viewUserProfile($post['user_id']);
					$numComment = $this->countComment($post['post_id']);
					$postType = "Post";
					$post['num_likes'] = $numLikes;
					$post['num_unlikes'] = $numUnLikes;
					$post['user_info'] = $userInfo;
					$post['post_type'] = $postType;
					$post['num_comments'] = $numComment;
					$post['category_name'] = $this->getCategoryName($post['category_id']);
					$post['post_text'] = nl2br($post['post_text']);
					$posts[] = $post;
				}
				$jsonPosts = json_encode($posts);
				return $jsonPosts;
			}
		}

	/*Returns postes specified by categories*/
	public function viewPostByCategory($categoryId,$limit){
		global $conn;
		$sql = "SELECT * FROM user_post WHERE visibility = 1 AND category_id = '$categoryId' ORDER BY post_date  DESC LIMIT $limit";
		$query = $conn->query($sql);
		if($query){
			$posts = array();
			while($post = $query->fetch_assoc()){
				$numLikes = $this->numLike($post['post_id']);
				$numUnLikes = $this->numUnLike($post['post_id']);
				$likeStatus = $this->checkLikeStatus($post['post_id']);
				$unLikeStatus = $this->checkUnLikeStatus($post['post_id']);
				$userInfo = $this->viewUserProfile($post['user_id']);
				$numComments = $this->countComment($post['post_id']);
				$postType = "Post";
				$post['num_likes'] = $numLikes;
				$post['num_unlikes'] = $numUnLikes;
				$post['num_comments'] = $numComments;
				$post['like'] = $likeStatus;
				$post['unlike'] = $unLikeStatus;
				$post['user_info'] = $userInfo;
				$post['post_type'] = $postType;
				$post['category_name'] = $this->getCategoryName($post['category_id']);
				$post['post_text'] = nl2br($post['post_text']);
				$posts[] = $post;
			}
			$jsonPosts = json_encode($posts);
			return $jsonPosts;
		}
}

/*Returns postes specified by user id*/
public function viewPostByUserId($userId){
	global $conn;
	$sql = "SELECT * FROM user_post WHERE user_id = '$userId' AND visibility = 1 ORDER BY post_date DESC";
	$query = $conn->query($sql);
	if($query){
		$posts = array();
		while($post = $query->fetch_assoc()){
			$numLikes = $this->numLike($post['post_id']);
			$numUnLikes = $this->numUnLike($post['post_id']);
			$likeStatus = $this->checkLikeStatus($post['post_id']);
			$unLikeStatus = $this->checkUnLikeStatus($post['post_id']);
			$userInfo = $this->viewUserProfile($post['user_id']);
			$numComments = $this->countComment($post['post_id']);
			$postType = "Post";
			$post['num_likes'] = $numLikes;
			$post['num_unlikes'] = $numUnLikes;
			$post['num_comments'] = $numComments;
			$post['like'] = $likeStatus;
			$post['unlike'] = $unLikeStatus;
			$post['user_info'] = $userInfo;
			$post['post_type'] = $postType;
			$post['category_name'] = $this->getCategoryName($post['category_id']);
			$post['post_text'] = nl2br($post['post_text']);
			$posts[] = $post;
		}
		$jsonPosts = json_encode($posts);
		return $jsonPosts;
	}
}

/*Returns postes specified by user id*/
public function viewPostByUserIdForOffline($userId){
	global $conn;
	$sql = "SELECT * FROM user_post WHERE user_id = '$userId' AND visibility = 1 ORDER BY post_date DESC";
	$query = $conn->query($sql);
	if($query){
		$posts = array();
		while($post = $query->fetch_assoc()){
			$numLikes = $this->numLike($post['post_id']);
			$numUnLikes = $this->numUnLike($post['post_id']);
			$userInfo = $this->viewUserProfile($post['user_id']);
			$numComments = $this->countComment($post['post_id']);
			$postType = "Post";
			$post['num_likes'] = $numLikes;
			$post['num_unlikes'] = $numUnLikes;
			$post['num_comments'] = $numComments;
			$post['user_info'] = $userInfo;
			$post['post_type'] = $postType;
			$post['category_name'] = $this->getCategoryName($post['category_id']);
			$post['post_text'] = nl2br($post['post_text']);
			$posts[] = $post;
		}
		$jsonPosts = json_encode($posts);
		return $jsonPosts;
	}
}

	/*Returns postes for offline*/
	public function viewPostByCategoryForOffline($categoryId,$limit){
			global $conn;
			$sql = "SELECT * FROM user_post WHERE category_id = '$categoryId' AND visibility = 1 ORDER BY post_date  DESC LIMIT $limit";
			$query = $conn->query($sql);
			if($query){
				$posts = array();
				while($post = $query->fetch_assoc()){
					$numLikes = $this->numLike($post['post_id']);
					$numUnLikes = $this->numUnLike($post['post_id']);
					$userInfo = $this->viewUserProfile($post['user_id']);
					$numComments = $this->countComment($post['post_id']);
					$postType = "Post";
					$post['num_likes'] = $numLikes;
					$post['num_unlikes'] = $numUnLikes;
					$post['num_comments'] = $numComments;
					$post['user_info'] = $userInfo;
					$post['post_type'] = $postType;
					$post['category_name'] = $this->getCategoryName($post['category_id']);
                    $post['post_text'] = nl2br($post['post_text']);
					$posts[] = $post;
				}
				$jsonPosts = json_encode($posts);
				return $jsonPosts;
			}
	}
	/*Returns a single post*/
	public function viewSinglePost($postId){
			global $conn;
			$sql = "SELECT * FROM user_post WHERE post_id = '$postId' AND visibility = 1 ";
			$query = $conn->query($sql);
			if($query){
				$posts = array();
				while($post = $query->fetch_assoc()){
					$numLikes = $this->numLike($post['post_id']);
					$numUnLikes = $this->numUnLike($post['post_id']);
					$likeStatus = $this->checkLikeStatus($post['post_id']);
					$unLikeStatus = $this->checkUnLikeStatus($post['post_id']);
					$userInfo = $this->viewUserProfile($post['user_id']);
					$numComments = $this->countComment($post['post_id']);

					$postType = "Post";
					$post['num_likes'] = $numLikes;
					$post['num_unlikes'] = $numUnLikes;
					$post['num_comments'] = $numComments;
					$post['like'] = $likeStatus;
					$post['unlike'] = $unLikeStatus;
					$post['user_info'] = $userInfo;
					$post['post_type'] = $postType;
					$post['category_name'] = $this->getCategoryName($post['category_id']);
					$post['post_text'] = nl2br($post['post_text']);
					$posts[] = $post;
					
				}
				$jsonPosts = json_encode($posts);
				return $jsonPosts;
			}
	}

	/*Returns a single post for offline*/
	public function viewSinglePostForOffline($postId){
			global $conn;
			$sql = "SELECT * FROM user_post WHERE post_id = '$postId' AND visibility = 1";
			$query = $conn->query($sql);
			if($query){
				$posts = array();
				while($post = $query->fetch_assoc()){
					$numLikes = $this->numLike($post['post_id']);
					$numUnLikes = $this->numUnLike($post['post_id']);
					$userInfo = $this->viewUserProfile($post['user_id']);
					$numComments = $this->countComment($post['post_id']);

					$postType = "Post";
					$post['num_likes'] = $numLikes;
					$post['num_unlikes'] = $numUnLikes;
					$post['num_comments'] = $numComments;
					$post['user_info'] = $userInfo;
					$post['post_type'] = $postType;
					$post['category_name'] = $this->getCategoryName($post['category_id']);
					$post['post_text'] = nl2br($post['post_text']);

					$posts[] = $post;
				}
				$jsonPosts = json_encode($posts);
				return $jsonPosts;
			}
	}



	/*Shows userprofile for post*/
	public function viewUserProfile($userId){
		global $conn;
		$sql = "SELECT user_id, first_name, last_name, gender, image FROM user WHERE user_id = '$userId'";
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
			return $user;
		}
	}


	/*Likes a post*/
	public function likePost($postId){
		global $conn;
		$userId = $_SESSION['user_id'];
		if(!($this->checkLikeStatus($postId))){
			$sql = "INSERT INTO like_post VALUES(NULL,'$userId','$postId',NULL)";
			$query = $conn->query($sql);
			if($query){
				$this->deleteUnLike($postId);
				return true;
			}else{
				return false;
			}
		}else{
			$this->deleteLike($postId);
		}
	}

	/*Unlikes specified post*/
	public function unLikePost($postId){
		global $conn;
		$userId = $_SESSION['user_id'];
		if(!($this->checkUnLikeStatus($postId))){
			$sql = "INSERT INTO unlike_post VALUES(NULL,'$userId','$postId',NULL)";
			$query = $conn->query($sql);
			if($query){
				$this->deleteLike($postId);
				return true;
			}else{
				return false;
			}
		}else{
			$this->deleteUnLike($postId);
		}
	}

	/*Checks if a post is liked by logged in user and return true if it is liked else returns false*/
	public function checkLikeStatus($postId){
		if(isset($_SESSION['user_id'])){
			$userId = $_SESSION['user_id'];
		}
		global $conn;
		$sql = "SELECT * FROM like_post WHERE post_id = '$postId' AND user_id = '$userId'";
		$query = $conn->query($sql);
		if($query->num_rows == 1){
			return true;
		}else{
			return false;
		}
	}

	/*Checks if a post is unliked by logged in user and return true if it is unliked else returns false*/

	public function checkUnLikeStatus($postId){
		$userId = $_SESSION['user_id'];
		global $conn;
		$sql = "SELECT * FROM unlike_post WHERE post_id = '$postId' AND user_id = '$userId'";
		$query = $conn->query($sql);
		if($query->num_rows == 1){
			return true;
		}else{
			return false;
		}
	}

	/*Removes like from post*/
	public function deleteLike($postId){
		global $conn;
		$userId = $_SESSION['user_id'];
		$sql = "DELETE FROM like_post WHERE post_id='$postId' AND user_id = '$userId' ";
		$query = $conn->query($sql);
		if($query){
			return true;
		}else{
			return false;
		}
	}

	/*Removes unlike from post*/

	public function deleteUnLike($postId){
		global $conn;
		$userId = $_SESSION['user_id'];
		$sql = "DELETE FROM unlike_post WHERE post_id='$postId' AND user_id = '$userId' ";
		$query = $conn->query($sql);
		if($query){
			return true;
		}else{
			return false;
		}
	}

	/*COunts the number of likes for a post*/
	public function numLike($postId){
		global $conn;
		$sql = "SELECT * FROM like_post WHERE post_id = '$postId'";
		$query = $conn->query($sql);
		if ($query) {
			return $query->num_rows;
		}else{
			return false;
		}
	}

	/*Counts number of unlike for a post*/
	public function numUnLike($postId){
		global $conn;
		$sql = "SELECT * FROM unlike_post WHERE post_id = '$postId'";
		$query = $conn->query($sql);
		if ($query) {
			return $query->num_rows;
		}else{
			return false;
		}
	}



	/*Like post comment*/
	public function likePostComment($commentId){
		global $conn;
		$userId = $_SESSION['user_id'];
		if(!($this->checkLikeComment($commentId))){
			$sql = "INSERT INTO like_comment VALUES (NULL,'$userId','$commentId',NULL)";
			$query = $conn->query($sql);
			if($query){
				if($this->checkUnLikeComment($commentId)){
					$this->deleteUnLikeComment($commentId);
				}
				return true;
			}else{
				return false;
			}
		}else{
			$this->deleteLikeComment($commentId);
		}
	}

	/*Unlike Post comment*/
	public function unLikePostComment($commentId){
		global $conn;
		$userId = $_SESSION['user_id'];
		if(!($this->checkUnLikeComment($commentId))){
			$sql = "INSERT INTO unlike_comment VALUES (NULL,'$userId','$commentId',NULL)";
			$query = $conn->query($sql);
			if($query){
				if($this->checkLikeComment($commentId)){
					$this->deleteLikeComment($commentId);
				}
				return true;
			}else{
				return false;
			}
		}else{
			deleteUnLikeComment($commentId);
		}
	}

	/*Checks if comment is liked by the user*/
	public function checkLikeComment($commentId){
		global $conn;
		$userId = $_SESSION['user_id'];
		$sql = "SELECT * FROM like_comment WHERE user_id = '$userId' AND comment_id='$commentId'";
		$query = $conn->query($sql);
		if($query->num_rows==1){
			return true;
		}else{
			return false;
		}
	}

	public function deleteLikeComment($commentId){
		global $conn;
		$userId = $_SESSION['user_id'];
		$sql = "DELETE FROM like_comment WHERE comment_id='$commentId' AND user_id = '$userId' ";
		$query = $conn->query($sql);
		if($query){
			return true;
		}else{
			return false;
		}
	}
	public function deleteUnLikeComment($commentId){
		global $conn;
		$userId = $_SESSION['user_id'];
		$sql = "DELETE FROM unlike_comment WHERE comment_id='$commentId' AND user_id = '$userId' ";
		$query = $conn->query($sql);
		if($query){
			return true;
		}else{
			return false;
		}
	}

	public function numCommentLike($commentId){
		global $conn;
		$sql = "SELECT * FROM like_comment WHERE comment_id = '$commentId'";
		$query = $conn->query($sql);
		return $query->num_rows;
	}
	public function numCommentUnLike($commentId){
		global $conn;
		$sql = "SELECT * FROM unlike_comment WHERE comment_id = '$commentId'";
		$query = $conn->query($sql);
		return $query->num_rows;
	}
	/*Checks if the comment is disliked by the user*/
	public function checkUnLikeComment($commentId){
		global $conn;
		$userId = $_SESSION['user_id'];
		$sql = "SELECT * FROM unlike_comment WHERE user_id = '$userId' AND comment_id='$commentId'";
		$query = $conn->query($sql);
		if($query->num_rows==1){
			return true;
		}else{
			return false;
		}
	}


	public function getNumberOfPosts($userId){
		global $conn;
		$sql = "SELECT * FROM user_post WHERE user_id = '$userId' AND visibility = 1";
		$query = $conn->query($sql);
		return $query->num_rows;
	}

	public function getNumberOfFollow($userId){
		global $conn;
		$sql = "SELECT * FROM follow WHERE from_user_id = '$userId'";
		$query = $conn->query($sql);
		return $query->num_rows;
	}

	public function getNumberOfFollowers($userId){
		global $conn;
		$sql = "SELECT * FROM follow WHERE 	to_user_id  = '$userId'";
		$query = $conn->query($sql);
		return $query->num_rows;
	}

	public function follow($userId){
		$myId = $_SESSION['user_id'];
		global $conn;
		if(!$this->checkFollower($userId) && !$this->checkFollow($userId)){
			$sql = "INSERT INTO follow(from_user_id,to_user_id) VALUES ('$myId','$userId')";
			$query = $conn->query($sql);
			if($query){
				return true;
			}else{
				return false;
			}
		}else if($this->checkFollower($userId)){
			$sql = "UPDATE follow SET follow_back_time='now()' WHERE from_user_id='$myId' AND to_user_id='$userId'";
			$query = $conn->query($sql);
			if($query){
				return true;
			}else{
				return false;
			}
		}
	}

	public function checkFollow($userId){
		global $conn;
		$myId = $_SESSION['user_id'];
		$sql = "SELECT * FROM follow WHERE 	from_user_id  = '$myId' AND to_user_id='$userId'";
		$query = $conn->query($sql);
		if($query->num_rows>0){
			return true;
		}else{
			return false;
		}
	}

	
	public function checkFollower($userId){
		global $conn;
		$myId = $_SESSION['user_id'];
		$sql = "SELECT * FROM follow WHERE 	from_user_id  = '$userId' AND to_user_id='$myId'";
		$query = $conn->query($sql);
		if($query->num_rows>0){
			return true;
		}else{
			return false;
		}
	}

}
?>