$(document).ready(function(){
    
    ricaricaCarrello();
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

function addToCart(that){
    //$("#quantityOfProduct{$prodotto.id}").val(),{$prodotto.id}, $.cookie("PHPSESSID")
  
    //CODICE CHE LO AGGIUNGE AL CARELLO
    var number=$(that).prev().prev().val();     //navigo nel dom per prendere il valore dentro al input x i numeri
    $(that).prev().prev().val("");
    var imageurl=$(that).parent().parent().children().first().attr('src');    //mavogp nel Dom per prendere il src della immagine 
    var imageArray = imageurl.split("/");    //soltanto per poi esplodere l-url in base al /
    var id= imageArray[imageArray.length-1];    //e prendere il numeretto finale, che rappresenta l-id del prodototto che voglio inserire
    var sessid=$.cookie("PHPSESSID");
    if(!isNaN(number) && number>0)      //validazione lato client
    {
    $.ajax({
        url:"http://webb/api/ApiController/aggiungiProdotto",
        method:"POST",
        dataType:"json",
        data:{productId:id,quantity:number,PHPSESSID:sessid},
                
                
        success:function(responose){   
         ricaricaCarrello();
              },
            
        
        error:function(req, text, error){
            console.debug(text);
            console.debug(error);
            console.debug(req);
        }
    })
    }
    else{
        console.log("errore dovuto alla validazione del numero : '"+number+"'");
    }
  
};

function ricaricaCarrello(){
    $('.cartList').children().remove();
    
    $.ajax({
        url:"http://webb/api/ApiController/carrello",
        method:"GET",
        dataType:"json",
        success:function(arrayDiRisposta){      //mi sa che r gia un oggetto, non e json
            jQuery.each( arrayDiRisposta['inListProducts'], function( i, prodotto ) { //Devo fare una funzione che trasforma la valuta in elementi HTML
               var newProduct= '<div class="inListProduct">\
                                    <span>'+prodotto['quantita']+'</span>\
                                    <span> x </span>\
                                    <span>'+prodotto['nome']+'</span>\
                                    <span class="prezzo">'+prodotto['item_valuta']+' '+prodotto['item_prezzo']+'</span>\
                                </div>'
                $( ".cartList" ).append(newProduct);
              });
        var total =    '<div id="cart_total">\
                            <span id="totale_nome"> TOTALE </span>\
                            <span class="prezzo_totale">'+arrayDiRisposta['totale_valuta']+' '+arrayDiRisposta['totale_prezzo'] +'</span>\
                        </div>'  
        $('.cartList').append(total);      
            
        },
        error:function(req, text, error){
            ajax_error(req, text, error);
        }
    })
    
    


};

function convertValuta(x){
    
     switch(x){
        case 'EUR':
            return 'eeee';
            
        case 'EUR':
            return 'eeee';
        case 'EUR':
            return 'eeee';
            
        case 'EUR':
            return 'eeee';
            
        case 'EUR':
            return 'eeee';
            
        case 'EUR':
            return 'eeee';
            
        
        default: return '???';
    }
}

