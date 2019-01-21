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

    //fine 

    
    //  Funzioni che mostrano un solo Div alla volta, nascondendo quello che c-era prima
    $(".sezione").click(function(){
        var nameOfSection = $(this).attr("id");
        $(".divGestionale").css('display', 'none');
        $('#' + nameOfSection + 'Div').css('display', 'block');
    
    $(".sezione").removeClass('active');
    $(this).addClass('active');
    });
    
    
     //  Funzioni che aggiunge le categorie solo se necessario
    $("#sezioneProdotti").click(function(){
    var nameOfSection = $(this).attr("id");
        if($('#' + nameOfSection + 'Div').hasClass('notUpdated'))
        {
            $.ajax({
                url:"http://webb/api/ApiController/categorie",
                method:"GET",
                dataType:"json",
                success:function(categorie){
                    jQuery.each( categorie, function( i, categoria ) {
                    if(categoria['id_padre']!=null) var padre='&nbsp;&nbsp;&nbsp;[ID Padre: '+categoria['id_padre']+']';
                    else var padre='';
                    var cat='<option value='+categoria['id_categoria']+'>ID '+categoria['id_categoria']+' : '+categoria['nome_categoria']+padre+'</option>';
                    $( "#listaCategorieLook" ).append(cat);
                  });
                      $('#' + nameOfSection + 'Div').removeClass('notUpdated');

                },
                error:function(req, text, error){
                    ajax_error(req, text, error);
                }
            })
        }
    
    
    });
    
    //  Funzioni che aggiunge i ruoli solo se necessario
    $("#sezioneDipendenti").click(function(){
        var nameOfSection = $(this).attr("id");
        if($('#' + nameOfSection + 'Div').hasClass('notUpdated'))
        {
            $.ajax({
                url:"http://webb/api/ApiController/ruoli",
                method:"GET",
                dataType:"json",
                success:function(arrayDiRisposta){
                    jQuery.each(arrayDiRisposta, function( i, elementoRisposta ) {
                        
                        var ruolo= '<option value='+elementoRisposta['id_ruolo']+'>ID '+elementoRisposta['id_ruolo']+' :   '+elementoRisposta['nome_ruolo']+'</option>';
                        $( "#listaRuoliLook" ).append(ruolo);
                      });
                      $('#' + nameOfSection + 'Div').removeClass('notUpdated');

                },
                error:function(req, text, error){
                    ajax_error(req, text, error);
                }
            })
        }
    });
    
    $("#sezioneProdotti").click(caricaProdotti());
    
    $("#ProdottiSearchButton").click(caricaProdotti());
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
    
    
    $('.sezioneProdottiDiv').css('display', 'grid');
});

function caricaProdotti(){
    var min=$('#ProdottoPriceMin').val();
    var max=$('#ProdottoPriceMax').val();
    var categoria=$("#ListaCategorie").selected().val();
    var nome=$('#inputProdottiNomeFilter').val();
    var magazzino=1;
    
    $.ajax({
        url:"http://webb/api/ApiController/prodotti/prezzo_min/"+min+"/prezzo_max/"+max+"categoria/"+categoria+"/nome/"+nome+"/magazzino/"+magazzino,
        method:"GET",
        dataType:"json",
        success:function(arrayDiRisposta){
            jQuery.each( arrayDiRisposta, function( i, elementoRisposta ) { //Devo fare una funzione che trasforma la valuta in elementi HTML
                var newProduct= '<div class="prodotto">\
                                    <div>'+elementoRisposta['id_prodotto']+'</div>\
                                    <div>'+elementoRisposta['nome_categoria']+'</div>\
                                    <div>'+elementoRisposta['nome_prodotto']+'</div>\
                                    <div>'+elementoRisposta['descrizione_prodotto']+'</div>\
                                    <div>'+elementoRisposta['info_prodotto']+'</div>\
                                    <div>'+elementoRisposta['prezzo_prodotto']+'$</div>\
                                    <div>'+elementoRisposta['comune_magazzino']+' '+elementoRisposta['via_magazzino']+' '+elementoRisposta['civico_magazzino']+'</div>\
                                    <div>'+elementoRisposta['quantita_prodotto']+'</div>\
                                    <div><a href=/download/image/'+elementoRisposta['id_prodotto']+' target="_blank"><i class="far fa-image"></i></a></div>\
                                    <div><a href=#><i class="far fa-edit"></i></a></div>\
                                    <div><a href=#><i class="fas fa-trash-alt"></i></a></div>\
                                </div>'
                $( "#ElencoProdotti" ).append( newProduct);
              });
            
        },
        error:function(req, text, error){
            ajax_error(req, text, error);
        }
    })
    
}

function aggiungiProdoto(){
        $(".divGestionale").css('display', 'none');
        $('.sezioneAggiungiProdottiDiv').css('display', 'grid');
}


