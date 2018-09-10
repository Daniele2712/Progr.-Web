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
  
    //CODICE CHE LO AGGIUNGE AL CARELLO
    
  $(that).prev().prev().val("");
};
