$(document).ready(function(){
        
$("#loginbutton").click(function(){
        $('#loginbox').slideToggle('slow',function() {$('#loginUsername').focus()});        //dopo il slow c-e la funzione ch eviene chiamata una volta finita l-animazione del toggle
        
        if($('#registerbox').css('display') === 'block') {$('#registerbox').slideToggle('slow');}   
    });
    
$("#registerbutton").click(function(){
    $('#registerbox').slideToggle('slow');
    if($('#loginbox').css('display') === 'block') {$('#loginbox').slideToggle('slow');}
});
   });




