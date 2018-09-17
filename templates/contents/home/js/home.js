$(document).ready(function(){
    $("#dialog #start").click(function(){
        if(logged===false)
            guest_shop();
        else
            user_shop();
    })
})

function guest_shop(){
    $("#dialog #start").hide();
    $("#dialog #guest_address").show();
}

function user_shop(){
    $.ajax({
        url:"/api/user/addresses",
        method:"GET",
        dataType:"json",
        success:function(data){
            $("#dialog #start").hide();
            $("#dialog #user_address").show();

        },
        error:function(req, text, error){
            ajax_error(req, text, error);
        }
    })
}


function login(){
    $.ajax({
        url:"/user/login2",
        method:"POST",
        data:"username=rossi&password=rossi",
        dataType:"json",
        success:function(data){
            console.log(data);
        },
        error:function(req, text, error){
            ajax_error(req, text, error);
        }
    })
}
