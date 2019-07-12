var BASE_URL = "http://localhost/lehagerev2/";

var numLimitPost = 6;
var numLimitCategory = 6;
var numLimitQuestion = 6;
var numLimitQuestionCategory = 6;

function loginUser(info){
	var rememberMe;

	if($(".checkBox").is(':checked')){
		rememberMe= true;
	}else{
		rememberMe = false;
	};
	var userInfo = info.serialize();
	userInfo += "&type=loginUser&rememberMe="+rememberMe;
	$.post(BASE_URL+"php/login.php",userInfo,function(data){
		var loginInfo = JSON.parse(data);
		var status = loginInfo.status;
		var message = loginInfo.message;
		var userId = loginInfo.user_id;
		var token = loginInfo.token;
		if(status){
			if(rememberMe){
				$.cookie("userId", userId, { expires : 60});
				$.cookie("token", token, { expires : 60 });
				$.cookie("loginStatus", true, { expires : 60});
			}
			else{
				$.cookie("loginStatus", true, { expires : 60});
			}
			window.location = BASE_URL+"home.php";

		}else{
			$(".login-info").html(message +" Please check your email and password.").slideDown();
			return false;
		}
		
	}).fail(function(status){
		console.log(status.text);
	});

}


/*function checkLoginStatus(){
	if (!$.cookie('token') && !$.cookie('userId')){
	 	var cookieUserId = $.cookie("userId");
		var cookieToken = $.cookie("token");
		loginWithToken(cookieUserId,cookieToken);
	}else{
		return false;
	}
}*/

function loginWithToken(cookieUserId,cookieToken){
	info = {
		'type':'loginWithToken',
		'userId':cookieUserId,
		'token':cookieToken
	}
	$.post(BASE_URL+"php/login.php",info,function(data){
		var data = JSON.parse(data);
		if(data.status){
			$.cookie("loginStatus", true, { expires : 60});
			window.location = BASE_URL+"home.php";
		}else{
			return false;
		}
	});
};



function registerUser(info){
	var userInfo = info.serialize();
	userInfo += "&type=registerUser";
	$.post(BASE_URL+"php/register.php",userInfo,function(data){
		data = JSON.parse(data);
		if(data.status){
			window.location = BASE_URL+"index.php?reg=true";
		}else{
			$(".err").html(data.message).slideDown();
		}
	}).fail(function(){
		console.log("fail");
	})

	return false;
}

/*function getUserSession(){
	var info = {
		"type":"getUserSession"
	}
	$.ajax({
		type: "GET",
		url: BASE_URL+"view.php",
		data:info,
		success: function(info){
			console.log($("body").data("userId"));
			$("body").data("userId",info);
		}
	})
}
getUserSession();//initializes user session
*/

/*Gets category From the server*/
function getCategories(){
	var info = {"type":"getCategories"};
	$.get(BASE_URL+"php/view.php",info,function(data){
			viewCategories(data);
		}).fail(function(jqXHR){
		console.log(jqXHR.statusText);
	});
}

/*Manipulates the select with option from server data*/
function viewCategories(category){
	var topicContainer = $("#topicContainer");
	for(var i = 0; i<category.length;i++){
		var topicId = category[i].category_id;
		var topicName = category[i].category_name;
		topicContainer.append('<button class="btn btn-sm btn-outline-secondary tagBtn btn-topic" id="topics" data-topicId="'+topicId+'">'+topicName+'</button>');
	}
}

function getMyProfile(){
	info = {
		"type": "userProfileInfo",
	}
	$.get(BASE_URL+"php/view.php",info,function(data){
		viewMyProfile(data);
	})
}

function getUserProfile(){
	var uid = getUrlVars()['uid'];
	info = {
		"type": "userProfileInfo",
		"uid" : uid
	}
	$.get(BASE_URL+"php/view.php",info,function(data){
		viewProfile(data);
	})
}

function viewProfile(data){
	var userId = data[0].user_id;
	var firstName = data[0].first_name;
	var lastName = data[0].last_name;
	var imageId = data[0].image;
	var birthDay = formatDate(data[0].date_of_birth);
	var postNumber = data[0].post_number;
	var gender = data[0].gender;
	var postNumber = data[0].post_number;
	var status = data[0].status;
	var imageLocation;

	if(imageId=="" || imageId==1 || imageId==0){
		if(gender=="Male"){
			imageLocation = "./images/male_profile.jpg";
		}else if(gender=="Female"){
			imageLocation = "./images/female_profile.jpg";
		}
	}else{
		imageLocation = "./images/"+imageId;   
	}

	if(status == ""){
		$(".status").html("\"Please, share lehagere for friends.\"");
	}else{
		$(".status").html(status);
	}	

	$(".user-name").html(firstName+' '+lastName);
	$(".post-number").html(postNumber+" posts");
	$(".profile-image").attr("src",imageLocation);
	var profile = '<div class="row"><div class="col-xs-1"></div><div class="col-lg-10"><div class="row user-info-contianer-row"><div class="col-md-6 col-sm-6 col-xs-6 col-lg-6"><i class="fas fa-user"></i><span class="spc">Full name</span></div><div class="col-md-6 col-sm-6 col-xs-6 col-lg-6"><span class="spc">'+firstName+' '+lastName+'</span></div></div><div class="row user-info-contianer-row"><div class="col-md-6 col-sm-6 col-xs-6 col-lg-6"><i class="far fa-user"></i><span class="spc">Gender</span></div><div class="col-md-6 col-sm-6 col-xs-6 col-lg-6"><span class="spc">'+gender+'</span></div></div><div class="row user-info-contianer-row"><div class="col-md-6 col-sm-6 col-xs-6 col-lg-6"><i class="fas fa-birthday-cake"></i><span class="spc">Date of Birth</span></div><div class="col-md-6 col-sm-6 col-xs-6 col-lg-6"><span class="spc">'+birthDay+'</span></div></div><div class="row user-info-contianer-row"><div class="col-md-6 col-sm-6 col-xs-6 col-lg-6"><i class="fas fa-pen-square"></i><span class="spc">Posts</span></div><div class="col-md-6 col-sm-6 col-xs-6 col-lg-6"><span class="spc">'+postNumber+'</span></div></div></div><div class="col-xs-1"></div></div>';
	$(".profile-container").html(profile);

	console.log(userId);
}

