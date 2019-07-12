$("document").ready(function(){
	$("body").on("submit","#loginForm",function(){
		var email = $("[name='email']");
		var password = $("[name='password']");
		var erorrContainer = $(".login-info");
		if(password.val()==0 && email.val()==0){
			password.css("border","1px solid black");
			email.css("border","1px solid black");
			erorrContainer.html("You have to fill the forms");
			erorrContainer.slideDown();
			password.css("border","2px solid red");
			email.css("border","2px solid red");
			return false;
		}else if(email.val()==0){
			password.css("border","1px solid black");
			erorrContainer.html("Email address can't be empty");
			erorrContainer.slideDown();
			email.css("border","2px solid red");
			return false;
		}else if(password.val()==0){
			email.css("border","1px solid black");
			erorrContainer.html("Password can't be empty");
			erorrContainer.slideDown();
			password.css("border","2px solid red");
			return false;
		}else{
			loginUser($(this));
		}
		return false;
	});
	$("body").on("submit","#registerForm",function(){
		var firstName = $("[name='firstName']");
		var lastName = $("[name='lastName']");
		var birthDate = $("[name='birthDate']");
		var gender = $("[name='gender']");
		var email = $("[name='userEmail']");
		var password = $("[name='userPassword']");
		var erorrContainer = $(".register-info");
		if(firstName.val()==""){
			erorrContainer.slideDown();
			erorrContainer.html("First name is required");
			firstName.css("border","2px solid red");
			return false;
		}else if(lastName.val()==""){
			erorrContainer.slideDown();
			erorrContainer.html("Last name is required");
			lastName.css("border","2px solid red");
			return false;
		}else if(gender.val()==""){
			erorrContainer.slideDown();
			erorrContainer.html("Please select gender");
			gender.css("border","2px solid red");
			return false;
		}else if(birthDate.val()==""){
			erorrContainer.slideDown();
			erorrContainer.html("Birth day is required");
			birthDate.css("border","2px solid red");
			return false;
		}else if(email.val()==""){
			erorrContainer.slideDown();
			erorrContainer.html("Email is required");
			email.css("border","2px solid red");
			return false;
		}else if(password.val() == ""){
			erorrContainer.slideDown();
			erorrContainer.html("Password is required");
			password.css("border","2px solid red");
			return false;
		}else if(password.val().length < 4){
			erorrContainer.slideDown();
			erorrContainer.html("Password is short");
			password.css("border","2px solid red");
			return false;
		}else{
			erorrContainer.slideUp();
			registerUser($(this));
			password.css("border","1px solid black");
			return false;
		}
		//return false;
	});

	//Gets the post by category
	$("body").on("click","#topics",function(){
		var topicId = $(this).data("topicid");
		$("button").removeClass("selected");
		var topicId = $(this).data("topicid");
		$(this).addClass("selected");
		if(topicId==0){
			getAllPosts(10);
		}
		getPostsByCategory(topicId,10);
	  })
	  
	  
	/*COntrolls the show More button*/
	$("body").on("click","#showMore",function(){
		numLimitPost = numLimitPost + 6;
		getAllPosts(numLimitPost);
	});
	$("body").on("click","#showMoreCategory",function(){
		numLimitCategory = numLimitCategory + 6;
		var topicId = $("button#topics.selected").data("topicid");
		getPostsByCategory(topicId,numLimitCategory);
	});

	$("body").on("click","#showMoreForOffline",function(){
		numLimitPost = numLimitPost + 6;
		getAllPostsForOffline(numLimitPost);
	});
	$("body").on("click","#showMoreCategoryForOffline",function(){
		numLimitCategory = numLimitCategory + 6;
		var topicId = $("button#topics.selected").data("topicid");
		getPostsByCategoryForOffline(topicId,numLimitCategory);
		
	});

	/*Comment button clicked*/
	$("body").on("click","#comment",function(){
		var postId = $(this).data("postid");
		window.location.href = './viewpost.php?pid='+postId;
		//getPostsById(postId);
		return false;
	})
	$("body").on("click","#commentForOffline",function(){
		var postId = $(this).data("postid");
		window.location.href = './viewpost1.php?pid='+postId;
		//getPostsById(postId);
		return false;
	})
	/*$("body").on("click",".readMore",function(){
		var postId = $(this).data("post-id");
		getPostsById(postId);
		return false;
	})*/
	$("body").on("click","#like",function(){
		var postId = $(this).data("postid");
		likePost(postId);
		var postId = $(this).data("postid");
		var postLike = $("[id='like'][data-postid="+postId+"] [class='numLike']");
		var likeButton = $("[id='like'][data-postid="+postId+"]");
		var postLikeNum = parseInt(postLike.html());

		var postDislike = $("[id='dislike'][data-postid="+postId+"] [class='numDislike']");
		var dislikeButton = $("[id='dislike'][data-postid="+postId+"]");
		var dislikeNum = parseInt(postDislike.html());
			
		if(likeButton.hasClass("liked")){
			postLike.html(postLikeNum-1);
			likeButton.removeClass("liked");
		}else{
			postLike.html(postLikeNum+1);
			likeButton.addClass("liked");
			if(dislikeButton.hasClass("unLiked")){
				postDislike.html(dislikeNum-1);
				dislikeButton.removeClass("unLiked");
			}
		}
		return false;
	});

	/*Unlike Post*/
	$("body").on("click","#dislike",function(){
		var postId = $(this).data("postid");
		unLikePost(postId);
		var postId = $(this).data("postid");
		var postLike = $("[id='like'][data-postid="+postId+"] [class='numLike']");
		var likeButton = $("[id='like'][data-postid="+postId+"]");
		var postLikeNum = parseInt(postLike.html());

		var postDislike = $("[id='dislike'][data-postid="+postId+"] [class='numDislike']");
		var dislikeButton = $("[id='dislike'][data-postid="+postId+"]");
		var dislikeNum = parseInt(postDislike.html());
			
		if(dislikeButton.hasClass("unLiked")){
				postDislike.html(dislikeNum-1);
				dislikeButton.removeClass("unLiked");
		}else{
			postDislike.html(dislikeNum+1);
			dislikeButton.addClass("unLiked");
			if(likeButton.hasClass("liked")){
				postLike.html(postLikeNum-1);
				likeButton.removeClass("liked");
			}
		}
		return false;
	});


	/*Comment like*/

	$("body").on("click","#likeComment",function(){
		var commentId = $(this).data("commentid");
		likeComment(commentId);

		var commentId = $(this).data("commentid");
		
		var commentLike = $("[id='likeComment'][data-commentid="+commentId+"] [class='numCommentLike']");
		var likeButton = $("[id='likeComment'][data-commentid="+commentId+"]");
		var commentLikeNum = parseInt(commentLike.html());

		var postDislike = $("[id='dislikeComment'][data-commentid="+commentId+"] [class='numCommentDisLike']");
		var dislikeButton = $("[id='dislikeComment'][data-commentid="+commentId+"]");
		var dislikeNum = parseInt(postDislike.html());
			
		if(likeButton.hasClass("liked")){
			commentLike.html(commentLikeNum-1);
			likeButton.removeClass("liked");
		}else{
			commentLike.html(commentLikeNum+1);
			likeButton.addClass("liked");
			if(dislikeButton.hasClass("unLiked")){
				postDislike.html(dislikeNum-1);
				dislikeButton.removeClass("unLiked");
			}
		}
	})
	/*Commment unlike*/
	$("body").on("click","#dislikeComment",function(){
		var commentId = $(this).data("commentid");
		unLikeComment(commentId);

		var commentId = $(this).data("commentid");

		var commentLike = $("[id='likeComment'][data-commentid="+commentId+"] [class='numCommentLike']");
		var likeButton = $("[id='likeComment'][data-commentid="+commentId+"]");
		var commentLikeNum = parseInt(commentLike.html());

		var postDislike = $("[id='dislikeComment'][data-commentid="+commentId+"] [class='numCommentDisLike']");
		var dislikeButton = $("[id='dislikeComment'][data-commentid="+commentId+"]");
		var commentDisLikeNum = parseInt(postDislike.html());
			
		if(dislikeButton.hasClass("unLiked")){
				postDislike.html(commentDisLikeNum-1);
				dislikeButton.removeClass("unLiked");
		}else{
			postDislike.html(commentDisLikeNum+1);
			dislikeButton.addClass("unLiked");
			if(likeButton.hasClass("liked")){
				commentLike.html(commentLikeNum-1);
				likeButton.removeClass("liked");
			}
		}
		return false;

	})

	$("body").on("submit","#postForm",function(){
		var category = $("[name='category']");
		var postTitle = $("[name='postTitle']");
		var postText = $("[name='postText']");

		if(category.val() != "" && postTitle.val().trim() != "" && postText.val().trim() != "" && postText.val().trim() != "<br>"){
				insertPost($(this));
		}else{
			$(".err").slideDown();
		}
		return false;
	})

	$("body").on("submit","#updateForm",function(){
		var category = $("[name='category']");
		var postTitle = $("[name='postTitle']");
		var postText = $("[name='postText']");

		if(category.val() != "" && postTitle.val().trim() != "" && postText.val().trim() != "" && postText.val().trim() != "<br>"){
			updatePost($(this));
		}else{
			$(".err").slideDown();
		}
		return false;
	})

	$("body").on("submit","#commentForm",function(){
		var postId = $(this).data("post-id");
		var commentText = $("[name='commentText']");
		if(commentText.val().trim()==""){
			commentText.css("border","2px solid red");
			return false;
		}else{
			postComment($(this));
		}
		return false;
	})
});	