/* 
    Henok Tasissa
 */
var BASE_URL = "php/";

function resetForm(){
    var todoDate = $("[name = 'todoDate']");
    var todoTitle = $("[name = 'todoTitle']");
    var todoText = $("[name = 'todoText']");
    todoDate.val("");
    todoTitle.val("");
    todoText.val("");
}
function loginWithToken(userId,token){
    info = {
        'type':"loginWithToken",
        'userId':userId,
        'token':token
    }
    $.post(BASE_URL+"controller.php",info,function(data){

    });
}
function format(inputDate) {
    var date = new Date(inputDate);
    if (!isNaN(d.getTime())) {
        // Months use 0 index.
        return date.getMonth() + 1 + '/' + date.getDate() + '/' + date.getFullYear();
    }
}
function registerAndLogin(){
    info = {
        'type':"registerAndLogin"
    }
    $.post(BASE_URL+"controller.php",info,function(data){
        userInfo = data;
        $.cookie("userId", userInfo.userId, { expires : 600});
        $.cookie("token", userInfo.token, { expires : 600 });
        
        console.log($.cookie("userId"));
    });
}
function addTodo(todo){
    var todoData = todo.serialize();
        todoData += "&type=postTodo";

    $.post(BASE_URL+"controller.php",todoData,function(data){
        console.log(data);
    });
}

function updateTodo(todo){
    var todoInfo = todo.serialize();
        todoInfo += "&type=updateTodo";
    $.post(BASE_URL+"controller.php",todoInfo,function(data){
        console.log(data);
    })
    return false;
}
function completeTodo(todoId){
    var todoInfo = {
        "todoId":todoId,
        "todoStatus":"completed",
        "type":"updateStatus"
    };
    $.post(BASE_URL+"controller.php",todoInfo,function(data){
        console.log(data);
    })
    return false;
}

function crossTodo(todoId){
    var todoInfo = {
        "todoId":todoId,
        "todoStatus":"crossed",
        "type":"updateStatus"
    };
    $.post(BASE_URL+"controller.php",todoInfo,function(data){
        console.log(data);
    })
    return false;
}

function removeTodo(todoId){
    var todoInfo = {
        "todoId":todoId,
        "type":"removeTodo"
    };
    $.post(BASE_URL+"controller.php",todoInfo,function(data){
        console.log(data);
    })
    return false;
}

function getSingleTodo(userId,todoId){
    var cookieUserId = $.cookie("userId");
    var cookieToken = $.cookie("token");
    var info = {
        "type":"getSingleTodo",
        "userId" : cookieUserId,
        "todoId" : todoId
    }
    $.post(BASE_URL+"controller.php",info,function(data){
        var userId = data.user_id;
        var todoId = data.id;
        var todoTitle = data.todo_title;
        var todoDate = data.todo_date;
        var todoText = data.todo_text;
        $("[name = 'userId']").val(userId);
        $("[name = 'todoId']").val(todoId);
        $("[name = 'todoDate']").val(todoDate);
        $("[name = 'todoTitle']").val(todoTitle);
        $("[name = 'todoText']").val(todoText);
    });
}
function viewAllTodo(){
    var cookieUserId = $.cookie("userId");
    var cookieToken = $.cookie("token");
    info = {
        'type':'viewAllTodo',
        'userId':cookieUserId,
        'token':cookieToken
    };
    $.post(BASE_URL+"controller.php",info,function(data){
        var main = $("#todoViewPage");
        main.html("");
        for(var i=0; i<data.length; i++){
            var todoId = data[i].id;
            var userId = data[i].user_id;
            var todoTitle = data[i].todo_title;
            var todoDate = data[i].todo_date;
            var todoStatus = data[i].todo_status;
            var todoText = data[i].todo_text;
            var todoStatClass = "";
            if(todoStatus == "crossed"){
                todoStatClass = "crossed";
            }else if(todoStatus == "completed"){
                todoStatClass = "completed"
            }
            var todoList = '<div class="todo-'+todoId+" "+todoStatClass+'"><div><div><h1 class="todoTitle">'+todoTitle+'</h1><p class="todoText">'+todoText+'</p><span class="date-container">'+todoDate+'</span></div><div class="todoOptionContainer"><div><a href="#" class="edit" data-userId = '+userId+' data-todoId='+todoId+'><i class="fas fa-edit"></i></a></div><div><a href="#" class="complete" data-userId = '+userId+' data-todoId='+todoId+'><i class="fas fa-check"></i></a></div><div><a href="#" class="cross" data-userId = '+userId+' data-todoId='+todoId+'><i class="fas fa-times"></i></a></div><div><a href="#" class="remove" data-userId = '+userId+' data-todoId='+todoId+'><i class="fas fa-trash"></i></a></div></div></div></div>';
            main.append(todoList);
        }
    });
}