function viewMyProfile(data){
	var userId = data[0].user_id;
	var firstName = data[0].first_name;
	var lastName = data[0].last_name;
	var imageId = data[0].image;
	var birthDay = formatDate(data[0].date_of_birth);
	var postNumber = data[0].post_number;
	var email = data[0].email_address;
	var gender = data[0].gender;
	var postNumber = data[0].post_number;
	var status = data[0].status;
	var imageLocation="";

	if(imageId=="" || imageId==1 || imageId==0){
		if(gender=="Male"){
			imageLocation = "./images/male_profile.jpg";
		}else if(gender=="Female"){
			imageLocation = "./images/female_profile.jpg";
		}
	}else{
		imageLocation = "./images/"+imageId;   
	}
	

	$(".user-name").html(firstName+' '+lastName);
	$(".post-number").html(postNumber+" posts");
	var profile = '<div class="row"><div class="col-xs-1"></div><div class="col-lg-10"><div class="row user-info-contianer-row"><div class="col-md-6 col-sm-6 col-xs-6 col-lg-6"><i class="fas fa-user"></i><span class="spc">Full name</span></div><div class="col-md-6 col-sm-6 col-xs-6 col-lg-6"><span class="spc">'+firstName+' '+lastName+'</span></div></div><div class="row user-info-contianer-row"><div class="col-md-6 col-sm-6 col-xs-6 col-lg-6"><i class="far fa-user"></i><span class="spc">Gender</span></div><div class="col-md-6 col-sm-6 col-xs-6 col-lg-6"><span class="spc">'+gender+'</span></div></div><div class="row user-info-contianer-row"><div class="col-md-6 col-sm-6 col-xs-6 col-lg-6"><i class="fas fa-birthday-cake"></i><span class="spc">Date of Birth</span></div><div class="col-md-6 col-sm-6 col-xs-6 col-lg-6"><span class="spc">'+birthDay+'</span></div></div><div class="row user-info-contianer-row"><div class="col-md-6 col-sm-6 col-xs-6 col-lg-6"><i class="fas fa-envelope"></i><span class="spc">Email</span></div><div class="col-md-6 col-sm-6 col-xs-6 col-lg-6"><span class="spc">'+email+'</span></div></div><div class="row user-info-contianer-row"><div class="col-md-6 col-sm-6 col-xs-6 col-lg-6"><i class="fas fa-pen-square"></i><span class="spc">Posts</span></div><div class="col-md-6 col-sm-6 col-xs-6 col-lg-6"><span class="spc">'+postNumber+'</span></div></div></div><div class="col-xs-1"></div></div>';
	$(".profile-container").html(profile);
	$(".status").html(status);
	$(".my-profile-image").attr("src",imageLocation);

	if($("#editTab").hasClass("tabSelected")){
		$("#statusText").val(status);
		$("#firstName").val(firstName);
		$("#lastName").val(lastName);
		$("#email").val(email);
		$("#dateOfBirth").val(data[0].date_of_birth);
		$("#gender").val(gender);
	}
}

/*Gets all posts from the server*/
function getAllPosts(limit){
	var info = {
			"type":"viewAllPost",
			"requestLimit":limit
		};
	$.get(BASE_URL+"php/view.php",info,function(data){
			viewPosts(data,false,limit);
		}).fail(function(jqXHR){
		console.log(jqXHR.statusText);
	});
}


/*Gets all posts from the server for offline*/
function getAllPostsForOffline(limit){
	var info = {
			"type":"viewAllPostForOffline",
			"requestLimit":limit
		};
	$.get(BASE_URL+"php/view.php",info,function(data){
			viewPostsForOffline(data,false,limit);
		}).fail(function(jqXHR){
		console.log(jqXHR.statusText);
	});
}


/*Gets all user posts from the server for */
function getAllPostsByUserId(id,limit){
	var info = {
			"type":"postByUserId",
			"requestLimit":limit,
			"uid":id
		};
	$.get(BASE_URL+"php/view.php",info,function(data){
			viewPosts(data,false);
		}).fail(function(jqXHR){
		console.log(jqXHR.statusText);
	});
}

/*Gets all user posts from the server for logged in user */
function getAllPostsByMe(){
	var info = {
			"type":"postByMe",
		};
	$.get(BASE_URL+"php/view.php",info,function(data){
			console.log(data);
			viewMyPosts(data);
		}).fail(function(jqXHR){
		console.log(jqXHR.statusText);
	});
}

