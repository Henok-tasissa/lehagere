<?php
include("./database.php");
//session_start();
class Question{
	private $questionCategory;
	private $questionTitle;
	private $questionText;
	private $publicityMode;
	private $visiblity;

	public function setQuestionCategory($questionCategory){
		$this->questionCategory = $questionCategory;
	}
	public function setQuestionTitle($questionTitle){
		$this->questionTitle = $questionTitle;
	}
	public function setQuestionText($questionText){
		$this->questionText = $questionText;
	}
	public function setPublicityMode($publicityMode = 1){
		$this->publicityMode = $publicityMode;
	}
	public function setVisiblity($visiblity = 1){
		$this->visiblity = $visiblity;
	}



	public function getQuestionCategory(){
		return $this->questionCategory;
	}
	public function getQuestionTitle(){
		return $this->questionTitle;
	}
	public function getQuestionText(){
		return $this->questionText;
	}
	public function getPublicityMode(){
		return $this->publicityMode;
	}
	public function getVisiblity(){
		return $this->visiblity;
	}

	//Inserts a question
	public function insertQuestion(){
		global $conn;
		$categoryId = $this->getQuestionCategory();
		$userId = $_SESSION['user_id'];
		$questionTitle = $this->getQuestionTitle();
		$questionText = $this->getQuestionText();
		$visiblity = $this->getVisiblity();

		if(!empty($categoryId) && !empty($userId) && !empty($questionTitle) && !empty($questionText)){
			$sql = "INSERT INTO question VALUES (NULL,'$userId','$categoryId','$questionTitle','$questionText',0,'$visiblity',NULL,NULL)";
			$query=$conn->query($sql);
			if($query){
				return true;
			}else{
				return false;
			}
		}else{
			echo "NOT empty";
		}
		
	}

	//Updates a question
	public function updateQuestion($questionId){
		global $conn;
		$userId = $_SESSION['user_id'];
		$categoryId = $this->getQuestionCategory();
		$questionTitle = $this->getQuestionTitle();
		$questionText = $this->getQuestionText();
		$visiblity = $this->getVisiblity();
		$sql = "UPDATE question SET category_id = '$categoryId', question_title='$questionTitle', question_text = '$questionText',visiblity = '$visiblity', question_update_date = NULL WHERE question_id = '$questionId' AND user_id= '$userId'";
		$query = $conn->query($sql);
		if($query){
			return true;
		}else{
			return false;
		}
	}

	//Deletes question
	public function deleteQuestion($questionId){
		global $conn;
		$userId = $_SESSION['user_id'];
		$visiblity = 0;
		$sql = "UPDATE question
				SET visiblity = '$visiblity', question_update_date = NULL 
				WHERE question_id = '$questionId' AND user_id= '$userId'";
		$query = $conn->query($sql);
		if($query){
			return true;
		}else{
			return false;
		}
	}



	/*------------------View Questions--------------*/
	public function viewAllQuestion($limit){
		global $conn;
		$sql = "SELECT * FROM question ORDER BY question_date DESC LIMIT $limit";
		$query = $conn->query($sql);
		if($query){
			$questions = array();
			while($question = $query->fetch_assoc()){
				$numLikes = $this->numLike($question['question_id']);
				$numUnLikes = $this->numUnLike($question['question_id']);
				$likeStatus = $this->checkLikeStatus($question['question_id']);
				$unLikeStatus = $this->checkUnLikeStatus($question['question_id']);
				$userInfo = $this->viewUserProfile($question['user_id']);
				$numAnswer = $this->countAnswer($question['question_id']);
				$postType = "Question";
				$question['num_likes'] = $numLikes;
				$question['num_unlikes'] = $numUnLikes;
				$question['like'] = $likeStatus;
				$question['unlike'] = $unLikeStatus;
				$question['user_info'] = $userInfo;
				$question['post_type'] = $postType;
				$question['num_answer'] = $numAnswer;

				$questions[] = $question;
			}
			$jsonQuestions = json_encode($questions);
			return $jsonQuestions;
		}
	}

