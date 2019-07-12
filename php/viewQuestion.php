<?php
include("database.php");
include("class/question.class.php");
include("class/user.class.php");
header('Content-Type: application/json');

if($_SERVER['REQUEST_METHOD'] == "GET"){
	$userQuestion = new Question;//Initialize object
	$user = new User;

	if(isset($_GET['type'])){
		if($_GET['type'] == "getCategories"){
			echo $userQuestion->viewCategories();
		}else if($_GET['type'] == "viewAllQuestion"){
			echo $userQuestion->viewAllQuestion($_GET['requestLimit']);
		}else if($_GET['type'] == "viewQuestionByCategory"){
			echo $userQuestion->viewQuestionByCategory($_GET['categoryId'],$_GET['requestLimit']);
		}else if($_GET['type'] == "viewSingleQuestion"){
			echo $userQuestion->viewSingleQuestion($_GET['questionId']);
		}else if($_GET['type']== "viewAnswers"){
			$questionId = $conn->escape_string($_GET['questionId']);
			echo $userQuestion->viewAnswers($questionId);
		}else if($_GET['type'] == "getUserSession"){
			echo $_SESSION['user_id'];
		}else if($_GET['type'] == "userProfileInfo"){
			echo $user->viewProfile();
		}
	}else{
		echo "Error";
	}
}

?>