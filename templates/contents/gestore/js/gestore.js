$(document).ready(function(){
        
$("#inserisciProdotto").click(function(){
    if($('#updateProdottoDiv').css('display') === 'block') {$('#updateProdottoDiv').slideToggle('slow');}
    if($('#inserisciCategoriaDiv').css('display') === 'block') {$('#inserisciCategoriaDiv').slideToggle('slow');}
    if($('#updateOfferteDiv').css('display') === 'block') {$('#updateOfferteDiv').slideToggle('slow');}
    if($('#inserisciProdottoDiv').css('display') === 'none') {$('#inserisciProdottoDiv').slideToggle('slow');}
     
});   
     
     
     
$("#updateProdotto").click(function(){
    if($('#inserisciProdottoDiv').css('display') === 'block') {$('#inserisciProdottoDiv').slideToggle('slow');}
    if($('#inserisciCategoriaDiv').css('display') === 'block') {$('#inserisciCategoriaDiv').slideToggle('slow');}
    if($('#updateOfferteDiv').css('display') === 'block') {$('#updateOfferteDiv').slideToggle('slow');}
    if($('#updateProdottoDiv').css('display') === 'none') {$('#updateProdottoDiv').slideToggle('slow');}
     
}); 

$("#inserisciCategoria").click(function(){
    if($('#inserisciProdottoDiv').css('display') === 'block') {$('#inserisciProdottoDiv').slideToggle('slow');}
    if($('#updateProdottoDiv').css('display') === 'block') {$('#updateProdottoDiv').slideToggle('slow');}
    if($('#updateOfferteDiv').css('display') === 'block') {$('#updateOfferteDiv').slideToggle('slow');}
    if($('#inserisciCategoriaDiv').css('display') === 'none') {$('#inserisciCategoriaDiv').slideToggle('slow');}
     
});

$("#inserisciOfferte").click(function(){
    if($('#inserisciProdottoDiv').css('display') === 'block') {$('#inserisciProdottoDiv').slideToggle('slow');}
    if($('#updateProdottoDiv').css('display') === 'block') {$('#updateProdottoDiv').slideToggle('slow');}
    if($('#inserisciCategoriaDiv').css('display') === 'block') {$('#inserisciCategoriaDiv').slideToggle('slow');}
    if($('#inserisciOfferteDiv').css('display') === 'none') {$('#inserisciOfferteDiv').slideToggle('slow');}
     
});
    
});