	public function viewQuestionByCategory($categoryId,$limit){
		global $conn;
		$sql = "SELECT * FROM question WHERE category_id = '$categoryId' ORDER BY question_date DESC LIMIT $limit";
		$query = $conn->query($sql);
		if($query){
			$questions = array();
			while($question = $query->fetch_assoc()){
				$numLikes = $this->numLike($question['question_id']);
				$numUnLikes = $this->numUnLike($question['question_id']);
				$likeStatus = $this->checkLikeStatus($question['question_id']);
				$unLikeStatus = $this->checkUnLikeStatus($question['question_id']);
				$userInfo = $this->viewUserProfile($question['user_id']);
				$numAnswer = $this->countAnswer($question['question_id']);
				$postType = "Question";
				$question['num_likes'] = $numLikes;
				$question['num_unlikes'] = $numUnLikes;
				$question['like'] = $likeStatus;
				$question['unlike'] = $unLikeStatus;
				$question['user_info'] = $userInfo;
				$question['post_type'] = $postType;
				$question['num_answer'] = $numAnswer;

				$questions[] = $question;
			}
			$jsonQuestions = json_encode($questions);
			return $jsonQuestions;
		}
	}

	//views single question
	public function viewSingleQuestion($questionId){
		global $conn;
		$sql = "SELECT * FROM question WHERE question_id = '$questionId' ORDER BY question_date DESC";
		$query = $conn->query($sql);
		if($query){
			$questions = array();
			while($question = $query->fetch_assoc()){
				$numLikes = $this->numLike($question['question_id']);
				$numUnLikes = $this->numUnLike($question['question_id']);
				$likeStatus = $this->checkLikeStatus($question['question_id']);
				$unLikeStatus = $this->checkUnLikeStatus($question['question_id']);
				$userInfo = $this->viewUserProfile($question['user_id']);
				$numAnswer = $this->countAnswer($question['question_id']);
				$postType = "Question";
				$question['num_likes'] = $numLikes;
				$question['num_unlikes'] = $numUnLikes;
				$question['like'] = $likeStatus;
				$question['unlike'] = $unLikeStatus;
				$question['user_info'] = $userInfo;
				$question['post_type'] = $postType;
				$question['num_answer'] = $numAnswer;

				$questions[] = $question;
			}
			$jsonQuestions = json_encode($questions);
			return $jsonQuestions;
		}
	}	

	//Adds answer
	public function insertAnswer($questionId,$answerText){
		global $conn;
		$userId = $_SESSION['user_id'];
		$visiblity = 1;
		$answerText = $conn->escape_String($answerText);
		$sql = "INSERT INTO answer VALUES(NULL,'$userId','$questionId','$answerText','$visiblity',NULL)";
		$query = $conn->query($sql);
		if($query){
			return true;
		}else{
			return false;
		}
	}

	/*View Answer*/
	public function viewAnswers($questionId){
		global $conn;
		$answers = array();
		$sql = "SELECT * FROM answer WHERE question_id='$questionId' ORDER BY answer_date  DESC ";
		$query = $conn->query($sql);
		$numAnswer = $this->numAnswer($questionId);
		while($answer = $query->fetch_assoc()){
			$userInfo = $this->viewUserProfile($answer['user_id']);
			$answer['user_info'] = $userInfo;
			$answer['num_answer'] = $numAnswer;
			$answer['num_like'] = $this->numAnswerLike($answer['answer_id']);
			$answer['num_unlike'] = $this->numAnswerUnLike($answer['answer_id']);
			$answer['like'] = $this->checkLikeAnswer($answer['answer_id']);
			$answer['unlike'] = $this->checkUnLikeAnswer($answer['answer_id']);
			
			$answers[] = $answer;
		}
		$jsonAnswers = json_encode($answers);
		return $jsonAnswers;
	}

