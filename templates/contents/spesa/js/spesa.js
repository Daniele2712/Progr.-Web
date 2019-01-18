$(document).ready(function(){
    $("#payButton").click(function(){
        location.href="/checkout/displaycheckout";
    });
});



function popupToggle(number){
$("#moreabout"+number).toggle('slow');
}

// nelle prossime 2 funzioni, prev prende il fratello che sta prima, next quello che sta dopo
function subtractOne(that){
    if(parseInt($(that).next().val())>1)
    $(that).next().val(parseInt($(that).next().val())-1);
    else $(that).next().val(0);
};

function addOne(that){
   if($(that).prev().val()=="")   $(that).prev().val(1);
   else $(that).prev().val(parseInt($(that).prev().val())+1);

};

function addToCart(obj, id){
    //CODICE CHE LO AGGIUNGE AL CARELLO
    var input = $(obj).closest(".item").find(".qta");
    var qta = input.val();                                  //navigo nel dom per prendere il valore dentro al input x i numeri
    if(!isNaN(qta) && qta>0){                               //validazione lato client
        $.ajax({
            url:"/api/carrello/add/"+id+"/"+qta,
            method:"POST",
            dataType:"json",
            success:function(r){
                setCookie("CSRF",r.CSRF);
                input.val(r.qta);
                if(r.r==200){
                    updateCarrello(r.carrello);
                }
            },
            error:function(req, text, error){
                ajax_error(req, text, error);
            }
        })
    }else
        console.log("errore dovuto alla validazione del numero : '"+qta+"'");
};

function ricaricaCarrello(){
    $.ajax({
        url:"/api/carrello",
        method:"GET",
        dataType:"json",
        success:function(r){    //è gia un oggetto, non è json
            updateCarrello(r);
        },
        error:function(req, text, error){
            ajax_error(req, text, error);
        }
    });
}

function updateCarrello(data){
    $('.cartList').children().remove();
    var html = "";
    for(var i in data["items"]){    //Devo fare una funzione che trasforma la valuta in elementi HTML, ???
        var prodotto = data["items"][i];
        html += '<div class="inListProduct" data-id="' +
            prodotto['id'] + '"><div>' +
            prodotto['quantita'] + '</div><div class="nome">' +
            prodotto['nome'] + '</div><div class="prezzo">' +
            data['valuta'] + ' ' +
            prodotto['prezzo'] + '</div></div>';
    }
    $(".cartList").append(html);
    $("#prezzo_totale").html(data['valuta'] + ' ' + data['totale']);
}
