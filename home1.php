<?php
session_start();
if(isset($_SESSION['user_id'])){
	header("location: home.php");
}
?>
<!DOCTYPE html>
<html>
	<head>
		<title>Lehagere.com | user profile</title>
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
		<link rel="stylesheet" href="style/main.css">

		<!-- jQuery library -->
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

		<!-- Latest compiled JavaScript -->
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
		<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css" integrity="sha384-UHRtZLI+pbxtHCWp1t77Bi1L4ZtiqrqD80Kn4Z8NTSRyMA2Fd33n5dQ8lWUE00s/" crossorigin="anonymous">
		<style>
			.profile-image{
				width:100%;
				border-radius: 50%;
				min-height:50px;
			}
			.header{
				margin-top:10px;
				border-bottom: 2px solid orange;
    			padding: 8px;
			}
			.user-name{
				font-size: 1em;
				font-weight:700;
			}
			
			.user-info-container>ul{
				margin: 0px;
				padding:0px;
			}
			.user-info-container>ul>li{
				list-style-type: none;
			}
			.status{
				text-align: center;
				font-size: 1em;
				margin: 10px;
				padding: 5px;
			}
			.user-act-container>div>div{
				text-align: center;
			}
			.tab{
				background-color: #3b5998;
				border-right: 5px solid white;
				color: white;
				padding:10px;
				text-align:center;
			}
			.tab:hover{
				cursor:not-allowed;
				color:white;
			}


			.posts-container{
				margin-top:50px;
			}
			.post{
				padding: 10px;
				font-size: 1em;
			}
			.postTag{

			}
			.read-more {
				padding: 5px;
				border-radius: 5px;
				margin: 2px;
				cursor: pointer;
				text-decoration: none;
				width: 100px;
				background-color: #46b8da;
				border-color: #46b8da;
				color: white;
				white-space: nowrap;
				font-size: 0.8em;
			}
			.title{
				padding:10px;
				text-align: center;
				font-weight: 700;
				font-size: 20px;
				margin: 0px;
			}
			
			.posts-container img{
				width:95%;
				margin:5px;
			}
			.posts-container .buttons{
				text-align: center;
			}
			
			.numLike, .numDislike, .numComment{
				margin-left: 10px;
			}
			.liked,.unLiked{
				background-color: lightseagreen;
				cursor:pointer;
				color:white;
			}

			.holder{
				width: 100%;
				background-color: lightseagreen;
				height: 500px;
				margin-top: 15px;
			}



			.tags-container{
				margin-top:20px;
				border-right: 2px solid lightgray;
				margin-top: 40px;
				border-radius: 15px;
			}
			.tags{
				text-align:center;
				padding:5px;
				margin:5px;
			}
			.tagBtn{
				margin:4px;
			}
			.selected{
				background-color:#3b5998;
				color:white !important;
			}
			#commentForOffline{
				cursor:pointer;
			}
		</style>
	</head>
	<body>
		<!---------------NAV BAR------------->
		<nav class="navbar navbar-inverse">
		  <div class="container">
		    <div class="navbar-header col-sm-4  col-xs-10 col-md-5 col-lg-5">
		      <a class="navbar-brand" href="home.php">LE HAGERE</a>
		    </div>
		    <button class="nav-icon  navbar-toggler navbar-right" type="button" data-toggle="collapse" data-target="#navbar-collapse" aria-controls="navbar-collapse" aria-expanded="false" aria-label="Toggle navigation">
					<span class="navbar-toggler-icon"><i class="fas fa-bars"></i></span>
			</button>
		    <div class="col-xs-12 col-sm-6 col-md-5 col-lg-5 ">
			    <ul class="nav collapse navbar-nav navRight navbar-right" id="navbar-collapse">
			      <li class="active"><a href="home1.php">Home</a></li>
			      <li><a href="index.php">Sign In</a></li>
			    </ul>
		    </div>
		  </div>
		</nav>

		<div class="container">
			<div class="row">
				<!-- Left container-->
				<div class="col-md-3 col-sm-3 col-lg-3 col-xs-12">
					<div class="tags-container">
						<h2 class="tags">Tags</h2>
						<div id="topicContainer">
							<button class="btn btn-sm btn-outline-secondary tagBtn btn-topic" id="topics" data-topicid="0">All</button>
						</div>
					</div>
				</div>
				<!--Middle Container-->
				<div class="col-md-6 col-sm-6 col-lg-6">
						<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
							<div class="row">
								<br>
								<div class="alert alert-warning">
									<strong>Note!</strong> You have to <a href="index.php">login</a> to access some futures of the website.
								</div>
							</div>
							<!--Posts container-->
							<div class="row">
								<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 " id="postContainer">
									
								</div>
							</div>
						</div>
				</div>

				<!-- Right Container -->
				<div class="col-md-3 col-lg-3 col-sm-3 hidden-xs">
					<div class="holder">
						
					</div>
				</div>
			</div>
		</div>

		
		<script src="js/main.js"></script>
		<script src="js/control.js"></script>
		<script>
			$("document").ready(function(){

				getCategories();//Gets topics list
				getAllPostsForOffline(12);
				$("body").on("click","#topics",function(){
					$("button").removeClass("selected");
					var topicId = $(this).data("topicid");
					$(this).addClass("selected");
					if(topicId==0){
						getAllPostsForOffline(10);
					}
					getPostsByCategoryForOffline(topicId,10);
				})
			})
		</script>
		
	</body>
</html>