	public function viewUserProfile($userId){
		global $conn;
		$sql = "SELECT user_id, first_name, last_name, gender, image_id FROM user WHERE user_id = '$userId'";
		$query= $conn->query($sql);
		if($query){
			$user = array();
			while($userData = $query->fetch_assoc()){
				$user[] = $userData;
			}
			$jsonUser = json_encode($user);
			return $user;
		}
	}

	//Counts the number of answer per question
	public function countAnswer($postId){
			global $conn;
			$sql = "SELECT * FROM answer WHERE question_id='$postId'";
			$query = $conn->query($sql);
			return $query->num_rows;
		}
	//RETURNS THE CATEGORIES
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
	//Like Question
	public function likeQuestion($questionId){
		global $conn;
		$userId = $_SESSION['user_id'];
		if(!($this->checkLikeStatus($questionId))){
			$sql = "INSERT INTO like_question VALUES(NULL,'$userId','$questionId',NULL)";
			$query = $conn->query($sql);
			if($query){
				$this->deleteUnLike($questionId);
				return true;
			}else{
				return false;
			}
		}else{
			$this->deleteLike($questionId);
		}
	}

	//Unlike Question
	public function unLikeQuestion($questionId){
		global $conn;
		$userId = $_SESSION['user_id'];
		if(!($this->checkUnLikeStatus($questionId))){
			$sql = "INSERT INTO unlike_question VALUES(NULL,'$userId','$questionId',NULL)";
			$query = $conn->query($sql);
			if($query){
				$this->deleteLike($questionId);
				return true;
			}else{
				return false;
			}
		}else{
			$this->deleteUnLike($questionId);
		}
	}
	public function checkLikeStatus($questionId){
		$userId = $_SESSION['user_id'];
		global $conn;
		$sql = "SELECT * FROM like_question WHERE question_id = '$questionId' AND user_id = '$userId'";
		$query = $conn->query($sql);
		if($query->num_rows == 1){
			return true;
		}else{
			return false;
		}
	}

	/*Checks if a post is unliked by logged in user and return true if it is unliked else returns false*/

	public function checkUnLikeStatus($questionId){
		$userId = $_SESSION['user_id'];
		global $conn;
		$sql = "SELECT * FROM unlike_question WHERE question_id = '$questionId' AND user_id = '$userId'";
		$query = $conn->query($sql);
		if($query->num_rows == 1){
			return true;
		}else{
			return false;
		}
	}

	public function deleteLike($questionId){
		global $conn;
		$userId = $_SESSION['user_id'];
		$sql = "DELETE FROM like_question WHERE question_id='$questionId' AND user_id = '$userId' ";
		$query = $conn->query($sql);
		if($query){
			return true;
		}else{
			return false;
		}
	}

	/*Removes unlike from question*/

	public function deleteUnLike($questionId){
		global $conn;
		$userId = $_SESSION['user_id'];
		$sql = "DELETE FROM unlike_question WHERE question_id='$questionId' AND user_id = '$userId' ";
		$query = $conn->query($sql);
		if($query){
			return true;
		}else{
			return false;
		}
	}

	/*COunts the number of likes for an answer*/
	public function numLike($questionId){
		global $conn;
		$sql = "SELECT * FROM like_question WHERE question_id = '$questionId'";
		$query = $conn->query($sql);
		if ($query) {
			return $query->num_rows;
		}else{
			return false;
		}
	}

	public function numAnswer($questionId){
		global $conn;
		$sql = "SELECT * FROM answer WHERE question_id = '$questionId'";
		$query = $conn->query($sql);
		if ($query) {
			return $query->num_rows;
		}else{
			return false;
		}
	}
	/*Counts number of unlike for an answer*/
	public function numUnLike($questionId){
		global $conn;
		$sql = "SELECT * FROM unlike_question WHERE question_id = '$questionId'";
		$query = $conn->query($sql);
		if ($query) {
			return $query->num_rows;
		}else{
			return false;
		}
	}