/*Gets all user posts from the server for offline*/
function getAllPostsByUserIdForOffline(id,limit){
	var info = {
			"type":"postByUserId",
			"requestLimit":limit,
			"uid":id
		};
	$.get(BASE_URL+"php/view.php",info,function(data){
			viewPostsForOffline(data,false);
			$("#showMoreForOffline").hide();
		}).fail(function(jqXHR){
		console.log(jqXHR.statusText);
	});
}



/*Gets Posts from server based on their category*/
function getPostsByCategory(categoryId,limit){
	var info = {
		"type":"viewPostByCategory",
		"categoryId": categoryId,
		"requestLimit":limit
	};
	if(categoryId != 0){
		$.get(BASE_URL+"php/view.php",info,function(data){
			viewPosts(data,true,limit);
			/*console.log(data);*/
		}).fail(function(jqXHR){
			console.log(jqXHR.statusText);
		});
	}else{
		getAllPosts(limit);
	}
}

/*Gets Posts from server based on their category for offline*/
function getPostsByCategoryForOffline(categoryId,limit){
	var info = {
		"type":"viewPostByCategoryForOffline",
		"categoryId": categoryId,
		"requestLimit":limit
	};
	if(categoryId != 0){
		$.get(BASE_URL+"php/view.php",info,function(data){
			viewPostsForOffline(data,true,limit);
			/*console.log(data);*/
		}).fail(function(jqXHR){
			console.log(jqXHR.statusText);
		});
	}else{
		getAllPostsForOffline(limit);
	}
}

function getPostsById(pstId){
	var info = {
		"type":"viewSinglePost",
		"postId": pstId
	};

	$.get(BASE_URL+"php/view.php",info,function(data){
		viewSinglePost(data);
		/*console.log(data);*/
	}).fail(function(jqXHR){
		console.log(jqXHR.statusText);
	});
}

function getPostsByIdForOffline(pstId){
	var info = {
		"type":"viewSinglePostForOffline",
		"postId": pstId
	};

	$.get(BASE_URL+"php/view.php",info,function(data){
		viewSinglePostForOffline(data);
		/*console.log(data);*/
	}).fail(function(jqXHR){
		console.log(jqXHR.statusText);
	});
}



/*Manipulates the view of the post to the homepage*/
function viewPosts(pst,category,limit){

	var main = $("#postContainer");
	main.html("");
	var posts = pst;
	var postsLength = posts.length;
	var showMore = "";
	if(limit > postsLength){
		showMore = "";
	}else{
		if(category){
			showMore = '<button class="show-more btn btn-default" id="showMoreCategory">Show More</button>';
		}else{
			showMore = '<button class="show-more btn btn-default" id="showMore">Show More</button>';
		}
	}
	var numFix = 0;
	for(var i=0; i<postsLength;i++){
		var userInformation = posts[i].user_info[0];
		var userId = posts[i].user_id;
		var commentMode = posts[i].comment_mode;
		var like = posts[i].like;
		var numLikes = posts[i].num_likes;
		var numUnlikes = posts[i].num_unlikes;
		var numComments = posts[i].num_comments;
		var postDate = formatDate(posts[i].post_date);
		var postId = posts[i].post_id;
		var postText = posts[i].post_text;
		var postTitle = posts[i].post_title;
		var postCategory = posts[i].category_name;
		var publicityMode = posts[i].publicity_mode;
		var unlike = posts[i].unlike;
		var firstName = userInformation.first_name;
		var lastName = userInformation.last_name;
		var imageId = userInformation.image;
		var gender = userInformation.gender;
		var postType = posts[i].post_type;
		var imageLocation;
		var likeClass = "";
		var unlikeClass = "";
	
		/*Changes the image*/
		if(imageId=="" || imageId==1 || imageId==0){
    	    if(gender=="Male"){
    	        imageLocation = "./images/male_profile.jpg";
    	    }else if(gender=="Female"){
    	        imageLocation = "./images/female_profile.jpg";
    	    }
    	}else{
    	    imageLocation = "./images/"+imageId;   
    	}

		if(postText.length>400){
			postText = postText.slice(0,303)+" ... ";
			postText += '<a class="read-more" href="viewpost.php?pid='+postId+'">Read More</a>';
		}

		if(postTitle.length > 100){
			postTitle = postTitle.slice(0,80);
			postTitle += " ... ";
		}

		if(like){
			likeClass = "liked";
		}
		if(unlike){
			unlikeClass = "unLiked";
		}
		var post = '<div class="posts-container"><div class="row"><div class="col-md-2 col-xs-3"><img src="'+imageLocation+'" class="profile-image" alt=""></div><div class="col-md-10 col-xs-9"><p class="user-name"><a href="profile.php?uid='+userId+'">'+firstName+' '+lastName+'</a></p><p>'+postDate+'</p><p class="postTag">#'+postCategory+'</p></div></div><div class="row"><p class="title"><a href="#" class="post-title">'+postTitle+' </a></p><p class="post">'+postText+' </p></div><div class="row"><div class="col-lg-12 col-md-12 col-sm-12 col-xs-12"><div class="row"><div class="col-xs-4 tab like '+likeClass+'" id="like" data-postId="'+postId+'"><i class="fas fa-thumbs-up"></i><span class="numLike">'+numLikes+'</span></div><div class="col-xs-4 tab dislike '+unlikeClass+'" id="dislike" data-postId="'+postId+'"><i class="fas fa-thumbs-down"></i><span class="numDislike">'+numUnlikes+'</span></div><div class="col-xs-4 tab comment" id="comment" data-postId="'+postId+'"><i class="fas fa-comment"></i><span class="numComment">'+numComments+'</span></div></div></div></div></div>';
		main.append(post);
	}
	main.append(showMore);
}



