$(function(){
    $("#dialog #start").click(function(){
        if(logged===false)
            guest_shop();
        else
        {
            if(logged==="Gestore") gestore_shop();  /*  vorrei fare in modo di non arrivare fino a qui  , cioe far loggare direttamente il gestore oppure l'amministratore  */
                else user_shop();
        }
    });
    $("#dialog #guest_address .next").click(add_address);
    $("#dialog #user_address .next").click(use_default_address);
    $("#dialog #user_address .change").click(show_addresses);
    $("#dialog #user_addresses #add_new").click(add_user_address);
    $("#dialog #new_user_address .next").click(save_user_address);

})

function guest_shop(){
    $("#dialog #shop_button").hide();
    $("#dialog #guest_address").show();
    $("#dialog #guest_address input:first").focus();
}

function add_address(){
    $.ajax({
        url:"/api/carrello/address/add",
        method:"POST",
        dataType:"json",
        data: $("#dialog #guest_address input").serialize(),
        success:function(data){
            ajax_common(data, function(data){
                $("#dialog #guest_address .message").html("<p class='message_error'>"+data.msg+"</p>");
            });
            if(data.r==200){
                location.href="/spesa/catalogo";
            }
        },
        error:function(req, text, error){
            ajax_error(req, text, error);
        }
    });
}

function user_shop(){
    $.ajax({
        url:"/api/user/addresses",
        method:"GET",
        dataType:"json",
        success:function(data){
            ajax_common(data);
            if(data.r==200){
                var p = data.preferito;
                $("#dialog #user_address #location").html(p.comune+" ("+p.provincia+"), "+
                    p.via+" n&deg;"+p.civico+"<br/>"+p.note);
                for(i in data.indirizzi){
                    var p = data.indirizzi[i];
                    $("#dialog #user_addresses #locations").append("<div class='location' data-id='"+p.id+"'>"+p.comune+" ("+p.provincia+"), "+
                        p.via+" n&deg;"+p.civico+"<br/>"+p.note+"</div>");
                }
                $("#dialog #user_addresses .location").click(use_address);
                $("#dialog #start").hide();
                $("#dialog #user_address").show();
            }
        },
        error:function(req, text, error){
            ajax_error(req, text, error);
        }
    });
}

function use_default_address(){
    $.ajax({
        url:"/api/carrello/address/default",
        method:"POST",
        dataType:"json",
        success:function(data){
            ajax_common(data);
            if(data.r==200){
                location.href="/spesa/catalogo";
            }
        },
        error:function(req, text, error){
            ajax_error(req, text, error);
        }
    });
}

function show_addresses(){
    $("#dialog #user_addresses").show();
    $("#dialog #user_address").hide();
}

function use_address(obj){
    $.ajax({
        url:"/api/carrello/address/"+$(obj.target).attr("data-id"),
        method:"POST",
        dataType:"json",
        success:function(data){
            ajax_common(data);
            if(data.r=200){
                location.href="/spesa/catalogo";
            }
        },
        error:function(req, text, error){
            ajax_error(req, text, error);
        }
    });
}

function add_user_address(){
    $("#dialog #user_addresses").hide();
    $("#dialog #new_user_address").show();
    $("#dialog #new_user_address input:first").focus();
}

function save_user_address(){
    $.ajax({
        url:"/api/carrello/address/add",
        method:"POST",
        dataType:"json",
        data: $("#dialog #new_user_address input").serialize(),
        success:function(data){
            ajax_common(data, function(data){
                $("#dialog #new_user_address .message").html("<p class='message_error'>Indirizzo non trovato</p>")
            });
            if(data.r==200){
                location.href="/spesa/catalogo";
            }
        },
        error:function(req, text, error){
            ajax_error(req, text, error);
        }
    });
}

function gestore_shop(){
    location.href="/shop/gestore";
}