	/*Like post comment*/
	public function likeAnswer($answerId){
		global $conn;
		$userId = $_SESSION['user_id'];
		if(!($this->checkLikeAnswer($answerId))){
			$sql = "INSERT INTO like_answer VALUES (NULL,'$userId','$answerId',NULL)";
			$query = $conn->query($sql);
			if($query){
				if($this->checkUnLikeAnswer($answerId)){
					$this->deleteUnLikeAnswer($answerId);
				}
				return true;
			}else{
				return false;
			}
		}else{
			$this->deleteLikeAnswer($answerId);
		}
	}

	/*Unlike Post comment*/
	public function unLikeAnswer($answerId){
		global $conn;
		$userId = $_SESSION['user_id'];
		if(!($this->checkUnLikeAnswer($answerId))){
			$sql = "INSERT INTO unlike_answer VALUES (NULL,'$userId','$answerId',NULL)";
			$query = $conn->query($sql);
			if($query){
				if($this->checkLikeAnswer($answerId)){
					$this->deleteLikeAnswer($answerId);
				}
				return true;
			}else{
				return false;
			}
		}else{
			deleteUnLikeAnswer($answerId);
		}
	}

	/*Checks if comment is liked by the user*/
	public function checkLikeAnswer($answerId){
		global $conn;
		$userId = $_SESSION['user_id'];
		$sql = "SELECT * FROM like_answer WHERE user_id = '$userId' AND answer_id='$answerId'";
		$query = $conn->query($sql);
		if($query->num_rows==1){
			return true;
		}else{
			return false;
		}
	}

	public function deleteLikeAnswer($answerId){
		global $conn;
		$userId = $_SESSION['user_id'];
		$sql = "DELETE FROM like_answer WHERE answer_id='$answerId' AND user_id = '$userId' ";
		$query = $conn->query($sql);
		if($query){
			return true;
		}else{
			return false;
		}
	}
	public function deleteUnLikeAnswer($answerId){
		global $conn;
		$userId = $_SESSION['user_id'];
		$sql = "DELETE FROM unlike_answer WHERE answer_id='$answerId' AND user_id = '$userId' ";
		$query = $conn->query($sql);
		if($query){
			return true;
		}else{
			return false;
		}
	}

	public function numAnswerLike($answerId){
		global $conn;
		$sql = "SELECT * FROM like_answer WHERE answer_id = '$answerId'";
		$query = $conn->query($sql);
		return $query->num_rows;
	}
	public function numAnswerUnLike($answerId){
		global $conn;
		$sql = "SELECT * FROM unlike_answer WHERE answer_id = '$answerId'";
		$query = $conn->query($sql);
		return $query->num_rows;
	}
	/*Checks if the comment is disliked by the user*/
	public function checkUnLikeAnswer($answerId){
		global $conn;
		$userId = $_SESSION['user_id'];
		$sql = "SELECT * FROM unlike_answer WHERE user_id = '$userId' AND answer_id='$answerId'";
		$query = $conn->query($sql);
		if($query->num_rows==1){
			return true;
		}else{
			return false;
		}
	}

}

//$quest = new Question;
/*$quest->setQuestionCategory(2);
$quest->setVisiblity();
$quest->setQuestionTitle("Sample title update");
$quest->setQuestionText("SSSSSSSSSSSSSSSS");
*/
//echo $quest->updateQuestion(2); Test update
//echo $quest->deletePost(2); Test delete

//$quest->insertAnswer(2,"This is an answer!"); Test answer
//echo $quest->countAnswer(2); Number of answers

//echo $quest->viewCategories(); Test for view categories

//echo $quest->likeQuestion(2); test question like
//echo $quest->unLikeQuestion(2); test question unlike
//echo $quest->numLike(2); 
//echo $quest->viewAllQuestion(5);
//echo "<pre>".$quest->viewQuestionByCategory(2,5);
//echo "<pre>".$quest->viewSingleQuestion(4);
?>