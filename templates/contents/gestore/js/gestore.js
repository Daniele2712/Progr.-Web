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
    
    
    
    
    
// FUNZIONI PER LE MINISEZIONI DELLO STATS

//  Funzioni che fanno apparire e sparire le sezioni relative alle 3 grandi macrocategorie, in base a quale macrocategoria hai cliccato
$("#statisticheAnnuali").click(function(){
            $('.minisezione.active').removeClass('active');
            $('#statisticheAnnuali').addClass('active');
            
            $('.statsImages.selected').css('display', 'none');
            $('#statisticheAnnualiDiv').css('display', 'grid');
            
            $('.statsImages.selected').removeClass('selected');
            $('#statisticheAnnualiDiv').addClass('selected');
            
            
 });
 
$("#statisticheMensili").click(function(){
            $('.minisezione.active').removeClass('active');
            $('#statisticheMensili').addClass('active');
            
            $('.statsImages.selected').css('display', 'none');
            $('#statisticheMensiliDiv').css('display', 'grid');
            
            $('.statsImages.selected').removeClass('selected');
            $('#statisticheMensiliDiv').addClass('selected');
 });
 
$("#statisticheSettimanali").click(function(){
            $('.minisezione.active').removeClass('active');
            $('#statisticheSettimanali').addClass('active');
            
            $('.statsImages.selected').css('display', 'none');
            $('#statisticheSettimanaliDiv').css('display', 'grid');
            
            $('.statsImages.selected').removeClass('selected');
            $('#statisticheSettimanaliDiv').addClass('selected');
 });
         

