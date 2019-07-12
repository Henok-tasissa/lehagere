<?php
session_start();
if(isset($_SESSION['user_id'])){
	header("location: home.php");
}
?>
<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title>LE HAGERE</title>
	    <meta content="text/html; charset=utf-8" http-equiv="Content-Type" />
	    <meta name="description" content="The first and the largest Ethiopian community on the internet." />
	    <meta name="keywords" content="Africa, Diaspora, Ethiopia, Ethiopian Art, Ethiopian beauty, Ethiopian community, Ethiopian culture, Ethiopian Food, Ethiopian History, Ethiopian Ladys, Ethiopian language, Ethiopian life, Ethiopian Mens, Ethiopian Phylosophy, Ethiopian Politics, Ethiopian Religion, Ethiopian science, Ethiopian Society, Ethiopian Sport, Ethiopian student, Ethiopian Technology, Habesha, Health" />
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<!-- Latest compiled and minified CSS -->
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">

		<!-- jQuery library -->
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

		<!-- Latest compiled JavaScript -->
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
		<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.13/css/all.css" integrity="sha384-DNOHZ68U8hZfKXOrtjWvjxusGo9WQnrNx2sqG0tfsghAvtVlRW3tvkXWZh58N9jp" crossorigin="anonymous">
		<link rel="stylesheet" href="style/main.css">
		<style>
		
			.form{
				margin: 100px auto;
				width:60%;
			}
			.err{
				padding:10px;
				border-radius:5px;
				display: none;
			}
			.register-link,.login-link{
				text-align: center;
				padding: 5px;
			}
			.reg{
				padding:5px;
				border-radius: 5px;
			}
			.terms{
				font-size: 10px;
			}
		</style>
	</head>
	<body>
		<nav class="navbar navbar-inverse">
		  <div class="container">
		    <div class="navbar-header">
		      <a class="navbar-brand" href="#">LE HAGERE</a>
		    </div>
		  </div>
		</nav>
		<div class="container">
			<div class="row">
				<div class="col-md-3"></div>
				<form class="form col-md-6" id="loginForm" method="POST" action="php/login.php">
				  <p class="login-info err hid btn-danger"></p>
				  <?php
				  	if(isset($_GET['reg']) && $_GET['reg']=="true"){
				  		echo '<p class="login-info reg btn-success">Successfully Registered! Please login</p>';
				  	}
				  ?>
				  <div class="form-group md-4">
				    <label for="exampleInputEmail1">Email address</label>
				    <input type="email" class="form-control" name="email" aria-describedby="emailHelp" placeholder="Enter email">
				    <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small>
				  </div>
				  <div class="form-group">
				    <label for="password">Password</label>
				    <input type="password" name="password" class="form-control" id="password" placeholder="Password">
				  </div>
				  <p class="terms">By using this website, you agree with our <a href="termsandagreements.php">terms and agreements.</a></p>
				  <input type="submit" value="Login" class="btn btn-primary">
				  <p class="register-link"><a href="register.php" id="registerHere">Register Here</a> or click <a href="home1.php">here</a> to access without logging in.</p>
				</form>
			</div>
		</div>
		<script src="js/jquery.js"></script>
		<script src="js/jquerycookie.js"></script>
		<script src="js/main.js"></script>
		<script src="js/control.js"></script>
		<script>
			$("document").ready(function(){
				/*if ($.cookie('token') && $.cookie('userId')){
				 	var cookieUserId = $.cookie("userId");
					var cookieToken = $.cookie("token");
					loginWithToken(cookieUserId,cookieToken);
				}*//*
				if($.cookie('loginStatus')){
					window.location = BASE_URL+"home.html";
				}*/
			})
			
		</script>
	</body>
</html>