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

			.err{
				padding:10px;
				border-radius:5px;
				display: none;
			}
			.register-link,.login-link{
				text-align: center;
				text-decoration: underline;
				padding: 5px;
			}
			#registerForm{
				margin-top:80px;	
			}
		</style>
	</head>
	<body>
		<nav class="navbar navbar-inverse">
		  <div class="container">
		    <div class="navbar-header">
		      <a class="navbar-brand" href="index.php">LE HAGERE</a>
		    </div>
		  </div>
		</nav>
		<div class="container">
			<div class="container">
				<div class="col-md-3"></div>
				<form class="form col-md-6" id="registerForm" method="POST" action="#">
					<p class="register-info err hid btn-danger"></p>

				  <div class="form-group">
				    <label for="firstName">First name</label>
				    <input type="text" name="firstName" class="form-control" id="firstName" placeholder="First name">
				  </div>
				  <div class="form-group">
				    <label for="lastName">Last name</label>
				    <input type="text" name="lastName" class="form-control" id="lastName" placeholder="Last name">
				  </div>
				  <div class="form-group md-3">
				  	<label for="gender">Gender</label>
				  	<select class="form-control" name="gender">
					    <option value="0">Select Gender</option>
						<option value="Male">Male</option>
						<option value="Female">Female</option>
					</select>
				  </div>
				  <div class="form-group md-3">
				    <label for="birthDate">Birth Day</label>
				    <input type="date" name="birthDate" class="form-control" id="birthDate">
				  </div>
				  <div class="form-group md-4">
				    <label for="email">Email address</label>
				    <input type="email" id="email" class="form-control" name="userEmail" aria-describedby="emailHelp" placeholder="Enter email">
				  </div>
				  <div class="form-group">
				    <label for="password">Password</label>
				    <input type="password" name="userPassword" class="form-control" id="password" placeholder="Password">
				  </div>
				  <input type="submit" value="Register" class="btn btn-primary">

					<p class="login-link"><a href="index.php">Login Here</a></p>
				</form>
			</div>
		</div>
		<script src="js/jquery.js"></script>
		<script src="js/jquerycookie.js"></script>
		<script src="js/main.js"></script>
		<script src="js/control.js"></script>
		<script>
			/*$("document").ready(function(){
				if($.cookie('loginStatus')){
					window.location = BASE_URL+"home.php";
				}
			})*/
		</script>
	</body>
</html>