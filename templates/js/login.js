$(document).ready(function(){
        
$("#loginbutton").click(function(){
        $('#loginbox').slideToggle('slow');
        if($('#registerbox').css('display') === 'block') {$('#registerbox').slideToggle('slow');}
    });
    
$("#registerbutton").click(function(){
    $('#registerbox').slideToggle('slow');
    if($('#loginbox').css('display') === 'block') {$('#loginbox').slideToggle('slow');}
});
   });