/* View posts for logged in user */

function viewMyPosts(pst){

	var main = $("#postContainer");
	main.html("");
	var posts = pst;
	var postsLength = posts.length;
	var showMore = "";

	var numFix = 0;
	for(var i=0; i<postsLength;i++){
		var userInformation = posts[i].user_info[0];
		var userId = posts[i].user_id;
		var commentMode = posts[i].comment_mode;
		var like = posts[i].like;
		var numLikes = posts[i].num_likes;
		var numUnlikes = posts[i].num_unlikes;
		var numComments = posts[i].num_comments;
		var postDate = formatDate(posts[i].post_date);
		var postId = posts[i].post_id;
		var postText = posts[i].post_text;
		var postTitle = posts[i].post_title;
		var postCategory = posts[i].category_name;
		var publicityMode = posts[i].publicity_mode;
		var unlike = posts[i].unlike;
		var firstName = userInformation.first_name;
		var lastName = userInformation.last_name;
		var imageId = userInformation.image;
		var gender = userInformation.gender;
		var postType = posts[i].post_type;
		var imageLocation;
		var likeClass = "";
		var unlikeClass = "";
	
		/*Changes the image*/
		if(imageId=="" || imageId==1 || imageId==0){
    	    if(gender=="Male"){
    	        imageLocation = "./images/male_profile.jpg";
    	    }else if(gender=="Female"){
    	        imageLocation = "./images/female_profile.jpg";
    	    }
    	}else{
    	    imageLocation = "./images/"+imageId;   
    	}

		if(postText.length>400){
			postText = postText.slice(0,303)+" ... ";
			postText += '<a class="read-more" href="viewpost.php?pid='+postId+'">Read More</a>';
		}

		if(postTitle.length > 100){
			postTitle = postTitle.slice(0,80);
			postTitle += " ... ";
		}

		if(like){
			likeClass = "liked";
		}
		if(unlike){
			unlikeClass = "unLiked";
		}
		var post = '<div class="posts-container"><div class="row"><div class="col-md-2 col-xs-3"><img src="'+imageLocation+'" class="profile-image" alt=""></div><div class="col-md-10 col-xs-9"><p class="user-name"><a href="profile.php?uid='+userId+'">'+firstName+' '+lastName+'</a></p><p>'+postDate+'</p><p class="postTag">#'+postCategory+'</p></div></div><div class="row"><p class="title"><a href="#" class="post-title">'+postTitle+' </a></p><p class="post">'+postText+' </p></div><div class="row"><div class="col-lg-12 col-md-12 col-sm-12 col-xs-12"><div class="row"><div class="col-xs-3 tab like '+likeClass+'" id="like" data-postId="'+postId+'"><i class="fas fa-thumbs-up"></i><span class="numLike">'+numLikes+'</span></div><div class="col-xs-3 tab dislike '+unlikeClass+'" id="dislike" data-postId="'+postId+'"><i class="fas fa-thumbs-down"></i><span class="numDislike">'+numUnlikes+'</span></div><div class="col-xs-3 tab comment" id="comment" data-postId="'+postId+'"><i class="fas fa-comment"></i><span class="numComment">'+numComments+'</span></div><div class="buttons postEdit col-xs-3 tab" id="postEdit" data-postId="'+postId+'"><i class="fas fa-edit"></i> Edit</div></div></div></div></div>';
		main.append(post);
	}
	main.append(showMore);
}


/*Manipulates the view of the post to the homepage*/
function viewPostsForOffline(pst,category,limit){

	var main = $("#postContainer");
	main.html("");
	var posts = pst;
	var postsLength = posts.length;
	var showMore = "";
	if(limit > postsLength){
		showMore = "";
	}else{
		if(category){
			showMore = '<button class="show-more btn btn-default" id="showMoreCategoryForOffline">Show More</button>';
		}else{
			showMore = '<button class="show-more btn btn-default" id="showMoreForOffline">Show More</button>';
		}
	}
	var numFix = 0;
	for(var i=0; i<postsLength;i++){
		var userInformation = posts[i].user_info[0];
		var userId = posts[i].user_id;
		var commentMode = posts[i].comment_mode;
		var numLikes = posts[i].num_likes;
		var numUnlikes = posts[i].num_unlikes;
		var numComments = posts[i].num_comments;
		var postDate = formatDate(posts[i].post_date);
		var postId = posts[i].post_id;
		var postText = posts[i].post_text;
		var postTitle = posts[i].post_title;
		var postCategory = posts[i].category_name;
		var publicityMode = posts[i].publicity_mode;
		var firstName = userInformation.first_name;
		var lastName = userInformation.last_name;
		var imageId = userInformation.image;
		var gender = userInformation.gender;
		var postType = posts[i].post_type;
		var imageLocation="";
		var likeClass = "";
		var unlikeClass = "";
		/*Changes the image*/
		if(imageId=="" || imageId==1 || imageId==0){
    	    if(gender=="Male"){
    	        imageLocation = "./images/male_profile.jpg";
    	    }else if(gender=="Female"){
    	        imageLocation = "./images/female_profile.jpg";
    	    }
    	}else{
    	    imageLocation = "./images/"+imageId;   
    	}

		if(postText.length>400){
			postText = postText.slice(0,303)+" ... ";
			postText += '<a class="btn btn-info btn-xs" href="viewpost1.php?pid='+postId+'">Read more</a>';
			//postText += '<span><a href="" class="readMore" data-post-id="'+postId+'">Read more</a></span></p></div>';
		}

		if(postTitle.length > 100){
			postTitle = postTitle.slice(0,80);
			postTitle += " ... ";
		}
			var fixBox = '<div class="clearfix visible-sm visible-lg visible-md"></div>';
			if(numFix % 2 == 0){
				fixBox = "";
			}
			numFix++;
			var post = '<div class="posts-container"><div class="row"><div class="col-md-2 col-xs-3"><img src="'+imageLocation+'" class="profile-image" alt=""></div><div class="col-md-10 col-xs-9"><p class="user-name"><a href="profile.php?uid='+userId+'">'+firstName+' '+lastName+'</a></p><p>'+postDate+'</p><p class="postTag">#'+postCategory+'</p></div></div><div class="row"><p class="title"><a href="#" class="post-title">'+postTitle+' </a></p><p class="post">'+postText+' </p></div><div class="row"><div class="col-lg-12 col-md-12 col-sm-12 col-xs-12"><div class="row"><div class="col-xs-4 tab like '+likeClass+'" data-postId="'+postId+'"><i class="fas fa-thumbs-up"></i><span class="numLike">'+numLikes+'</span></div><div class="col-xs-4 tab dislike '+unlikeClass+'" data-postId="'+postId+'"><i class="fas fa-thumbs-down"></i><span class="numDislike">'+numUnlikes+'</span></div><div class="col-xs-4 tab comment" id="commentForOffline" data-postId="'+postId+'"><i class="fas fa-comment"></i><span class="numComment">'+numComments+'</span></div></div></div></div></div>';
			main.append(post);
	}
	main.append(showMore);
}


