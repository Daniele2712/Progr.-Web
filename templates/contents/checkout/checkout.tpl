{* Smarty *}
<div id="main_wrapper">
    <form method="post" action="/spesa/ordine">
        <div id="address" class="container">
            <div id="view_address" class="{if !$logged}hidden{/if}">
                <div class="title">Dati di spedizione</div>
                <div class="element_wrapper">
                    <div class="element">
                        <p>Nome <i class="fas fa-2x fa-user-alt"></i></p>
                        <p>{$datiAnagrafici.nome} {$datiAnagrafici.cognome}</p>
                    </div>
                    <div class="element">
                        <p>Indirizzo <i class="fas  fa-2x fa-people-carry"></i></p>
                        <p>{$indirizzo.via} {$indirizzo.civico}, {$indirizzo.comune}</p>
                    </div>
                     <div class="element">
                        <p>Telefono <i class="fas  fa-2x fa-mobile-alt"></i></p>
                        <p>{$datiAnagrafici.telefono}</p>
                    </div>
                </div>
                <div class="actions">
                    <div id="edit_data_button" class="button">Modifica</div>
                </div>
            </div>
            <div id="edit_address" class="{if $logged}hidden{/if}">
                <div class="title">Inserisci i dati di spedizione</div>
                <div class="element_wrapper">
                    <div class="element">
                        <p>Nome <i class="fas fa-2x fa-user-alt"></i></p>
                        <input type="text" name="nome" placeholder="Nome"/>
                        <input type="text" name="cognome" placeholder="Cognome"/>
                    </div>
                    <div class="element">
                        <p>Indirizzo <i class="fas  fa-2x fa-people-carry"></i></p>
                        <input type="text" name="comune" placeholder="Comune" value="{$indirizzo.comune}"/>
                        <input type="hidden" name="id_comune" value="{$indirizzo.id_comune}"/>
                        <input type="text" name="indirizzo" placeholder="Indirizzo" value="{$indirizzo.via}"/>
                        <input type="text" name="civico" placeholder="Civico" value="{$indirizzo.civico}"/>
                        <input type="text" name="note" placeholder="Note" value="{$indirizzo.note}"/>
                    </div>
                     <div class="element">
                        <p>Telefono <i class="fas  fa-2x fa-mobile-alt"></i></p>
                        <input type="text" name="telefono" placeholder="Telefono"/>
                    </div>
                </div>
                <div class="actions">
                    <div id="save_data" class="button">Salva</div>
                </div>
            </div>
        </div>

        <div id="payment" class="container">
            <div class="title">Select Payment method</div>
            <div class="element_wrapper">
                <div class="payment_element">
                    <div class="fab fa-3x fa-cc-mastercard"></div>
                    <div class="mastercard">Mstercard</div>
                </div>

                <div class="payment_element">
                    <div class="fab fa-3x fa-bitcoin"></div>
                    <div class="bitcoin">Bitcoin</div>
                </div>

                <div class="payment_element">
                    <div class="fas fa-3x fa-money-bill-alt"></div>
                    <div class="contrassegno">Contrassegno</div>
                </div>
            </div>
            <div id="payment_method">
                <input type="hidden" name="tipo_pagamento" value="Carta"/>
                <div class="title">Mastercard</div>
                <div class="element_wrapper">
                    <div>
                        <label for="intestatario">Nome sulla carta</label>
                        <input type="text" id="intestatario" name="carta_nome" placeholder="Mario">
                    </div>
                    <div>
                        <label for="intestatario">Cognome sulla carta</label>
                        <input type="text" id="intestatario" name="carta_cognome" placeholder="Rossi">
                    </div>
                    <div>
                        <label for="numero">Numero Carta di creito</label>
                        <input class="double" type="text" id="numero" name="carta_num" placeholder="1111-2222-3333-4444">
                    </div>
                    <div>
                        <label for="scadenza">Scadenza</label>
                        <input type="text" id="scadenza" name="carta_scadenza" placeholder="MM/AAAA">
                    </div>
                    <div>
                        <label for="cvv">CVV</label>
                        <input type="text" id="cvv" name="carta_cvv" placeholder="352">
                    </div>
                </div>
            </div>
        </div>
        <div id="next" class="container">
            <div class="actions">
                <input type="submit" id="paga" class="button" value="Conferma e Paga"/>
            </div>
        </div>
    </form>
    <div id="cart" class="container">
        <h4>Cart
          <span class="price" style="color:black">
            <i class="fa fa-shopping-cart"></i>
            <b>{$numItems}</b>
          </span>
        </h4>
        {foreach from=$productsArray item='product'}
            <p>
                <a href="/prodotto/view/{$product.idProdotto}">{$product.quantitaProdotto} x {$product.nomeProdotto}</a>
                <span class="price">{$valuta}{$product.prezzoProdotto}</span>
            </p>
        {/foreach}
        <hr>
        <p>Total <span class="price" style="color:black"><b>{$valuta}{$totale}</b></span></p>
    </div>
</div>
