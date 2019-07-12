<?php
	session_start();
	if(!isset($_SESSION['user_id'])){
		header("location: home.php");
	}
?>
<!DOCTYPE html>
<html>
	<head>
		<title>Lehagere.com | user profile</title>
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">

		<!-- jQuery library -->
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

		<!-- Latest compiled JavaScript -->
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
		<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css" integrity="sha384-UHRtZLI+pbxtHCWp1t77Bi1L4ZtiqrqD80Kn4Z8NTSRyMA2Fd33n5dQ8lWUE00s/" crossorigin="anonymous">
		<link rel="stylesheet" href="style/main.css">
		<style>
			.profile-image,.my-profile-image{
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
			.tab,.tb{
				background-color: #3b5998;
				border-right: 5px solid white;
				color: white;
				padding:10px;
				text-align:center;
			}
			.tab:hover,.tb:hover{
				background-color: lightseagreen;
				cursor:pointer;
				color:white;
			}


			.posts-container{
				margin-top:50px;
			}
			.posts-container img{
				width:95%;
				margin:5px;
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

			.user-info-contianer-row{
				padding: 10px;
				border-bottom:2px solid orange;
				background-color:lightgoldenrodyellow;
				margin:10px;
			}
			.user-info-container-row:first-child{
				margin-right:5px;
			}
			.spc{
				margin:5px 10px;
			}
			.hide{
				display:none;
			}
			.tabSelected{
				background-color:lightseagreen;
			}

			.status-container{
				border:0px !important;
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
			      <li><a href="home.php">Home</a></li>
				  <li><a href="post.php">Post</a></li> 
				  <li class="active"><a href="myprofile.php">Profile</a></li>
				  <li><a href="logout.php">Log Out</a></li>	 
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
							<div class="row header">
								<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 ">
									<div class="row">
										<div class="col-md-2 col-sm-2 col-lg-2 col-xs-3 profile-image-container">
											<img src="img" class="my-profile-image" alt="">
										</div>
										<div class="user-info-container col-md-10 col-sm-10 col-lg-10 col-xs-9">
											<p class="user-name"></p>
											<ul>
												<li class="post-number"></li>
											</ul>
										</div>
									</div>
									<div class="row">
										<div class="status-container">
											<p class="status"></p>
										</div>
									</div>
									<div class="row">
										<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 user-act-container">
											<div class="row">
												<div class="col-xs-4 tab tabSelected" id="aboutTab">
													<div class="buttons"><i class="fas fa-user"></i> <br>About</div>
												</div>
												<div class="col-xs-4 tab" id="postsTab">
													<div class="buttons"><i class="fas fa-scroll"></i> <br>Posts</div>
												</div>
												<div class="col-xs-4 tab" id="editTab">
													<div class="buttons"><i class="fas fa-user-edit"></i> <br>Edit</div>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
							

							<!--Posts container-->
							<div class="row">
								<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 ">
									<div class="profile-container">
										
									</div>
									<div class="row postsContainer">
										<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" id="postContainer"></div>
									</div>
									<div class="edit-profile-container hide">
										<div class="row">
											<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">

											<div class="row">
												<form action="php/post.php" class="form-group" id="changeImage" method="post" enctype="multipart/form-data">
													<div class="col-xs-1"></div>
													<div class="col-lg-10">
														<div class="row user-info-contianer-row">
															<div class="row user-info-contianer-row status-container">
																<div class="col-md-6 col-sm-6 col-xs-12 col-lg-6">
																	<i class="fas fa-camera"></i><span class="spc">Profile Image</span>
																</div>
																<div class="col-md-6 col-sm-6 col-xs-12 col-lg-6">
																	<input type="hidden" name="type" value="uploadProfileImage">
																	<input type="file" class="form-control-file" name="image" id="profilePicture" >
																</div>
															</div>
															<div class="row user-info-contianer-row">
																<div class="col-md-3 col-sm-3 col-xs-3 col-lg-3">
																	<!-- Update Space -->
																</div>
																<div class="col-md-6 col-sm-6 col-xs-6 col-lg-6">
																	<button class="image-message btn-success hide">Uploaded successfully.</button>
																	<input type="submit" id="" class="form-control" value="Upload">
																</div>
															</div>
														</div>
													</div>
												</form>
											</div>


											<div class="row">
													<form action="#" class="form-group" method="post" id="postStatus">
														<div class="col-xs-1"></div>
														<div class="col-lg-10">
															<div class="row user-info-contianer-row">
																<div class="row user-info-contianer-row status-container">
																	<div class="col-md-4 col-sm-4 col-xs-12 col-lg-4">
																		<i class="fas fa-user-edit"></i><span class="spc">Status</span>
																	</div>
																	<div class="col-md-8 col-sm-8 col-xs-12 col-lg-8">
																		<textarea class="form-control" id="statusText" rows="5" ></textarea>
																	</div>
																</div>
																<div class="row user-info-contianer-row">
																	<div class="col-md-3 col-sm-3 col-xs-3 col-lg-3">
																		<!-- Update Space -->
																	</div>
																	<div class="col-md-6 col-sm-6 col-xs-6 col-lg-6">
																		<button class="status-message btn-success hide">Status updated successfully.</button>
																		<input type="submit" id="" class="form-control" value="Update">
																	</div>
																</div>
															</div>
														</div>
													</form>
												</div>

												

												<div class="row">
													<form action="#" class="form-group" id="updateProfile" method="post">
														<div class="col-xs-1"></div>
															<div class="col-lg-10">
																<div class="row user-info-contianer-row">
																	<div class="row user-info-contianer-row">
																		<div class="col-md-6 col-sm-6 col-xs-12 col-lg-6">
																			<i class="fas fa-user"></i><span class="spc">First name</span>
																		</div>
																		<div class="col-md-6 col-sm-6 col-xs-12 col-lg-6">
																			<input class="form-control" id="firstName" name="firstName" placeholder="First Name">
																		</div>
																	</div>
																	<div class="row user-info-contianer-row">
																		<div class="col-md-6 col-sm-6 col-xs-12 col-lg-6">
																			<i class="fas fa-user"></i><span class="spc">Last name</span>
																		</div>
																		<div class="col-md-6 col-sm-6 col-xs-12 col-lg-6">
																			<input class="form-control" id="lastName" name="lastName" placeholder="Last Name">
																		</div>
																	</div>
																	<div class="row user-info-contianer-row">
																		<div class="col-md-6 col-sm-6 col-xs-12 col-lg-6">
																			<i class="far fa-user"></i><span class="spc">Gender</span>
																		</div>
																		<div class="col-md-6 col-sm-6 col-xs-12 col-lg-6">
																			<select class="form-control" name="gender" id="gender">
																				<option value="Male">Male</option>
																				<option value="Female">Female</option>
																			</select>
																		</div>
																	</div>
																	<div class="row user-info-contianer-row">
																		<div class="col-md-6 col-sm-6 col-xs-12 col-lg-6">
																			<i class="fas fa-birthday-cake"></i><span class="spc">Date of Birth</span>
																		</div>
																		<div class="col-md-6 col-sm-6 col-xs-12 col-lg-6">
																			<input type="date" class="form-control" name="dateOfBirth" id="dateOfBirth">
																		</div>
																	</div>
																	<div class="row user-info-contianer-row">
																		<div class="col-md-6 col-sm-6 col-xs-12 col-lg-6">
																			<i class="fas fa-pen-square"></i><span class="spc">Email</span>
																		</div>
																		<div class="col-md-6 col-sm-6 col-xs-12 col-lg-6">
																			<input type="text" class="form-control" name="email" id="email" disabled>
																		</div>

																	</div>

																	<div class="row user-info-contianer-row">
																		<div class="col-md-3 col-sm-3 col-xs-3 col-lg-3">
																			<!-- Update space -->
																		</div>
																		<div class="col-md-6 col-sm-6 col-xs-6 col-lg-6">
																			<button class="update-profile-message btn-success hide">Profile updated successfully.</button>
																			<input type="submit" class="form-control" value="Update">
																		</div>
																	</div>
																	
																</div>
															<div class="col-xs-1"></div>
														</form>
													</div>
												</div>
											</div>
										</div>
								</div>
							</div>
						</div>

							<!-- Posts Edit-->
							

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
				
				getMyProfile();

				if($("#aboutTab").hasClass("tabSelected")){
					getMyProfile();
				}

				$("body").on("click","#aboutTab",function(){
					if($("#postsTab").hasClass("tabSelected")){
						$("#postsTab").removeClass("tabSelected");
					}

					if($("#editTab").hasClass("tabSelected")){
						$("#editTab").removeClass("tabSelected");
					}

					$(this).addClass("tabSelected");
					$(".postsContainer").hide();
					$(".edit-profile-container").hide();
					$(".profile-container").fadeIn();
				})

				$("body").on("click","#postsTab",function(){
					if($("#aboutTab").hasClass("tabSelected")){
						$("#aboutTab").removeClass("tabSelected");
					}
					if($("#editTab").hasClass("tabSelected")){
						$("#editTab").removeClass("tabSelected");
					}
					var id = getUrlVars()['uid'];

					getAllPostsByMe();

					$(this).addClass("tabSelected");
					$(".profile-container").hide();
					$(".edit-profile-container").hide();
					$("#postContainer").removeClass("hide");
					$(".postsContainer").show();
				})

				$("body").on("click","#editTab",function(){
					if($("#aboutTab").hasClass("tabSelected")){
						$("#aboutTab").removeClass("tabSelected");
					}
					if($("#postsTab").hasClass("tabSelected")){
						$("#postsTab").removeClass("tabSelected");
					}
					var id = getUrlVars()['uid'];

					$(this).addClass("tabSelected");
					$(".profile-container").hide();
					$(".postsContainer").hide();
					$(".edit-profile-container").removeClass("hide");
					$(".edit-profile-container").show();
					getMyProfile();
				})

				$("body").on("click","#topics",function(){
					$(".header").hide();
					$(".profile-container").hide();
					$("#postContainer").removeClass("hide");
					$(".postsContainer").show();
				})

				$("body").on("click","#postEdit",function(){
					var postId = $(this).data("postid");
					window.location.href = "editpost.php?pid="+postId;
					console.log(postId);
					//var id = getUrlVars()['uid'];
				})

				$("body").on("submit","#postStatus",function(){
					var statusText = $("#statusText").val();
					postStatus(statusText);
					return false;
				})

				$("body").on("submit","#updateProfile",function(){
					updateProfile($(this));
					return false;
				})

			})
		</script>
	</body>
</html>