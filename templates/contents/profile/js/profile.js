$(document).ready(function(){
    $("#profile #bars").click(function(){
        $('#profile #dropdownMenu').slideToggle('slow');
    });
    $("#profile #logout_button").click(function(){
        $.ajax({
            url:"/user/logout",
            method:"GET",
            success:function(){
                location.href = "/spesa/home";
            },
            error:function(req, text, error){
                ajax_error(req, text, error);
            }
        });
    });

    $("#goToProfile").click(function(){
        location.href="/spesa/profilo";
    });
    $("#goToCarrello").click(function(){
         location.href="/spesa/checkout";
    });
    $("#goToOrdini").click(function(){
         location.href="/spesa/ordini";
    });

});
