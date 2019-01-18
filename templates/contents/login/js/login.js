$(document).ready(function(){
    $("#login #loginbutton").click(function(){
        $('#login #loginbox').slideToggle(
            'slow',
            function(){ //funzione che viene chiamata una volta finita l'animazione del toggle
                $('#loginUsername').focus();
            }
        );
        if($('#login #registerbox').css('display') === 'block'){
            $('#login #registerbox').slideToggle('slow');
        }
    });
    $("#login #registerbutton").click(function(){
        $('#login #registerbox').slideToggle(
            'slow',
            function(){

            }
        );
        if($('#login #loginbox').css('display') === 'block'){
            $('#login #loginbox').slideToggle('slow');
        }
    });
    $("#login #login_submit").click(login);
    $("#login #loginbox input").keypress(function(e){
        if(e.which ==  13 && $("#login #loginbox #loginUsername").val()!="" && $("#login #loginbox #loginPassword").val()!="")
            login();
    })
});

function login(){
    $.ajax({
        url:"/user/login",
        method:"POST",
        dataType:"json",
        data:$("#login #loginbox input").serialize(),
        success:function(data){
            console.log("success");
            if(data.r===200){   //sembra che non uso le variabile ritornate dalla post tmp[r] e tmp[type]
                $("#login #message").html("<p class='message_ok'>Reloading</p>").show();
                location.reload();      //la differenza sara' che ora ci sara una sessione con un utente loggato
            }else{
                $("#login #message").html("<p class='message_error'>Wrong Username or Password</p>").show();
                $("#login #loginbox #loginPassword").val("");
                $("#login #loginbox #loginUsername").select();
            }
        },
        error:function(req, text, error){
            console.log(req);
            console.log(text);
            console.log(error);
            ajax_error(req, text, error);
        }
    });
}
