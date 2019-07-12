<?php
include_once("./php/database.php");
session_start();
if(!isset($_SESSION['user_id'])){
	if(isset($_GET['pid'])){
		$url = "viewpost1.php?pid=".$_GET['pid'];
		header("location: $url");
	}else{
		$url = "home.php";
		header("location: $url");
	}
}else{
	if(!isset($_GET['pid'])){
		$url = "home1.php";
		header("location: $url");
	}
}
?>
<!DOCTYPE html>
<html>
	<head>
	    <meta content="text/html; charset=utf-8" http-equiv="Content-Type" />
		<?php
			if(isset($_GET['pid'])){
				$postId = $_GET['pid'];
				global $conn;
				$sql = "SELECT post_title,post_text FROM user_post WHERE post_id = '$postId' AND visibility = 1 ";
				$query = $conn->query($sql);
				if($query){
					$posts = array();
					while($post = $query->fetch_assoc()){
						echo "<title>".strip_tags($post['post_title'])."</title>";
						echo '<meta name="description" content="'.substr(strip_tags($post['post_text']),0,150).'..." />';
					}
				}
			}
		?>
	    <meta name="keywords" content="Africa, Ethiopia, Ethiopian Art, Ethiopian beauty, Ethiopian community, Ethiopian culture, Ethiopian Food, Ethiopian History, Ethiopian Ladys, Ethiopian language, Ethiopian life, Ethiopian Mens, Ethiopian Phylosophy, Ethiopian Politics, Ethiopian Religion, Ethiopian science, Ethiopian Society, Ethiopian Sport, Ethiopian student, Ethiopian Technology, Habesha, Health" />
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<!-- Latest compiled and minified CSS -->
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
		<link rel="stylesheet" href="style/main.css">
		<!-- jQuery library -->
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

		<!-- Latest compiled JavaScript -->
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
		<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.13/css/all.css" integrity="sha384-DNOHZ68U8hZfKXOrtjWvjxusGo9WQnrNx2sqG0tfsghAvtVlRW3tvkXWZh58N9jp" crossorigin="anonymous">
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
				background-color: lightseagreen;
				cursor:pointer;
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
			
			.numLike, .numDislike, .numComment,.numCommentLike,.numCommentDisLike{
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


			.comments-container-row{
				margin:30px 0px;
			}
			.commented{display:none;}
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
			      <li class="active"><a href="home.php">Home</a></li>
			      <li><a href="post.php">Post</a></li>
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
							
							<!--Posts container-->
							<div class="row">
								<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 note-container" id="postContainer">
									
								</div>
							</div>
							<div class="row commentFormContainer">
								<br>
								<form action="#" id="commentForm" data-post-id="<?php echo $_GET['pid'] ?>">
									<div class="col-lg-12 col-md-12 col-sm-12 comment-textarea-container">
										<div class="form-group">
											<div>
												<label for="comment">Comment:</label>
											</div>
											<div>
												<textarea class="form-control col-sm-12 coml-md-12 col-lg-12" name="commentText" rows="5" id="comment-txt"></textarea>
											</div>
											<div>
												<button class="btn btn-success commented">Commented Successfully</button>
												<button type="submit" class="btn btn-primary">Comment</button>
											</div>
										</div> 
									</div>
								</form>
							</div>

							<div class="row">
								<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
									<div id="commentContainer" class="commentContainer">
										
									</div>
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

		<script src="js/jquery.js"></script>
		<script src="js/jquerycookie.js"></script>
		<script src="js/main.js"></script>
		<script src="js/control.js"></script>
		<script>
			$("document").ready(function(){
				getCategories();
				var pid = getUrlVars()["pid"];
				getPostsById(pid);
				getComments(pid);
				
				$("body").on("click","#topics",function(){
					$(".commentFormContainer").hide();
					$(".commentContainer").hide();
				})
			})
		</script>
	</body>
</html>