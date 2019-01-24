$(document).ready(function(){
        
//  Funzioni che fanno apparire e sparire le sezioni relative alle 3 grandi macrocategorie, in base a quale macrocategoria hai cliccato
$("#statistiche").click(function(){
   
    if(!$('#statistiche').hasClass( "active" )) {$('#statistiche').addClass('active');}
    if($('#amministrazione').hasClass( "active" )) {$('#amministrazione').removeClass('active');}
    if($('#impostazioni').hasClass( "active" )) {$('#impostazioni').removeClass('active');}
   
    
    if($('#sezioniStatistiche').css('display') == 'none') {$('#sezioniStatistiche').css('display', 'grid');}
    if($('#sezioniAmministrazione').css('display') == 'grid') {$('#sezioniAmministrazione').css('display', 'none');}
    if($('#sezioniImpostazioni').css('display') == 'grid') {$('#sezioniImpostazioni').css('display', 'none');}
});

$("#amministrazione").click(function(){
    
    if($('#statistiche').hasClass( "active" )) {$('#statistiche').removeClass('active');}
    if(!$('#amministrazione').hasClass( "active" )) {$('#amministrazione').addClass('active');}
    if($('#impostazioni').hasClass( "active" )) {$('#impostazioni').removeClass('active');}
   
    
    if($('#sezioniStatistiche').css('display') == 'grid') {$('#sezioniStatistiche').css('display', 'none');}
    if($('#sezioniAmministrazione').css('display') == 'none') {$('#sezioniAmministrazione').css('display', 'grid');}
    if($('#sezioniImpostazioni').css('display') == 'grid') {$('#sezioniImpostazioni').css('display', 'none');}
}); 

$("#impostazioni").click(function(){
    
    if($('#statistiche').hasClass( "active" )) {$('#statistiche').removeClass('active');}
    if($('#amministrazione').hasClass( "active" )) {$('#amministrazione').removeClass('active');}
    if(!$('#impostazioni').hasClass( "active" )) {$('#impostazioni').addClass('active');}
   
    
    if($('#sezioniStatistiche').css('display') == 'grid') {$('#sezioniStatistiche').css('display', 'none');}
    if($('#sezioniAmministrazione').css('display') == 'grid') {$('#sezioniAmministrazione').css('display', 'none');}
    if($('#sezioniImpostazioni').css('display') == 'none') {$('#sezioniImpostazioni').css('display', 'grid');}
});
  
//  Funzioni che mostrano un solo Div alla volta, nascondendo quello che c-era prima
$(".sezione").click(function(){
        var nameOfSection = $(this).attr("id");
        $(".divGestionale").css('display', 'none');
        $('#' + nameOfSection + 'Div').css('display', 'block');
    
    $(".sezione").removeClass('active');
    $(this).addClass('active');
    });
    
    
$("#ProdottiSearchButton").click(function(){caricaProdotti()});
$("#DipendentiSearchButton").click(function(){caricaDipendenti()});

//La seguente funzione seve per popolare la lista dei magazzini per l-amministratore, il quale puo scegliere cosa fare in tutti i magazzini
$.ajax({
    url:"http://webb/api/ApiController/indirizzi",
    method:"GET",
    dataType:"json",
    success:function(indirizzi){
        jQuery.each( indirizzi, function( i, indirizzo ) {
            var indirizzo= '<option>ID '+indirizzo['id_magazzino']+' :   '+indirizzo['citta']+' '+indirizzo['provincia']+' '+indirizzo['cap']+' ' +indirizzo['via']+' '+indirizzo['civico']+'</option>';
            $( ".ListaNomiMagazzini" ).append( indirizzo);
          });

    },
    error:function(req, text, error){
        ajax_error(req, text, error);
    }
})

$('#addProductButton').click(function(){$("#addProductDiv").fadeIn();});
$('#addProductExitButton').click(function(){$("#addProductDiv").fadeOut();});

$('#addCategoriaButton').click(function(){$("#addCategoriaDiv").fadeIn();});
$('#addCategoriaExitButton').click(function(){$("#addCategoriaDiv").fadeOut();});


caricaCategorie();
caricaRuoli();

$('#sezioneProdottiDiv').css('display', 'block');
});