function getPostsByIdForUpdate(pstId){
	var info = {
		"type":"viewSinglePost",
		"postId": pstId
	};

	$.get(BASE_URL+"php/view.php",info,function(data){
		viewPostForUpdate(data);
		/*console.log(data);*/
	}).fail(function(jqXHR){
		console.log(jqXHR.statusText);
	});
}

/* _____________ View Post For Updating posts _________________ */
function viewPostForUpdate(pst){
	var singlePost = pst;
	var main = $(".note-container");
	main.html("");
	var userInformation = singlePost[0].user_info[0];
	var postText = singlePost[0].post_text;
	var postId = singlePost[0].post_id;
	var postTitle = singlePost[0].post_title;
	var postCategoryId = singlePost[0].category_id;
	var firstName = userInformation.first_name;
	var lastName = userInformation.last_name;
	var imageId = userInformation.image;
	var gender = userInformation.gender;
	var userId =  userInformation.user_id;
	var postType = singlePost[0].post_type;
	var imageLocation;
	var likeClass = "";
	var unlikeClass = "";

	$(".user-name").html(firstName+" "+lastName);
	$('[data-topicid~='+postCategoryId+']').addClass("selected");
	$("#postTitle").val(postTitle);
	$("#postId").val(postId);
	$("#topicId").val(postCategoryId);
	$("#userId").val(userId);
	$(".nicEdit-main").html(postText);
}

function viewSinglePost(pst){
	var singlePost = pst;
	var main = $(".note-container");
	main.html("");
	var userInformation = singlePost[0].user_info[0];
	var commentMode = singlePost[0].comment_mode;
	var like = singlePost[0].like;
	var numLikes = singlePost[0].num_likes;
	var numUnlikes = singlePost[0].num_unlikes;
	var numComments = singlePost[0].num_comments;
	var postDate = formatDate(singlePost[0].post_date);
	var postId = singlePost[0].post_id;
	var postText = singlePost[0].post_text;
	var postTitle = singlePost[0].post_title;
	var postCategory = singlePost[0].category_name;
	var publicityMode = singlePost[0].publicity_mode;
	var unlike = singlePost[0].unlike;
	var firstName = userInformation.first_name;
	var lastName = userInformation.last_name;
	var imageId = userInformation.image;
	var gender = userInformation.gender;
	var postType = singlePost[0].post_type;
	var userId = userInformation.user_id;
	var imageLocation;
	var likeClass = "";
	var unlikeClass = "";

	if(like){
		likeClass = "liked";
	}
	if(unlike){
		unlikeClass = "unLiked";
	}
		
		/*Changes the image*/
		if(imageId=="" || imageId==1 || imageId==0){
    	    if(gender=="Male"){
    	        imageLocation = "./images/male_profile.jpg";
    	    }else if(gender=="Female"){
    	        imageLocation = "./images/female_profile.jpg";
    	    }
    	}else{
    	    imageLocation = "./images/"+imageId;   
    	}

		if(like){
			likeClass = "liked";
		}else{
			likeClass = "";
		}

		if(unlike){
			UnlikeClass = "unLiked";
		}else{
			UnlikeClass = "";
		}
		var post = '<div class="posts-container"><div class="row"><div class="col-md-2 col-xs-3"><img src="'+imageLocation+'" class="profile-image" alt=""></div><div class="col-md-10 col-xs-9"><p class="user-name"><a href="profile.php?uid='+userId+'">'+firstName+' '+lastName+'</a></p><p>'+postDate+'</p><p>'+postCategory+'</p></div></div><div class="row"><p class="title"><a href="#" class="post-title">'+postTitle+' </a></p><p class="post">'+postText+' </p></div><div class="row"><div class="col-lg-12 col-md-12 col-sm-12 col-xs-12"><div class="row"><div class="col-xs-4 tab like '+likeClass+'" id="like" data-postId="'+postId+'"><i class="fas fa-thumbs-up"></i><span class="numLike">'+numLikes+'</span></div><div class="col-xs-4 tab dislike '+unlikeClass+'" id="dislike" data-postId="'+postId+'"><i class="fas fa-thumbs-down"></i><span class="numDislike">'+numUnlikes+'</span></div><div class="col-xs-4 tab comment" id="comment" data-postId="'+postId+'"><i class="fas fa-comment"></i><span class="numComment">'+numComments+'</span></div></div></div></div></div>';
		
		main.append(post);
		getComments(postId);

}

