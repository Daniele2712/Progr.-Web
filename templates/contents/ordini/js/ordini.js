function mostra_dettagli(idOrdine){
    
    
    if ($('#productsDetailsOrder'+idOrdine).html().length<1)    /*  se e' minore di 1 vuol dire che la div dei prodotti e' vuota, ergo la devo riempire*/
    {
        
    $.ajax({
        url:"/api/ordine/id/"+idOrdine,
        method:"GET",
        dataType:"json",
        success:function(r){
            
                    
            var products='<div class="product">'+
                                 '<span>Nome</span>'+
                                 '<span>Quantita</span>'+
                                 '<span>Prezzo</span>'+
                                 '<span>Totale</span>'+
                             '</div>';        
                
           $.each(JSON.parse(r['orderProducts']),function(index, p) {    //ho usato JSON.parse xke la funzione $.each funziona solo su oggetti
               console.log(p); 
               var prezzoProdotto=p['prezzo'];
                var quantita=p['quantita'];
                var prezzoTotale=prezzoProdotto*quantita;
                var prodotto = '<div class="product">'+
                                    '<span><a href="/">'+p['prodotto']+'</a></span>'+
                                    '<span>'+quantita+'</span>'+
                                    '<span>'+prezzoProdotto+'</span>'+
                                    '<span>'+prezzoTotale+'</span>'+
                                '</div>';
                
                products=products+prodotto;
            });
            
                        
        $('#productsDetailsOrder'+idOrdine).append(products);
        $('#productsDetailsOrder'+idOrdine).slideToggle('slow');
        },
        error:function(req, text, error){
            ajax_error(req, text, error);
            console.log(req);
            console.log(text);
            console.log(error);
        }
    });
    }
    else {
        $('#productsDetailsOrder'+idOrdine).slideToggle('slow');
    }
   
    
}

function searchByCode(){
    
    var code=$('#code').val();
    
    
    //cancella dalla tabbella l-ordine che c-era prima e aggiungici un altro ordine. Si potrebbe fare anche una verifica x far in
    // modo che si possano aggiungere diversi ordini alla tabbella, ma per motivi di tempo facio prima a cancellare l-orine precedente e ad aggiungere un altro ordine    
    $.ajax({
        url:"/api/ordine/code/"+code,
        method:"GET",
        dataType:"json",
        success:function(r){    // r  e' un oggetto con 2 attributi, ognuno dei quali puo essere parserizzato x essere trasformato in un ogg
           
           var idOrdine=r['orderDetails']['id'];
           var start=   '<div class="ordineEntry">';
           var details=JSON.parse(r['orderDetails']);
           console.log(details);
           var details= '<div class="orderDetails">'+
                            '<span><i onclick="mostra_dettagli('+details['id']+')" title="'+ details['id']+'" class="fa fa-plus-square fa-2x dettagli_ordine" aria-hidden="true"></i></span>'+
                            '<span>'+details['data_ordine']+'</span>'+
                            '<span>'+details['data_consegna']+'</span>'+
                            '<span>'+details['subtotale']+'</span>'+
                            '<span>'+details['spese_spedizione']+'</span>'+
                            '<span>'+details['totale']+'</span>'+
                            '<span>'+details['stato']+'</span>'+
                        '</div>'+
                        '<div id="productsDetailsOrder'+details['id'] + '" class="productsDetails">';
                
            var products='<div class="product">'+
                                 '<span>Nome</span>'+
                                 '<span>Quantita</span>'+
                                 '<span>Prezzo</span>'+
                                 '<span>Totale</span>'+
                          '</div>';        
           var all=start+details+products;
           console.log(all);
           $.each(JSON.parse(r['orderProducts']),function(index, p) {    //ho usato JSON.parse xke la funzione $.each funziona solo su oggetti
                prezzoProdotto=p['prezzo'];
                var quantita=p['quantita'];
                var prezzoTotale=prezzoProdotto*quantita;
                var prodotto = '<div class="product">'+
                                    '<span><a href="/">'+p['prodotto']+'</a></span>'+
                                    '<span>'+quantita+'</span>'+
                                    '<span>'+prezzoProdotto+'</span>'+
                                    '<span>'+prezzoTotale+'</span>'+
                                '</div>';
                
                all=all+prodotto;
            });
            
            var end='</div></div>'; 
            all=all+end;
                      
        $('.orders').append(all);
        
        },
        error:function(req, text, error){
            ajax_error(req, text, error);
            console.log(req);
            console.log(text);
            console.log(error);
        }
    });
    
}

