$(document).ready(function(){
    $('#addGestoreButton').click(function(){
    $("#veil").fadeIn();
    $("#addGestoreDiv").fadeIn();

});
$('#addGestoreExitButton').click(function(){
    $("#addGestoreDiv").fadeOut();
    $("#veil").fadeOut();
});


$('#addMagazzinoButton').click(function(){
    $("#veil").fadeIn();
    $("#addMagazzinoDiv").fadeIn();

});
$('#addMagazzinoExitButton').click(function(){
    $("#addMagazzinoDiv").fadeOut();
    $("#veil").fadeOut();
});


});


function caricaGestori(){
    var nome=$('#inputDipendentiFiltroNome').val();
    var cognome=$('#inputDipendentiFiltroCognome').val();
    var ruolo=$("#inputDipendentiFiltroRuolo").val();
    var magazzino=$('#idMagazzino').text();

    $.ajax({
        url:"/api/dipendenti/ruolo/gestore",
        method:"GET",
        dataType:"json",
        success:function(arrayDiRisposta){
            $('#ElencoGestori').html("");
            if(arrayDiRisposta.message==undefined)
            {
                jQuery.each( arrayDiRisposta, function( i, elementoRisposta ) {
                    var newDipendente= '<div class="gestore">\
                                        <div>'+elementoRisposta['id_dipendente']+'</div>\
                                        <div>'+elementoRisposta['nome_dipendente']+'</div>\
                                        <div>'+elementoRisposta['cognome_dipendente']+'</div>\
                                        <div>'+elementoRisposta['ruolo_dipendente']+'</div>\
                                        <div>'+elementoRisposta['paga_oraria_dipendente']+'</div>\
                                        <div><i class="far fa-image"></i></div>\
                                        <div><i class="far fa-edit"></i></div>\
                                        <div><i class="fas fa-trash-alt"></i></div>\
                                        </div>';

                    $( "#ElencoDipendenti" ).append( newDipendente);

                  });
            }
            else{
                $('#ElencoDipendenti').html("<div class='noResults'>No results</div>");
            }
        },
        error:function(req, text, error){
            ajax_error(req, text, error);
        }
    })

}