/*For offline*/
function viewSinglePostForOffline(pst){
	var singlePost = pst;
	var main = $(".note-container");
	main.html("");
	var userInformation = singlePost[0].user_info[0];
	var commentMode = singlePost[0].comment_mode;
	var like = singlePost[0].like;
	var numLikes = singlePost[0].num_likes;
	var numUnlikes = singlePost[0].num_unlikes;
	var numComments = singlePost[0].num_comments;
	var postDate = formatDate(singlePost[0].post_date);
	var postId = singlePost[0].post_id;
	var postText = singlePost[0].post_text;
	var postTitle = singlePost[0].post_title;
	var postCategory = singlePost[0].category_name;
	var publicityMode = singlePost[0].publicity_mode;
	var unlike = singlePost[0].unlike;
	var firstName = userInformation.first_name;
	var lastName = userInformation.last_name;
	var imageId = userInformation.image;
	var gender = userInformation.gender;
	var postType = singlePost[0].post_type;
	var userId = userInformation.user_id;
	var imageLocation;
	var likeClass = "";
	var unlikeClass = "";

	if(like){
		likeClass = "liked";
	}
	if(unlike){
		unlikeClass = "unLiked";
	}
		
		/*Changes the image*/
		if(imageId=="" || imageId==1 || imageId==0){
    	    if(gender=="Male"){
    	        imageLocation = "./images/male_profile.jpg";
    	    }else if(gender=="Female"){
    	        imageLocation = "./images/female_profile.jpg";
    	    }
    	}else{
    	    imageLocation = "./images/"+imageId;   
    	}

		if(like){
			likeClass = "liked";
		}else{
			likeClass = "";
		}

		if(unlike){
			UnlikeClass = "unLiked";
		}else{
			UnlikeClass = "";
		}
		var post = '<div class="posts-container"><div class="row"><div class="col-md-2 col-xs-3"><img src="'+imageLocation+'" class="profile-image" alt=""></div><div class="col-md-10 col-xs-9"><p class="user-name"><a href="profile.php?uid='+userId+'">'+firstName+' '+lastName+'</a></p><p>'+postDate+'</p><p>'+postCategory+'</p></div></div><div class="row"><p class="title"><a href="#" class="post-title">'+postTitle+' </a></p><p class="post">'+postText+' </p></div><div class="row"><div class="col-lg-12 col-md-12 col-sm-12 col-xs-12"><div class="row"><div class="col-xs-4 tab like '+likeClass+'" data-postId="'+postId+'"><i class="fas fa-thumbs-up"></i><span class="numLike">'+numLikes+'</span></div><div class="col-xs-4 tab dislike '+unlikeClass+'" data-postId="'+postId+'"><i class="fas fa-thumbs-down"></i><span class="numDislike">'+numUnlikes+'</span></div><div class="col-xs-4 tab comment" data-postId="'+postId+'"><i class="fas fa-comment"></i><span class="numComment">'+numComments+'</span></div></div></div></div></div>';
		//var post = '<div class="container col-lg-12 col-md-12 col-sm-12 col-xs-12  single-post-container row-eq-height"><div class="post-spacing"><div class="row post-header"><div class="col-md-2 col-lg-2 col-sm-4 col-xs-4"><div class="image-container"><img src="'+imageLocation+'" alt="" class="user-image"></div></div><div class="col-md-8 col-lg-8 col-sm-8 col-xs-8"><div class="user-container"><p class="username">'+firstName+' '+lastName+'</p><p class="date">'+postDate+'</p><button class="tag">'+postCategory+'</button></div></div></div><div class="row"><div class="post-text-container"><p class="postText">'+postText+'</p></div></div><div class="row post-bottom-container"><div><div class="col-lg-4 col-md-4 col-sm-4 col-xs-4"><button class="btn like  col-lg-12 col-md-12 col-sm-12 col-xs-12 disabled '+likeClass+'" id="like" data-postId="'+postId+'"  aria-disabled="true" disabled><span class="numLike">'+numLikes+'</span><i class="fa fa-thumbs-up" aria-hidden="true"></i></button></div><div class="col-lg-4 col-md-4 col-sm-4 col-xs-4"><button class="btn dislike col-lg-12 col-md-12 col-sm-12 col-xs-12 disabled '+unlikeClass+'"  id="dislike" data-postId="'+postId+'"  aria-disabled="true" disabled><span  class="numDislike">'+numUnlikes+'</span><i class="fa fa-thumbs-down" aria-hidden="true"></i></button></div><div class="col-lg-4 col-md-4 col-sm-4 col-xs-4"><button class="btn comment col-lg-12 col-md-12 col-sm-12 col-xs-12"  id="commentForOffline" data-postId="'+postId+'"><span  class="numComment">'+numComments+'</span><i class="far fa-comment-alt"></i></button></div></div></div></div></div>';

		main.append(post);
		getCommentsForOffline(postId);

}

