/* 
    Henok Tasissa
 */
$(document).ready(function(){
    if ($.cookie('token') && $.cookie('userId')){
        var cookieUserId = $.cookie("userId");
        var cookieToken = $.cookie("token");
        loginWithToken(cookieUserId,cookieToken);
   }else{
        registerAndLogin();
   }
   resetForm();

    $("#addTodoButton").on("click",function(){
        $("#statusInfoContainer").hide();
        $("#viewTodoButton").removeClass("active");
        $(".todo-info").hide();
        $(this).addClass("active");
        $("#todoAddPage").fadeIn();
        $("#todoViewPage").hide();
        $("#updateTodoPage").hide();
        $("#todoUpdatePage").hide();
        resetForm();
    })
    $("#viewTodoButton").on("click",function(){
        $("#addTodoButton").removeClass("active");
        $(this).addClass("active");
        $("#todoAddPage").hide();
        $("#todoUpdatePage").hide();
        viewAllTodo();
        $("#statusInfoContainer").show();
        $("#todoViewPage").fadeIn();
    })
    
    $("#addTodoForm").on("submit",function(){
        var todoDate = $("[name = 'todoDate']");
        var todoTitle = $("[name = 'todoTitle']");
        var todoText = $("[name = 'todoText']");
        var todoInfo = $(".todo-info");


        if(todoDate.val() == ""){
            todoInfo.hide();
            todoInfo.html("Please select a date");
            todoDate.css("border","2px solid red");
            todoInfo.slideDown();
        }else if(todoTitle.val() == ""){
            todoInfo.hide();
            todoTitle.css("border","2px solid red");
            todoDate.css("border","1px solid black");
            todoInfo.html("Please write your title");
            todoInfo.slideDown();
        }else if(todoText.val()==""){
            todoInfo.hide();
            todoText.css("border","2px solid red");
            todoTitle.css("border","1px solid black");
            todoInfo.html("Please write todo description.");
            todoInfo.slideDown();
        }else{
            todoInfo.hide();
            todoText.css("border","1px solid black");
            todoInfo.css("backgroundColor","lightgreen");
            todoInfo.html("You have added your todo.");
            todoInfo.slideDown();
            addTodo($(this));
            todoTitle.val("");
            todoText.val("");
            todoDate.val("");
        }
        //console.log($(this).serialize());
        return false;
    })

    $("body").on("click",".edit",function(){
        var userId = $(this).data("userid");
        var todoId = $(this).data("todoid");
        $("#viewTodoButton").removeClass("active");
        $(".todo-info").hide();
        $("#addTodoButton").addClass("active");
        $("#todoUpdatePage").fadeIn();
        getSingleTodo(userId,todoId);
        $("#statusInfoContainer").hide();
        $("#todoAddPage").hide();
        $("#todoViewPage").hide();
        return false;
    });
    
    $("body").on("click",".complete",function(){
        var todoId = $(this).data("todoid");
        completeTodo(todoId);
        $(".todo-"+todoId).removeClass("crossed");
        $(".todo-"+todoId).css("background-color","lightgreen");
        return false;
    });
    
    $("body").on("click",".cross",function(){
        var todoId = $(this).data("todoid");
        crossTodo(todoId);
        $(".todo-"+todoId).removeClass("completed");
        $(".todo-"+todoId).css("background-color","rgba(192, 46, 46, 0.76)");
        return false;
    });

    $("body").on("click",".remove",function(){
        var todoId = $(this).data("todoid");
        removeTodo(todoId);
        $(".todo-"+todoId).fadeOut();
        return false;
    });
    

    $("#updateTodo").on("submit",function(){
        var todoDate = $("[name = 'todoDate']");
        var todoTitle = $("[name = 'todoTitle']");
        var todoText = $("[name = 'todoText']");
        var todoInfo = $(".todo-info");


        if(todoDate.val() == ""){
            todoInfo.hide();
            todoInfo.html("Please select a date");
            todoDate.css("border","2px solid red");
            todoInfo.slideDown();
        }else if(todoTitle.val() == ""){
            todoInfo.hide();
            todoTitle.css("border","2px solid red");
            todoDate.css("border","1px solid black");
            todoInfo.html("Please write your title");
            todoInfo.slideDown();
        }else if(todoText.val()==""){
            todoInfo.hide();
            todoText.css("border","2px solid red");
            todoTitle.css("border","1px solid black");
            todoInfo.html("Please write todo description.");
            todoInfo.slideDown();
        }else{
            todoInfo.hide();
            todoText.css("border","1px solid black");
            todoInfo.css("backgroundColor","lightgreen");
            todoInfo.html("You have Updated your todo.");
            todoInfo.slideDown();
            updateTodo($(this));
            todoTitle.val("");
            todoText.val("");
            todoDate.val("");
        }
        //console.log($(this).serialize());
        return false;
    })
})