$('#backwardImage').click(function() {
         $('.statsImages.selected').animate({'right' : "-=750px" });
});
$('#forwardImage').click(function() {
        $('.statsImages.selected').animate({'right' : "+=750px" });
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

$('#addProductButton').click(function(){
    $("#veil").fadeIn();
    $("#addProductDiv").fadeIn();
    
});
$('#addProductExitButton').click(function(){
    $("#addProductDiv").fadeOut();
    $("#veil").fadeOut();
});

$('#addCategoriaButton').click(function(){
    $("#veil").fadeIn();
    $("#addCategoriaDiv").fadeIn();
});
$('#addCategoriaExitButton').click(function(){
    $("#addCategoriaDiv").fadeOut();
    $("#veil").fadeOut();
});

$('#addEmployeeButton').click(function(){
    $("#veil").fadeIn();
    $("#addEmployeeDiv").fadeIn();
});
$('#addEmployeeExitButton').click(function(){
    $("#addEmployeeDiv").fadeOut();
    $("#veil").fadeOut();
});

$('#sezioneOrdini').click(function(){
    if($('#sezioneOrdini').hasClass('notUpdated')){
        caricaOrdiniGestore();
    }
});

$('#sezioneProdottiRicevuti').click(function(){
    if($('#sezioneProdottiRicevuti').hasClass('notUpdated')){
        caricaProdottiRicevuti();
    }
});

$('#sezioneProdottiVenduti').click(function(){
    if($('#sezioneProdottiVenduti').hasClass('notUpdated')){
        caricaProdottiVenduti();
    }
});



caricaCategorie();
caricaRuoli();
caricaValute();

$('#sezioneProdottiDiv').css('display', 'block');
document.getElementById("aggiungiProdotti-immagine").addEventListener("change", readImage);

$('#backwardImage').click(function(){
    $("#addEmployeeDiv").fadeOut();
    $("#veil").fadeOut();
});

$('#forwardImage').click(function(){
    $("#addEmployeeDiv").fadeOut();
    $("#veil").fadeOut();
});

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

function caricaOrdiniGestore(){
    var magazzino=$('#idMagazzino').text();
    $.ajax({
        url:"http://webb/api/ordine/magazzino/"+magazzino,
        method:"GET",
        dataType:"json",
        success:function(arrayDiRisposta){
            $('#ElencoOrdini').html("");
            if(arrayDiRisposta.message==undefined)
            {
                jQuery.each( arrayDiRisposta, function( i, elementoRisposta ) { 
                    var newOrdine= '<div class="ordine">\
                                        <div>'+elementoRisposta['id_ordine']+'</div>\
                                        <div>'+elementoRisposta['tipo_ordine']+'</div>\
                                        <div>'+elementoRisposta['via_indirizzo_ordine']+', '+elementoRisposta['nome_indirizzo_ordine']+'</div>\
                                        <div>'+elementoRisposta['nome_utente_ordine']+' '+elementoRisposta['cognome_utente_ordine']+'</div>\
                                        <div>'+elementoRisposta['subtotale_ordine']+' '+elementoRisposta['simbolo_valuta_ordine']+'</div>\
                                        <div>'+elementoRisposta['spedizione_ordine']+' '+elementoRisposta['simbolo_valuta_ordine']+'</div>\
                                        <div>'+elementoRisposta['totale_ordine']+' '+elementoRisposta['simbolo_valuta_ordine']+'</div>\
                                        <div>'+elementoRisposta['data_ordine']+'</div>\
                                        <div>'+elementoRisposta['consegna_ordine']+'</div>\
                                        </div>';

                    $( "#ElencoOrdini" ).append( newOrdine);
                  });
            }
            else{
                $('#ElencoOrdini').html("<div class='noResults'>No results</div>");
            }
            $('#sezioneOrdini').removeClass('notUpdated');
        },
        error:function(req, text, error){
            ajax_error(req, text, error);
        }
    })
}

function caricaProdottiRicevuti(){
    var magazzino=$('#idMagazzino').text();
    $.ajax({
        url:"http://webb/api/prodotti_ricevuti/magazzino/"+magazzino,
        method:"GET",
        dataType:"json",
        success:function(arrayDiRisposta){
            $('#ElencoProdottiRicevuti').html("");
            if(arrayDiRisposta.message==undefined)
            {
                jQuery.each( arrayDiRisposta, function( i, elementoRisposta ) {
                    if(elementoRisposta['descrizione_prodotto'].length > 35) var descrDisplay=elementoRisposta['descrizione_prodotto'].substr(0,35)+'  ...';
                    else var descrDisplay=elementoRisposta['descrizione_prodotto'];
                    
                    if(elementoRisposta['info_prodotto'].length > 35) var infoDisplay=elementoRisposta['info_prodotto'].substr(0,35)+'  ...';
                    else var infoDisplay=elementoRisposta['info_prodotto'];
                    
                    var newProduct= '<div class="prodottoRicVen">\
                                        <div>'+elementoRisposta['id_prodotto']+'</div>\
                                        <div>'+elementoRisposta['nome_prodotto']+'</div>\
                                        <div>'+elementoRisposta['categoria_prodotto']+'</div>\
                                        <div class="descr" title="'+elementoRisposta['descrizione_prodotto']+'">'+descrDisplay+'</div>\
                                        <div class="descr" title="'+elementoRisposta['info_prodotto']+'">'+infoDisplay+'</div>\
                                        <div>'+elementoRisposta['quantita_prodotto']+'</div>\
                                        <div>'+elementoRisposta['data']+'</div>\
                                    </div>';
                    $("#ElencoProdottiRicevuti").append(newProduct);
                  });
              }
              else{
                $('#ElencoProdottiRicevuti').html("<div class='noResults'>No results</div>");
            }
            $('#sezioneProdottiRicevuti').removeClass('notUpdated');
        }   
        ,
        error:function(req, text, error){
            ajax_error(req, text, error);
        }
    });
}

function caricaProdottiVenduti(){
    var magazzino=$('#idMagazzino').text();
    $.ajax({
        url:"http://webb/api/prodotti_venduti/magazzino/"+magazzino,
        method:"GET",
        dataType:"json",
        success:function(arrayDiRisposta){
            $('#ElencoProdottiVenduti').html("");
            if(arrayDiRisposta.message==undefined)
            {
                jQuery.each( arrayDiRisposta, function( i, elementoRisposta ) {
                    if(elementoRisposta['descrizione_prodotto'].length > 35) var descrDisplay=elementoRisposta['descrizione_prodotto'].substr(0,35)+'  ...';
                    else var descrDisplay=elementoRisposta['descrizione_prodotto'];
                    
                    if(elementoRisposta['info_prodotto'].length > 35) var infoDisplay=elementoRisposta['info_prodotto'].substr(0,35)+'  ...';
                    else var infoDisplay=elementoRisposta['info_prodotto'];
                    
                    var newProduct= '<div class="prodottoRicVen">\
                                        <div>'+elementoRisposta['id_prodotto']+'</div>\
                                        <div>'+elementoRisposta['nome_prodotto']+'</div>\
                                        <div>'+elementoRisposta['categoria_prodotto']+'</div>\
                                        <div class="descr" title="'+elementoRisposta['descrizione_prodotto']+'">'+descrDisplay+'</div>\
                                        <div class="descr" title="'+elementoRisposta['info_prodotto']+'">'+infoDisplay+'</div>\
                                        <div>'+elementoRisposta['quantita_prodotto']+'</div>\
                                        <div>'+elementoRisposta['data']+'</div>\
                                    </div>';
                    $("#ElencoProdottiVenduti").append(newProduct);
                  });
              }
              else{
                $('#ElencoProdottiVenduti').html("<div class='noResults'>No results</div>");
            }
            $('#sezioneProdottiVenduti').removeClass('notUpdated');
        }   
        ,
        error:function(req, text, error){
            ajax_error(req, text, error);
        }
    });
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
                    $( "#aggiungiProdotti-categoria").append(cat);
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

function caricaValute(){
    $.ajax({
            url:"http://webb/api/valute",
            method:"GET",
            dataType:"json",
            success:function(arrayDiRisposta){
                jQuery.each(arrayDiRisposta, function( i, elementoRisposta ) {
                    var valuta= '<option value='+elementoRisposta['id_valuta']+'>'+elementoRisposta['simbolo_valuta']+'&nbsp;&nbsp;:&nbsp;&nbsp;'+elementoRisposta['sigla_valuta']+'</option>';
                    $( "#aggiungiProdotti-valuta" ).append(valuta);
                  });
            },
            error:function(req, text, error){
                ajax_error(req, text, error);
            }
        })
    
}

function readImage() {  // volevo usarla per uploadare l-immagine via ajax, invece di fare una richiesta al server e cambiare la pagina...pero non la cpaisco a pieno..per ora non la uso
  
  if (this.files && this.files[0]) {
    
    var FR= new FileReader();
    
    FR.addEventListener("load", function(e) {
      //document.getElementById("img").src       = e.target.result;
      $("#image-base64").innerHTML = e.target.result;
    }); 
    
    FR.readAsDataURL( this.files[0] );
  }
  
}



function createProdotto(){}
function deleteProdotto(){}
function modofyProdotto(){/*combinaz lineare di create e delete*/}
function createCategoria(){}
function deleteCategoria(){}
function createDipendente(){}
function deleteDipendente(){}
function modofyDipendente(){/*combinaz lineare di create e delete*/}



