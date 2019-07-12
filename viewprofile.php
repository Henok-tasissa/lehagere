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

			.profile-image{
				width:100%;
				border-radius: 50%;
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
				background-color:lightsalmon;
				border-right:5px solid white;
			}
			.tab:hover{
				background-color: lightseagreen;
				cursor:pointer;
				color:white;
			}
			.buttons{
				padding:10px;
				border-radius:5px;
			}

			.buttons:hover{
				cursor: pointer;
			}


			.posts-container{
				margin-top:50px;
			}
			.post{
				padding: 10px;
				font-size: 1em;
			}
			.read-more{
				padding: 5px;
				border-radius: 5px;
				margin: 2px;
				cursor: pointer;
				text-decoration: none;
				width: 100px;
				background-color: #5bc0de;
				border-color: #46b8da;
				color: white;
				white-space: nowrap;
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
		    <div class="navbar-header col-sm-4  col-xs-10 col-md-5 col-lg-5">
		      <a class="navbar-brand" href="home.php">LE HAGERE</a>
		    </div>
		    <button class="nav-icon  navbar-toggler navbar-right" type="button" data-toggle="collapse" data-target="#navbar-collapse" aria-controls="navbar-collapse" aria-expanded="false" aria-label="Toggle navigation">
					<span class="navbar-toggler-icon"><i class="fas fa-bars"></i></span>
			</button>
		    <div class="col-xs-12 col-sm-6 col-md-5 col-lg-5 ">
			    <ul class="nav collapse navbar-nav navRight navbar-right" id="navbar-collapse">
			      <li class="active"><a href="home.php">Home</a></li>
			      <li><a href="index.php">Sign Up</a></li>
			      <!-- <li><a href="#">Page 3</a></li> -->
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
										<div class="col-md-2 col-sm-2 col-lg-2 col-xs-2 profile-image-container">
											<img src="images/male_profile.jpg" class="profile-image" alt="">
										</div>
										<div class="user-info-container col-md-10 col-sm-10 col-lg-10 col-xs-10">
											<p class="user-name">Sample Name</p>
											<ul>
												<li class="numLk">125 Posts</li>
											</ul>
										</div>
									</div>
									<div class="row">
										<div class="status-container">
											<p class="status">
												ዕውቀት ኃይል አይደለም!
												ብዙ ጊዜ ሊነገር የምንሰማው አባባል ዕውቀት ኃይል እንደሆነ ነው፤ እውነታው ግን የዚህ ተቃራኒ ነው:: ዕውቀት መረጃ ነው፤ ዕውቀት የእምቅ ኃይል ማቀጣጠያና መነሻ ነው፡፡ ይህ ኃይል ወደ ሙሉ ኃይልነት መቀየር የሚችለው ደግሞ ተግባር ላይ የዋላ እንደሆነ ብቻ ነው፡፡
											</p>
										</div>
									</div>
									<div class="row">
										<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 user-act-container">
											<div class="row">
												<div class="col-xs-3 tab">
													<div class="buttons"><i class="fas fa-user"></i> <br>About</div>
												</div>
												<div class="col-xs-3 tab">
													<div class="buttons"><i class="fas fa-scroll"></i> <br>Posts</div>
												</div>
												<div class="col-xs-3 tab">
													<div class="buttons"><i class="fas fa-rss"></i> <br>Follow</div>
												</div>
												<div class="col-xs-3 tab">
													<div class="buttons"><i class="fas fa-users"></i> <br>Followers</div>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
							

							<!--Posts container-->
							<div class="row">
								<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 ">
									<div class="posts-container">
										<div class="row">
											<div class="col-md-2 col-xs-3">
												<img src="images/male_profile.jpg" class="profile-image" alt="">
											</div>
											<div class="col-md-10 col-xs-9">
												<p class="user-name">Sample Name</p>
												<p>02/01/2019</p>
											</div>
										</div>
										<div class="row">
											<p class="title">
												ዕውቀት ኃይል አይደለም!
											</p>
											<p class="post">
													ብዙ ጊዜ ሊነገር የምንሰማው አባባል ዕውቀት ኃይል እንደሆነ ነው፤ እውነታው ግን የዚህ ተቃራኒ ነው:: ዕውቀት መረጃ ነው፤ ዕውቀት የእምቅ ኃይል ማቀጣጠያና መነሻ ነው፡፡ ይህ ኃይል ወደ ሙሉ ኃይልነት መቀየር የሚችለው ደግሞ ተግባር ላይ የዋላ እንደሆነ ብቻ ነው፡፡
													<br><br>
													ብዙ ጊዜ ሊነገር የምንሰማው አባባል ዕውቀት ኃይል እንደሆነ ነው፤ እውነታው ግን የዚህ ተቃራኒ ነው:: ዕውቀት መረጃ ነው፤ ዕውቀት የእምቅ ኃይል ማቀጣጠያና መነሻ ነው፡፡ ይህ ኃይል ወደ ሙሉ ኃይልነት መቀየር የሚችለው ደግሞ ተግባር ላይ የዋላ እንደሆነ ብቻ ነው፡፡
													<br><br>
													ብዙ ጊዜ ሊነገር የምንሰማው አባባል ዕውቀት ኃይል እንደሆነ ነው፤ እውነታው ግን የዚህ ተቃራኒ ነው:: ዕውቀት መረጃ ነው፤ ዕውቀት የእምቅ ኃይል ማቀጣጠያና መነሻ ነው፡፡ ይህ ኃይል ወደ ሙሉ ኃይልነት መቀየር የሚችለው ደግሞ ተግባር ላይ የዋላ እንደሆነ ብቻ ነው፡፡
													<a class="read-more" href="#">Read More</a>
											</p>
										</div>
										<div class="row">
											<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
												<div class="row">
													<div class="col-xs-4 tab">
														<div class="buttons"><i class="fas fa-thumbs-up"></i> 100</div>
													</div>
													<div class="col-xs-4 tab">
														<div class="buttons"><i class="fas fa-thumbs-down"></i> 250</div>
													</div>
													<div class="col-xs-4 tab">
														<div class="buttons"><i class="fas fa-comment"></i> 3000</div>
													</div>
												</div>
											</div>
										</div>
									</div>
									
									<div class="posts-container">
										<div class="row">
											<div class="col-md-2 col-xs-3">
												<img src="images/male_profile.jpg" class="profile-image" alt="">
											</div>
											<div class="col-md-10 col-xs-9">
												<p class="user-name">Sample Name</p>
												<p>02/01/2019</p>
											</div>
										</div>
										<div class="row">
											<p class="title">
												ዕውቀት ኃይል አይደለም!
											</p>
											<p class="post">
													ብዙ ጊዜ ሊነገር የምንሰማው አባባል ዕውቀት ኃይል እንደሆነ ነው፤ እውነታው ግን የዚህ ተቃራኒ ነው:: ዕውቀት መረጃ ነው፤ ዕውቀት የእምቅ ኃይል ማቀጣጠያና መነሻ ነው፡፡ ይህ ኃይል ወደ ሙሉ ኃይልነት መቀየር የሚችለው ደግሞ ተግባር ላይ የዋላ እንደሆነ ብቻ ነው፡፡
													<br><br>
													ብዙ ጊዜ ሊነገር የምንሰማው አባባል ዕውቀት ኃይል እንደሆነ ነው፤ እውነታው ግን የዚህ ተቃራኒ ነው:: ዕውቀት መረጃ ነው፤ ዕውቀት የእምቅ ኃይል ማቀጣጠያና መነሻ ነው፡፡ ይህ ኃይል ወደ ሙሉ ኃይልነት መቀየር የሚችለው ደግሞ ተግባር ላይ የዋላ እንደሆነ ብቻ ነው፡፡
													<br><br>
													ብዙ ጊዜ ሊነገር የምንሰማው አባባል ዕውቀት ኃይል እንደሆነ ነው፤ እውነታው ግን የዚህ ተቃራኒ ነው:: ዕውቀት መረጃ ነው፤ ዕውቀት የእምቅ ኃይል ማቀጣጠያና መነሻ ነው፡፡ ይህ ኃይል ወደ ሙሉ ኃይልነት መቀየር የሚችለው ደግሞ ተግባር ላይ የዋላ እንደሆነ ብቻ ነው፡፡
													<a class="read-more" href="#">Read More</a>
											</p>
										</div>
										<div class="row">
											<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
												<div class="row">
													<div class="col-xs-4 tab">
														<div class="buttons"><i class="fas fa-thumbs-up"></i>  100</div>
													</div>
													<div class="col-xs-4 tab">
														<div class="buttons"><i class="fas fa-thumbs-down"></i> 250</div>
													</div>
													<div class="col-xs-4 tab">
														<div class="buttons"><i class="fas fa-comment"></i> 3000</div>
													</div>
												</div>
											</div>
										</div>
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