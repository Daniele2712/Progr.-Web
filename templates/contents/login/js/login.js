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

    $("#login #register_button").click(register);
    checkPassword();
});

function login(){
    $.ajax({
        url:"/user/login",
        method:"POST",
        dataType:"json",
        data:$("#login #loginbox input").serialize(),
        success:function(data){
            console.log(data);
            console.log("success");
            if(data.r===200){   //sembra che non uso le variabile ritornate dalla post tmp[r] e tmp[type]
                $("#login #message").html("<p class='message_ok'>Reloading</p>").show();
                if(data.type==='Cliente') location.reload();    //la differenza sara' che ora ci sara una sessione con un utente loggato
                else if(data.type==='Amministratore') window.location.replace("/shop/amministratore");
                else if(data.type === 'Gestore') window.location.replace("/shop/gestore");
                else $("#login #message").html("<p class='message_error'>Tipo di utente non trovato</p>").show();
                }
            else{
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
function register(){
    $.ajax({
        url:"/api/user/",
        method:"POST",
        dataType:"json",
        data:"cmd=register&"+$("#login #registerbox input").serialize(),
        success:function(data){
            if(data.r===200){   //sembra che non uso le variabile ritornate dalla post tmp[r] e tmp[type]
                location.reload();    //la differenza sara' che ora ci sara una sessione con un utente loggato
            }
        },
        error:function(req, text, error){
            ajax_error(req, text, error);
        }
    });
}

function checkPassword(){
    $('#registerPassword, #confermaPassword').on('keyup', function () {
  if ($('#registerPassword').val() == $('#confermaPassword').val()) {
    $('#samePass').html('');
  } else
    $('#samePass').html('Not Matching').css('color', 'red');
  });
}
