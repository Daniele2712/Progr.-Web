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
        console.log($(".divGestionele"));
        $('.' + nameOfSection + 'Div').css('display', 'grid');
    
    $(".sezione").removeClass('active');
    $(this).addClass('active');
    });
    
    $("#sezioneProdotti").click(caricaProdotti());
    
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
    
    
     //La seguente funzione seve per popolare la lista delle categorie
    $.ajax({
        url:"http://webb/api/ApiController/categorie",
        method:"GET",
        dataType:"json",
        success:function(categorie){
            jQuery.each( categorie, function( i, categoria ) {
                if(categoria['padre']!=null) var padre='[Padre: '+categoria['padre']+']';
                else var padre='';
                var cat= '<option value='+categoria['id']+'>ID '+categoria['id']+' :   '+categoria['nome_categoria']+padre+'</option>';
                $( ".ListaCategorie" ).append(cat);
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
    var categoria=$("#ProdottoCategoria").val();
    var nome=$('#inputProdottiNomeFilter').val();
    var magazzino=1;
    
    console.log(min);
    console.log(max);
    console.log(categoria);
    console.log(nome);
    console.log(magazzino);
    
    $.ajax({
        url:"http://webb/api/ApiController/prodotti",
        method:"GET",
        dataType:"json",
        success:function(arrayDiRisposta){
            jQuery.each( arrayDiRisposta, function( i, elementoRisposta ) { //Devo fare una funzione che trasforma la valuta in elementi HTML
                console.log(elementoRisposta);
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

