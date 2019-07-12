<?php
session_start();
include("database.php");
include("class/question.class.php");
if($_SERVER['REQUEST_METHOD'] == "POST"){
	
	$userQuestion = new Question;//Initialize post object
	
	if($_POST['type'] == "insertQuestion"){
		insertQuestion();
	}else if($_POST['type']=="likeQuestion"){
			$questionId = $conn->escape_string($_POST['questionId']);
			return $userQuestion->likeQuestion($questionId);
	}else if($_POST['type'] == "unLikeQuestion"){
			$questionId = $conn->escape_string($_POST['questionId']);
			return $userQuestion->unLikeQuestion($questionId);
	}else if($_POST['type'] == "questionAnswer"){
			$questionId = $conn->escape_string($_POST['questionId']);
			$commentText = $conn->escape_string($_POST['answerText']);
			echo $userQuestion->insertAnswer($questionId,$commentText);
	}else if($_POST['type'] == "likeAnswer"){
			$commentId = $conn->escape_string($_POST['answerId']);
			$userQuestion->likeAnswer($commentId);
	}else if($_POST['type'] == "unLikeAnswer"){
			$commentId = $conn->escape_string($_POST['answerId']);
			$userQuestion->unLikeAnswer($commentId);
	}
}

function insertQuestion(){
	if(!empty($_POST['questionCategory']) && ($_POST['questionCategory']!=0) && !empty($_POST['questionTitle']) && !empty($_POST['questionText'])){

			global $conn;
			$questionCategory = $conn->escape_string($_POST['questionCategory']);
			$postTitle = $conn->escape_string($_POST['questionTitle']);
			$postText = $conn->escape_string($_POST['questionText']);

			$userQuestion = new Question;
			$userQuestion->setQuestionCategory($questionCategory);
			$userQuestion->setQuestionTitle($postTitle);
			$userQuestion->setQuestionText($postText);
			$userQuestion->setVisiblity();
			$question = $userQuestion->insertQuestion();

			if($question){
				header("location: http://localhost/ethiopianbet/question.html");
			}else{
				echo "Not posted";
			}
		}
}

?>