function caricaProdotti(){
    var min=$('#ProdottoPriceMin').val();
    var max=$('#ProdottoPriceMax').val();
    var id_categoria=$( "#inputProdottiFiltroCategoria option:selected" ).val();
    var nome=$('#inputProdottiFiltroNome').val();
    var magazzino=$('#idMagazzino').text();
    
    
    $.ajax({
        url:"http://webb/api/prodotti/prezzo_min/"+min+"/prezzo_max/"+max+"/id_categoria/"+id_categoria+"/nome/"+nome+"/magazzino/"+magazzino,
        method:"GET",
        dataType:"json",
        success:function(arrayDiRisposta){
            $('#ElencoProdotti').html("");
            if(arrayDiRisposta.message==undefined)
            {
                jQuery.each( arrayDiRisposta, function( i, elementoRisposta ) {
                    if(elementoRisposta['descrizione_prodotto'].length > 35) var descrDisplay=elementoRisposta['descrizione_prodotto'].substr(0,35)+'  ...';
                    else var descrDisplay=elementoRisposta['descrizione_prodotto'];
                    
                    if(elementoRisposta['info_prodotto'].length > 35) var infoDisplay=elementoRisposta['info_prodotto'].substr(0,35)+'  ...';
                    else var infoDisplay=elementoRisposta['info_prodotto'];
                    
                    var newProduct= '<div class="prodotto">\
                                        <div>'+elementoRisposta['id_prodotto']+'</div>\
                                        <div>'+elementoRisposta['nome_prodotto']+'</div>\
                                        <div>'+elementoRisposta['categoria_prodotto']+'</div>\
                                        <div class="descr" title="'+elementoRisposta['descrizione_prodotto']+'">'+descrDisplay+'</div>\
                                        <div class="descr" title="'+elementoRisposta['info_prodotto']+'">'+infoDisplay+'</div>\
                                        <div>'+elementoRisposta['prezzo_prodotto']+'&nbsp;'+elementoRisposta['simbolo_valuta_prodotto']+'</div>\
                                        <div>'+elementoRisposta['id_magazzino']+'</div>\
                                        <div>'+elementoRisposta['quantita_prodotto']+'</div>\
                                        <div><a href=/download/image/'+elementoRisposta['id_prodotto']+' target="_blank"><i class="far fa-image"></i></a></div>\
                                        <div><a href=#><i class="far fa-edit"></i></a></div>\
                                        <div><a href=#><i class="fas fa-trash-alt"></i></a></div>\
                                    </div>';
                    $("#ElencoProdotti").append(newProduct);
                  });
              }
              else{
                $('#ElencoProdotti').html("<div class='noResults'>No results</div>");
            }
            
        },
        error:function(req, text, error){
            console.log(req);
            console.log(text);
            console.log(error);
            ajax_error(req, text, error);
        }
    })
    
}

function caricaDipendenti(){
    var nome=$('#inputDipendentiFiltroNome').val();
    var cognome=$('#inputDipendentiFiltroCognome').val();
    var ruolo=$("#inputDipendentiFiltroRuolo").val();
    var magazzino=$('#idMagazzino').text();
    
    $.ajax({
        url:"http://webb/api/dipendenti/nome/"+nome+"/cognome/"+cognome+"/ruolo/"+ruolo+"/magazzino/"+magazzino,
        method:"GET",
        dataType:"json",
        success:function(arrayDiRisposta){
            $('#ElencoDipendenti').html("");
            if(arrayDiRisposta.message==undefined)
            {
                jQuery.each( arrayDiRisposta, function( i, elementoRisposta ) { 
                    var newDipendente= '<div class="dipendente">\
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

function caricaCategorie(){
            $.ajax({
                url:"http://webb/api/ApiController/categorie",
                method:"GET",
                dataType:"json",
                success:function(categorie){
                    jQuery.each( categorie, function( i, categoria ) {
                    if(categoria['id_padre']!=null) var padre='&nbsp;&nbsp;&nbsp;[ID Padre: '+categoria['id_padre']+']';
                    else var padre='';
                    var cat='<option value='+categoria['id_categoria']+'>ID '+categoria['id_categoria']+' : '+categoria['nome_categoria']+padre+'</option>';
                    $( "#inputProdottiFiltroCategoria" ).append(cat);
                  });
                },
                error:function(req, text, error){
                    ajax_error(req, text, error);
                }
            })
    }
    
function caricaRuoli(){
        $.ajax({
            url:"http://webb/api/ruoli",
            method:"GET",
            dataType:"json",
            success:function(arrayDiRisposta){
                jQuery.each(arrayDiRisposta, function( i, elementoRisposta ) {

                    var ruolo= '<option value='+elementoRisposta['nome_ruolo']+'>ID '+elementoRisposta['id_ruolo']+' :   '+elementoRisposta['nome_ruolo']+'</option>';
                    $( "#inputDipendentiFiltroRuolo" ).append(ruolo);
                  });
            },
            error:function(req, text, error){
                ajax_error(req, text, error);
            }
        })
}