function likePost(postId){
	info = {
		"postId":postId,
		"type": "likePost"
	}
	$.ajax({
		  type: "POST",
		  url: BASE_URL+"php/post.php",
		  data: info,
		  success: function(data){
		  	return true;
		  }
	});
}

function unLikePost(postId){
	info = {
		"postId":postId,
		"type": "unLikePost"
	}
	$.ajax({
		  type: "POST",
		  url: BASE_URL+"php/post.php",
		  data: info,
		  success: function(data){
		  	return true;
		  }
	});
}

function insertPost(form){
	var info = form.serialize();
		info += "&type=insertPost";
	$.ajax({
		  type: "POST",
		  url: BASE_URL+"php/post.php",
		  data: info,
		  success: function(data){
		  	var category = $("[name='category']");
			var postTitle = $("[name='postTitle']");
			var postText = $(".nicEdit-main");
			category.val(0);
			postTitle.val("");
			postText.html("");
			$("#topics").removeClass("selected");
		  	$(".posted").slideDown();
		  }
	});
}

function updatePost(form){
	var info = form.serialize();
		info += "&type=updatePost";
	$.ajax({
		  type: "POST",
		  url: BASE_URL+"php/post.php",
		  data: info,
		  success: function(data){
		  	var category = $("[name='category']");
			var postTitle = $("#postTitle");
			var postText = $(".nicEdit-main");
			category.val(0);
			$('[data-topicid]').removeClass("selected");
			postTitle.val("");
			postText.html("");
			$(".deleted").hide();
		  	$(".posted").slideDown();
		  }
	});
}

function deletePost(id){
	var info = 'postId='+id+'&type=deletePost';
	$.ajax({
		  type: "POST",
		  url: BASE_URL+"php/post.php",
		  data: info,
		  success: function(data){
		  	var category = $("[name='category']");
			var postTitle = $("#postTitle");
			var postText = $(".nicEdit-main");
			category.val(0);
			$('[data-topicid]').removeClass("selected");
			postTitle.val("");
			postText.html("");
			$(".posted").hide();
			$(".deleted").slideDown();
			window.location = BASE_URL+"myprofile.php";
			  
		  }
	});
}

function postComment(form){
	var postId = form.data("post-id");
	var info = form.serialize();
	info += "&postId="+postId;
	info += "&type=postComment";
	var postCls = ".pstId-"+postId;
	$.ajax({
		type:"POST",
		url : BASE_URL+"php/post.php",
		data: info,
		success: function(data){
			getComments(postId);
			var postComment = $(".numComment");
			var postCommentNum = parseInt(postComment.html()) + 1;
			postComment.html(postCommentNum);
			$(".commented").slideDown();
			$("[name='commentText']").val("");
			$(postCls+ " #commentNum").html(Number(parseInt($(postCls+ " #commentNum").html())+1));
		}
	});
}

function getComments(postId){
	info = {
		postId: postId,
		type : "viewComments"
	}
	$.get(BASE_URL+"php/view.php",info,function(data){
		$('.comments-wrapper').val("");
		viewComments(data);
	})
}

function getCommentsForOffline(postId){
	info = {
		postId: postId,
		type : "viewCommentsForOffline"
	}
	$.get(BASE_URL+"php/view.php",info,function(data){
		$('.comments-wrapper').val("");
		viewCommentsForOffline(data);
	})
}


function viewComments(data){
	console.log(data);
	var comment = data;
	var commentLength = comment.length;
	var commentWrapper = $("#commentContainer");
	var commentText="";
	commentWrapper.html("");
	for(var i=0;i<commentLength;i++){
		var commentDate = formatDate(comment[i].comment_date);
		var comment_text = comment[i].comment_text;
		var comment_visiblity = comment[i].comment_visiblity;
		var postId = comment[i].post_id;
		var userId = comment[i].user_id;
		var commentId = comment[i].comment_id;
		var numCommentLike = comment[i].num_like;
		var numCommentUnLike = comment[i].num_unlike;
		var like = comment[i].like;
		var unlike = comment[i].unlike;
		var imageLocation;


		var userInformation = comment[i].user_info[0];
		var gender = userInformation.gender;
		var firstName = userInformation.first_name;
		var lastName = userInformation.last_name;
		var imageId = userInformation.image;
		var gender = userInformation.gender;

		
		/*Changes the image*/
		if(imageId=="" || imageId==1 || imageId==0){
    	    if(gender=="Male"){
    	        imageLocation = "./images/male_profile.jpg";
    	    }else if(gender=="Female"){
    	        imageLocation = "./images/female_profile.jpg";
    	    }
    	}else{
    	    imageLocation = "./images/"+imageId;   
    	}


		if(like){
			likeClass = "liked";
		}else{
			likeClass = "";
		}

		if(unlike){
			UnlikeClass = "unLiked";
		}else{
			UnlikeClass = "";
		}
		commentText += '<div class="row comments-container-row"><div class="col-xs-10"><div class="row"><div class="col-md-2 col-xs-3"><img src="'+imageLocation+'" class="profile-image" alt=""></div><div class="col-md-10 col-xs-9"><p class="user-name"><a href="profile.php?uid='+userId+'">'+firstName+" "+lastName+'</a></p><p>'+commentDate+'</p></div></div><div class="row"><div class="col-xs-2"></div><div class="col-xs-10"><p class="comment-text">'+comment_text+'</p></div></div><div class="row"><div class="col-lg-12 col-md-12 col-sm-12 col-xs-12"><div class="row"><div class="col-xs-2"></div><div class="col-xs-5 tab '+likeClass+'" data-commentid='+commentId+' id="likeComment"><i class="fas fa-thumbs-up"></i><span class="numCommentLike">'+numCommentLike+'</span></div><div class="col-xs-5 tab '+UnlikeClass+'" data-commentid='+commentId+' id="dislikeComment"><i class="fas fa-thumbs-down"></i><span class="numCommentDisLike">'+numCommentUnLike+'</span></div></div></div></div></div></div>';
	}
	commentWrapper.append(commentText);
}

