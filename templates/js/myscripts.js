
  /*
  $( "#but3" ).click(function() {
  $( "#loginbox" ).toggle("slow");
});
 */

 $("#loginbutton").click(function(){
        $('#loginbox').slideToggle('slow');
        if($('#registerbox').css('display') === 'block') {$('#registerbox').slideToggle('slow');}
    });
    
$("#registerbutton").click(function(){
    $('#registerbox').slideToggle('slow');
    if($('#loginbox').css('display') === 'block') {$('#loginbox').slideToggle('slow');}
});


function showInfo(){
  
    /* FAI LA CHIAMATA AJAX CHE TI DICE LE INFOO PRESE DAL DATABASE*/
    
};


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
  
    //CODICE CHE LO AGGIUNGE AL CARELLO
    
  $(that).prev().prev().val("");
};





/* SCRIPT PER profile.tpl */

$("#bars").click(function(){
        $('#dropdownMenu').slideToggle('slow');
    });


/* --------------------------- */