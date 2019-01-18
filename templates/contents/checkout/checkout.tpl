{* Smarty *}

        <div class="wrapper">
            
            
            <div class="container paymentMethod">
                <span id="paymentMethodTitle"><h2>Select Payment method</h4></span>
                
                <div class="paymentElement" onclick="#">
                    <i class="fab fa-3x fa-cc-mastercard"></i>
                    <span class="mastercard">Mstercard</span>
                </div>
                
                <div class="paymentElement" onclick="#">
                    <i class="fab fa-3x fa-bitcoin"></i>
                    <span class="bitcoin">Bitcoin</span>
                </div>
                
                <div class="paymentElement" onclick="#">
                    <i class="contrassegno fas fa-3x fa-money-bill-alt"></i>
                    <span class="contrassegno">Contrassegno</span>
                </div>
            </div>
            
            <div class="container recap">
                <span id="recapTitle"><h2>Dati di spedizione</h2><a href="#">Modifica</a></span>
                
                <div class="recapElement">
                    <p>Nome <i class="fas fa-2x fa-user-alt"></i></p>
                    <p>{$datiAnagrafici.nome} {$datiAnagrafici.cognome}</p>
                </div>
                
                <div class="recapElement">
                    <p>Indirizzo <i class="fas  fa-2x fa-people-carry"></i></p>
                    <p>{$indirizzo.via} {$indirizzo.civico}, {$indirizzo.nomeComune}</p>
                </div>
                
                 <div class="recapElement">
                    <p>Telefono <i class="fas  fa-2x fa-mobile-alt"></i></p>
                    <p>{$datiAnagrafici.telefono}</p>
                </div>
                
                
            </div>
            
            <div class="container details">
                <form id="pagamentoMastercard" action="/checkout/pagamentoMastercard" method="post">
                      <h3 id="d_title">Mastercard</h3>
                      <div id="nome_carta">
                        <label for="cname">Nome sulla carta</label>
                        <input class="double" type="text" id="cname" name="cardname" placeholder="Mario Rossi">
                      </div>
                      
                      <div id="numero_carta">
                      <label for="ccnum">Numero Carta di creito</label>
                      <input class="double" type="text" id="ccnum" name="cardnumber" placeholder="1111-2222-3333-4444">
                      </div>
                      
                      <div id="scadenza">
                      <label for="expmonth">Scadenza</label>
                      <input type="text" id="expmonth" name="expmonth" placeholder="MM/AAAA">
                      </div>
                      
                      <div id="cvv">
                          <label for="cvv">CVV</label>
                          <input type="text" id="cvv" name="cvv" placeholder="352">
                     </div>
                      
                      <button  id="paga" type="submit" value="Submit">Paga</button>
                </form> 
                
            </div>
            
            
            <div class="container cart">
                <h4>Cart
                  <span class="price" style="color:black">
                    <i class="fa fa-shopping-cart"></i>
                    <b>{$numItems}</b>
                  </span>
                </h4>
                  {foreach from=$productsArray item='product'}
                <p><a href=".../paginaDiInfoDelProdotto{$product.idProdotto}">{$product.quantitaProdotto} x {$product.nomeProdotto}</a> <span class="price">{$htmlValuta}{$product.prezzoProdotto}</span></p>
                
                
                {/foreach}
                <hr>
                
                <p>Total <span class="price" style="color:black"><b>{$htmlValuta}{$prezzoTotale}</b></span></p>
                
            </div>
            
</div>