/*------------ForOffline------------------*/
function viewCommentsForOffline(data){
	console.log(data);
	var comment = data;
	var commentLength = comment.length;
	var commentWrapper = $("#commentContainer");
	var commentText="";
	commentWrapper.html("");
	for(var i=0;i<commentLength;i++){
		var commentDate = formatDate(comment[i].comment_date);
		var comment_text = comment[i].comment_text;
		var comment_visiblity = comment[i].comment_visiblity;
		var postId = comment[i].post_id;
		var userId = comment[i].user_id;
		var commentId = comment[i].comment_id;
		var numCommentLike = comment[i].num_like;
		var numCommentUnLike = comment[i].num_unlike;
		var like = comment[i].like;
		var unlike = comment[i].unlike;
		var imageLocation;


		var userInformation = comment[i].user_info[0];
		var gender = userInformation.gender;
		var firstName = userInformation.first_name;
		var lastName = userInformation.last_name;
		var imageId = userInformation.image;
		var gender = userInformation.gender;

		
		/*Changes the image*/
		if(imageId=="" || imageId==1 || imageId==0){
    	    if(gender=="Male"){
    	        imageLocation = "./images/male_profile.jpg";
    	    }else if(gender=="Female"){
    	        imageLocation = "./images/female_profile.jpg";
    	    }
    	}else{
    	    imageLocation = "./images/"+imageId;   
    	}

		if(like){
			likeClass = "liked";
		}else{
			likeClass = "";
		}

		if(unlike){
			UnlikeClass = "unLiked";
		}else{
			UnlikeClass = "";
		}

		commentText += '<div class="row comments-container-row"><div class="col-xs-10"><div class="row"><div class="col-md-2 col-xs-3"><img src="'+imageLocation+'" class="profile-image" alt=""></div><div class="col-md-10 col-xs-9"><p class="user-name"><a href="profile.php?uid='+userId+'">'+firstName+" "+lastName+'</a></p><p>'+commentDate+'</p></div></div><div class="row"><div class="col-xs-2"></div><div class="col-xs-10"><p class="comment-text">'+comment_text+'</p></div></div><div class="row"><div class="col-lg-12 col-md-12 col-sm-12 col-xs-12"><div class="row"><div class="col-xs-2"></div><div class="col-xs-5 tab '+likeClass+'" data-commentid='+commentId+'><i class="fas fa-thumbs-up"></i><span class="numCommentLike">'+numCommentLike+'</span></div><div class="col-xs-5 tab '+UnlikeClass+'" data-commentid='+commentId+'><i class="fas fa-thumbs-down"></i><span class="numCommentDisLike">'+numCommentUnLike+'</span></div></div></div></div></div></div>';
	}
	commentWrapper.append(commentText);
}


/*Like comment*/
function likeComment(commentId){
	info = {
		"type":"likeComment",
		"commentId":commentId
	}
	$.post(BASE_URL+"php/post.php",info,function(){
		return true;
	})
}
function unLikeComment(commentId){
	info = {
		"type":"unLikeComment",
		"commentId":commentId
	}
	$.post(BASE_URL+"php/post.php",info,function(){
		return true;
	})
}



/*------------Parameter Function----------------*/
/*
	encode and decode URL
	
	To encode: encodeURI(str)
	To decode: decodeURI(str)

		USE
	var number = getUrlVars()["x"];
	var mytext = getUrlVars()["text"];

	var mytext = getUrlParam('text','Empty');

*/
function getUrlVars() {
    var vars = {};
    var parts = window.location.href.replace(/[?&]+([^=&]+)=([^&]*)/gi, function(m,key,value) {
        vars[key] = value;
    });
    return vars;
}
function getUrlParam(parameter, defaultvalue){
    var urlparameter = defaultvalue;
    if(window.location.href.indexOf(parameter) > -1){
        urlparameter = getUrlVars()[parameter];
        }
    return urlparameter;
}

function formatDate(date){
	var date = date.split(" ")[0].split("-");
	return date[1]+"/"+date[2]+"/"+date[0];
}

function postStatus(text){
	var info = {
		"type":"postStatus",
		"statusText":text
	}
	$.post(BASE_URL+"php/post.php",info,function(){
		$(".status").html(text);
		$(".status-message").removeClass("hide");
		return true;
	})
}
function getStatus(){
	var info = {
		"type":"postStatus",
		"statusText":text
	}
	$.post(BASE_URL+"php/post.php",info,function(){
		$(".status").html(text);
		$(".status-message").removeClass("hide");
		return true;
	})
}

function updateProfile(form){
	var info = form.serialize();
		info += "&type=updateProfile";
	
		$.post(BASE_URL+"php/post.php",info,function(){
			$(".update-profile-message").removeClass("hide");
			getMyProfile();
			return true;
		})
}