$(document).ready(function(){

//  Funzioni che fanno apparire e sparire le sezioni relative alle 3 grandi macrocategorie, in base a quale macrocategoria hai cliccato
$("#statistiche").click(function(){
  $('.macrosezione').removeClass('active');
  $('#statistiche').addClass('active');

  $('.gruppoDiSezioni').css('display', 'none');
  $('#sezioniStatistiche').css('display', 'grid');
});

$("#amministrazione").click(function(){
    $('.macrosezione').removeClass('active');
    $('#amministrazione').addClass('active');

    $('.gruppoDiSezioni').css('display', 'none');
    $('#sezioniAmministrazione').css('display', 'grid');
});

$("#impostazioni").click(function(){
  $('.macrosezione').removeClass('active');
  $('#impostazioni').addClass('active');

  $('.gruppoDiSezioni').css('display', 'none');
  $('#sezioniImpostazioni').css('display', 'grid');
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



$('#sezioneProdottiDiv').css('display', 'block');

$('#backwardImage').click(function(){
    $("#addEmployeeDiv").fadeOut();
    $("#veil").fadeOut();
});

$('#forwardImage').click(function(){
    $("#addEmployeeDiv").fadeOut();
    $("#veil").fadeOut();
});


caricaCategorie();
caricaRuoli();
caricaValute();
caricaIndirizziDeiMagazzini();
caricaContratti();

lightbox.option({
      'resizeDuration': 200,
      'wrapAround': true,
      'fitImagesInViewport': true,
      'positionFromTop':0
    })
});

/*  Dichiarazioni delle funzioni  */

/*  carica Prodotti quando si fa la ricerca con il filtro  */
function caricaProdotti(){
    var min=$('#ProdottoPriceMin').val();
    var max=$('#ProdottoPriceMax').val();
    var id_categoria=$( "#inputProdottiFiltroCategoria option:selected" ).val();
    var nome=$('#inputProdottiFiltroNome').val();
    var magazzino=$('#idMagazzino').text();


    $.ajax({
        url:"/api/prodotti/prezzo_min/"+min+"/prezzo_max/"+max+"/id_categoria/"+id_categoria+"/nome/"+nome+"/magazzino/"+magazzino,
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

/*  carica Dipendenti quando si fa la ricerca con il filtro  */
function caricaDipendenti(){
    var nome=$('#inputDipendentiFiltroNome').val();
    var cognome=$('#inputDipendentiFiltroCognome').val();
    var ruolo=$("#inputDipendentiFiltroRuolo").val();
    var idMagazzino=$('#idMagazzino').text();
    var username="";
    var telefono="";
    var email="";

    $.ajax({
        url:"/api/dipendenti/nome/"+nome+"/cognome/"+cognome+"/ruolo/"+ruolo+"/idMagazzino/"+idMagazzino+"/username/"+username+"/telefono/"+telefono+"/email/"+email,
        method:"GET",
        dataType:"json",
        success:function(arrayDiRisposta){
            $('#ElencoDipendenti').html("");
            if(arrayDiRisposta.r==200)
            {

                jQuery.each( arrayDiRisposta['dipendenti'], function( i, elementoRisposta ) {
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

/* Ordini Gestore, ProdottiRicevuti e ProdottiVenduti vengono caricari la prima volta che il gestore clicca per vederli, le volte seguenti non li ricarica piu' */
function caricaOrdiniGestore(){
    var magazzino=$('#idMagazzino').text();
    $.ajax({
        url:"/api/ordine/magazzino/"+magazzino,
        method:"GET",
        dataType:"json",
        success:function(arrayDiRisposta){
            $('#ElencoOrdini').html("");
            if(arrayDiRisposta.message==undefined)
            {
                jQuery.each( arrayDiRisposta, function( i, elementoRisposta ) {
                    var newOrdine= '<div class="ordine">\
                                        <div>'+elementoRisposta['id_ordine']+'</div>\
                                        <div>'+elementoRisposta['tipo_pagamento']+'</div>\
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
        url:"/api/prodotti_ricevuti/magazzino/"+magazzino,
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
        url:"/api/prodotti_venduti/magazzino/"+magazzino,
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

/* Queste prossime 5 funzioni vengono eseguite dopo che viene caricata la pagina, e servono per riempire i selectBox rispettivamente con */
function caricaCategorie(){
            $.ajax({
                url:"/api/ApiController/categorie",
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
            url:"/api/ruoli",
            method:"GET",
            dataType:"json",
            success:function(arrayDiRisposta){
                jQuery.each(arrayDiRisposta, function( i, elementoRisposta ) {
                    var ruolo= '<option value='+elementoRisposta['nome_ruolo']+'>ID '+elementoRisposta['id_ruolo']+' :   '+elementoRisposta['nome_ruolo']+'</option>';
                    $( ".ruoliDipendenti").append(ruolo);
                  });
            },
            error:function(req, text, error){
                ajax_error(req, text, error);
            }
        })
}

function caricaValute(){
    $.ajax({
            url:"/api/valute",
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

function caricaIndirizziDeiMagazzini(){
   $.ajax({
            url:"/api/indirizzi/all",
            method:"GET",
            dataType:"json",
            success:function(risposta){
                $('.magazzinoSelezionato').html("ID:"+risposta.magazzini[0]['id_magazzino']+"&nbsp;&nbsp;"+risposta.magazzini[0]['nome_citta_magazzino'] +", "+risposta.magazzini[0]['via_magazzino'] +" "+risposta.magazzini[0]['civico_magazzino']);  //scrive in tutti i posti dedicati al nome del negozio

                var opzioniMagazziniPerDropdown="";
                jQuery.each(risposta.magazzini, function( i, magazzino )
                {
                 opzioniMagazziniPerDropdown = opzioniMagazziniPerDropdown+'<option class="magazzinoValue" value='+magazzino['id_magazzino']+'>'+"ID:"+magazzino['id_magazzino']+"&nbsp;&nbsp;"+magazzino['nome_citta_magazzino']+', '+magazzino['via_magazzino']+' '+magazzino['civico_magazzino']+'</option>';
                });
                var selectMagazzino="<select id='selectMagazzinoSelectTable'>"+opzioniMagazziniPerDropdown+"</select><span id=idMagazzino></span>"; // questo perzzo serve per riempire la parte del nome (e id invisibile) del magazzino
                $('#selezionaMagazzino').html(selectMagazzino);
                $('.listaNomiMagazzini').html(opzioniMagazziniPerDropdown);

                $('#idMagazzino').html(risposta.magazzini[0]['id_magazzino']);        // riempio quella span con l-id cel primo magazzino appartenente all gestore, che sarebbe quello di default

                //Ora completo anche la tabbella grande con la lista dei magazzini
                 jQuery.each(risposta.magazzini, function( i, magazzino )
                {
                    var magazzino = '<div class="magazzino">\
                                        <div>'+magazzino['nome_citta_magazzino']+'</div>\
                                        <div>'+magazzino['CAP_magazzino']+'</div>\
                                        <div>'+magazzino['via_magazzino']+'</div>\
                                        <div>'+magazzino['civico_magazzino']+'</div>\
                                        <div><a href="#">Cambia Indirizzo</a></div>\
                                    </div>';
                    $('#ElencoMagazzini').append(magazzino)
                 });

                // Dopo aver creato tutto questo, ci aggiungo la funzione on click che aggiorna la span quando il gestore cambia il magazzino
                $('.magazzinoValue').click(function(){
                    var idMagazzinoSelezionato=$(this).attr('value');       //Prende l-id del magazzino , che e' memorizzato nel attributo value dell'opzione
                   $('#idMagazzino').html(idMagazzinoSelezionato);          //nella sezione invisibile con id idMagazzino ci aggiungo l'id del magazzino

                   //ora cambio la scritta in tutte le sezioni dove c-e scritto "nome del magazzino"
                   jQuery.each(risposta.magazzini, function( i, magazzino )
                        {
                            if(magazzino['id']==idMagazzinoSelezionato)
                                $('.magazzinoSelezionato').html("ID:"+magazzino['id_magazzino']+"&nbsp;&nbsp;"+magazzino['nome_citta_magazzino'] +", "+magazzino['via_magazzino'] +" "+magazzino['civico_magazzino']);
                        });


                   //Dato che ho cambiato magazzino, ora le informazioni delle tabblle di prima sono obolete, quindi le cancello
                   $('#ElencoProdotti').html('');
                   $('#ElencoDipendenti').html('');
                   $('#ElencoOrdini').html('');
                   $('#ElencoProdottiRicevuti').html('');
                   $('#ElencoProdottiVenduti').html('');
                   $('#sezioneOrdini').addClass('notUpdated');
                   $('#sezioneProdottiRicevuti').addClass('notUpdated');
                   $('#sezioneProdottiVenduti').addClass('notUpdated');

                });
            },
            error:function(req, text, error){
                ajax_error(req, text, error);
            }
        });
}

function caricaContratti(){
    $.ajax({
            url:"/api/contratti",
            method:"GET",
            dataType:"json",
            success:function(contratti){

                jQuery.each(contratti, function( i, contratto )
                {
                    $('.selectContrattoDipendente').append("<option value="+contratto['id_contratto']+">"+contratto['tipo_contratto']+"</option>");
                });
               }
            ,
            error:function(req, text, error){
                ajax_error(req, text, error);
            }
        });
}

/*  Le seguenti funzioni potrebbero essere usate per modificare i prodotti e dipendenti, e magari dopo anche gli indirizzi dei magazzini */
/*  dato che nelle tabbelle dove vengono mostrati i prodotti e i dipendenti c;e la possibilita di fare questo   */
function createProdotto(){}
function deleteProdotto(){}
function modofyProdotto(){/*combinaz lineare di create e delete*/}
function createCategoria(){}
function deleteCategoria(){}
function createDipendente(){}
function deleteDipendente(){}
function modofyDipendente(){/*combinaz lineare di create e delete*/}
