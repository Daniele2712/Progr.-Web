
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








/* SCRIPT PER profile.tpl */

$("#bars").click(function(){
        $('#dropdownMenu').slideToggle('slow');
    });


/* --------------------------- */