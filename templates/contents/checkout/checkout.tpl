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
                    <p>Giuseppe Calabrese</p>
                </div>
                
                <div class="recapElement">
                    <p>Indirizzo <i class="fas  fa-2x fa-people-carry"></i></p>
                    <p>Via Verdi 52, Roma</p>
                </div>
                
                 <div class="recapElement">
                    <p>Telefono <i class="fas  fa-2x fa-mobile-alt"></i></p>
                    <p>3917623827</p>
                </div>
                
                
            </div>
            
            <div class="container details">
                <form id="pagamentoMastercard">
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
                      
                      <button  id="paga" type="submit" form="pagamentoMastercard" value="Submit">Paga</button>
                </form> 
                
            </div>
            

            
            <div class="container cart">
                <h4>Cart
                  <span class="price" style="color:black">
                    <i class="fa fa-shopping-cart"></i>
                    <b>4</b>
                  </span>
                </h4>
                <p><a href="#">Product 1</a> <span class="price">$15</span></p>
                <p><a href="#">Product 2</a> <span class="price">$5</span></p>
                <p><a href="#">Product 3</a> <span class="price">$8</span></p>
                <p><a href="#">Product 4</a> <span class="price">$2</span></p>
                <hr>
                <p>Total <span class="price" style="color:black"><b>$30</b></span></p>
            </div>
            
            
            
            
</div>