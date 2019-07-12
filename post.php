<?php
session_start();
if(!isset($_SESSION['user_id'])){
	header("location: index.php");
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
		<link rel="stylesheet" href="style/jquerytext.css">
		<!-- jQuery library -->
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

		<!-- Latest compiled JavaScript -->
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
		<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.13/css/all.css" integrity="sha384-DNOHZ68U8hZfKXOrtjWvjxusGo9WQnrNx2sqG0tfsghAvtVlRW3tvkXWZh58N9jp" crossorigin="anonymous">		
		<script src="js/jquery-text.min.js"></script>
		<link rel="stylesheet" href="style/main.css">
		
		<script src="js/nicEdit.js" type="text/javascript"></script>
		<script type="text/javascript">bkLib.onDomLoaded(nicEditors.allTextAreas);</script>
	
		<style>
			
			/* Editor */
			#postText{
				min-height: 300px;
				width:100%;
				margin:5px auto;
				resize:vertical;
				padding: 5px;
				font-size: 15px;
			}
			#post{
				text-align: center;
				padding: 5px 20px;
				margin-left: 25px;
			}

			.postBtn{
				width: 94%;
				margin: 5px auto;
				display: inherit;
			}
			.posted{
				display:none;
				margin:10px 0px;
				margin-left: 20px;
			}
			.err{
				padding: 9px;
				display: none;
				margin-top:10px;
				border-radius: 6px;
			}
			.textarea-container>div{
				width:100% !important;
			}

			.selected{
				background-color:#3b5998;
				color:white !important;
			}
			
			.topics-header{
				text-align: center;
				margin-top: 20px;
				font-size: 1.55em;
				font-weight: 700;
			}
			#postTitle{
				padding:5px;
				margin:10px 0px;
				text-align:center;
				font-weight:700;
			}
			.holder{
				width: 100%;
				background-color: lightseagreen;
				height: 500px;
				margin-top: 15px;
			}
		</style>
	</head>
	<body>
		<!---------------NAV BAR------------->
		<nav class="navbar navbar-inverse">
		  <div class="container">
		    <div class="navbar-header col-xs-10 col-md-5 col-lg-5">
		      <a class="navbar-brand" href="home.php">LE HAGERE</a>
		    </div>
		    <button class="nav-icon  navbar-toggler navbar-right" type="button" data-toggle="collapse" data-target="#navbar-collapse" aria-controls="navbar-collapse" aria-expanded="false" aria-label="Toggle navigation">
					<span class="navbar-toggler-icon"><i class="fas fa-bars"></i></span>
			</button>
		    <div class="col-xs-12 col-md-5 col-lg-5 ">
			    <ul class="nav collapse navbar-nav navRight navbar-right" id="navbar-collapse">
			      <li><a href="home.php">Home</a></li>
			      <li class="active"><a href="post.php">Post</a></li>
				  <li><a href="myprofile.php">Profile</a></li>
			      <li><a href="logout.php">Log out</a></li>
			      <!--<li><a href="#">Page 3</a></li> -->
			    </ul>
		    </div>
		  </div>
		</nav>

		<div class="container">
			<div class="row">
				<!-- Left container-->
				<div class="col-md-3 col-sm-3 col-lg-3 hidden-xs">
					<div class="">
						
					</div>
				</div>
				<!--Middle Container-->
				<div class="col-md-6 col-sm-6 col-lg-6">
						<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
							<div class="row">
								<form action="#" class="col-xs-12" id="postForm" method="post">
									<div class="row">
										<div class="col-xs-12 err alert-danger">
											Make sure to select topic, title and post.
										</div>
									</div>
									<div class="row">
										<div class="row">
											<p class="topics-header">Topics</p>
										</div>
										<div class="row" id="topicContainer">
										
										</div>
										<div class="textarea-container">
											<input class="col-xs-12" type="hidden" name="category" id="topicId">
											<input class="col-xs-12" type="text" name="postTitle" placeholder="Enter title for your post." id="postTitle">
											<textarea name="postText" id="postText" class="row form-control col-sm-12 coml-md-12 col-lg-12"></textarea>
										</div>
									</div>
									<div class="row">
											<div class="btn btn-success posted">Posted Successfully</div>
											<div class="row">
												<div class="col-sx-4"></div>
												<button class="col-sx-4 btn btn-default postBtn" type="submit">Post</button>
											</div>
									</div>
									<div class="row">

									</div>
								</form>
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
		<script src="js/jquery.js"></script>
		<script src="js/jquerycookie.js"></script>
		<script src="js/main.js"></script>
		<script src="js/control.js"></script>
		<script>
			$("document").ready(function(){
				getCategories();//Gets topics list

				$("body").on("click","#topics",function(){
					var topicId = $(this).data("topicid");
					if($('button').hasClass("selected")){
						$('button').removeClass("selected");
					}

					if($(this).hasClass("selected")){
						$(this).removeClass("selected");
					}else{
						$(this).addClass("selected");
					}
					$("input[name='category']").val(topicId);
					return false;
				})
			})


		</script>
	</body>
</html>