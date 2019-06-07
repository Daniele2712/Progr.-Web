{* Smarty *}
<div id="checkout">
    <div id="main_content">
        <div id="address" class="container">
            <div id="view_address" class="{if !$logged}hidden{/if}">
                <div class="title">Dati di spedizione</div>
                <div class="element_wrapper">
                    <input type="hidden" name="selected_id" value="{$mainAddress.id}"/>
                    <div class="element">
                        <div class="label">Nome:</div>
                        <div id="info_name" class="info">{$datiAnagrafici.nome} {$datiAnagrafici.cognome}</div>
                    </div>
                    <div class="element">
                        <div class="label">Indirizzo:</div>
                        <div id="info_indirizzo" class="info">{$mainAddress.via} {$mainAddress.civico}, {$mainAddress.comune}</div>
                    </div>
                     <div class="element">
                        <div class="label">Telefono:</div>
                        <div id="info_telefono" class="info">{$datiAnagrafici.telefono}</div>
                    </div>
                </div>
                <div class="actions">
                    <div id="edit_data_button" class="button">Modifica</div>
                    <div id="confirm_address" class="button">Continua</div>
                </div>
            </div>
            <div id="addresses_list">
                <div class="title">Scegli un indirizzo di spedizione</div>
                {if $logged}
                    {foreach $addresses as $addr}
                        <div class="saved_address">
                            <input type="hidden" name="id" value="{$addr.id}"/>
                            <input type="hidden" name="id_comune" value="{$addr.id_comune}"/>
                            <input type="hidden" name="note" value="{$addr.note}"/>
                            {$addr.comune}({$addr.provincia}), {$addr.via} n&deg; {$addr.civico}
                        </div>
                    {/foreach}
                {/if}
                <div class="actions">
                    <div id="add_address" class="button">Aggiungi</div>
                </div>
            </div>
            <div id="edit_address" class="{if $logged}hidden{/if}">
                <div class="title">Inserisci i dati di spedizione</div>
                <div class="element_wrapper">
                    <div class="element">
                        <div class="label">Nome:</div>
                        <div class="info">
                            <input type="text" name="nome" placeholder="Nome" value="{$datiAnagrafici.nome}"/>
                            <input type="text" name="cognome" placeholder="Cognome" value="{$datiAnagrafici.cognome}"/>
                        </div>
                    </div>
                    <div class="element">
                        <div class="label">Indirizzo:</div>
                        <div class="info">
                            <input type="text" name="comune" class="autoload_comune" placeholder="Comune" value="{$mainAddress.comune}">
                            <input type="hidden" name="comuneId" class="autoload_comune_id" value="{$mainAddress.id_comune}">
                            <input type="text" name="via" placeholder="Indirizzo" value="{$mainAddress.via}"/>
                            <input type="text" name="civico" placeholder="Civico" value="{$mainAddress.civico}"/>
                            <input type="text" name="note" placeholder="Note" value="{$mainAddress.note}"/>
                        </div>
                    </div>
                     <div class="element">
                        <div class="label">Telefono:</div>
                        <div class="info">
                            <input type="text" name="telefono" placeholder="Telefono" value="{$datiAnagrafici.telefono}"/>
                        </div>
                    </div>
                </div>
                <div class="actions">
                    <div id="save_address" class="button">Salva</div>
                </div>
            </div>
        </div>

        <div id="payment" class="container">
            <div class="title">Metodo di Pagamento</div>
            <div class="element_wrapper">

                <div class="payment_element" data-box="paypal_box">
                    <div class="fab fa-3x fa-cc-paypal"></div>
                    <div id="paypal_button">PayPal</div>
                </div>

                <div class="payment_element" data-box="mastercard_box">
                    <div class="fab fa-3x fa-cc-mastercard"></div>
                    <div id="mastercard_button">Mstercard</div>
                </div>

                <div class="payment_element" data-box="bitcoin_box">
                    <div class="fab fa-3x fa-bitcoin"></div>
                    <div id="bitcoin_button">Bitcoin</div>
                </div>

                <div class="payment_element" data-box="contrassegno_box">
                    <div class="fas fa-3x fa-money-bill-alt"></div>
                    <div id="contrassegno_button">Contrassegno</div>
                </div>
            </div>
            <div class="payment_method" id="mastercard_box">
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
            <div class="payment_method" id="paypal_box">
                <div class="title">PayPal</div>
                <form method="post" action="{$PayPal_url}">
                    <input type="hidden" name="cmd" value="_xclick"/>
                    <input type="hidden" name="item_name" value=""/>
                    <input type="hidden" name="currency_code" value="{$PayPal_valuta}"/>
                    <input type="hidden" name="lc" value="IT"/>
                    <input type="hidden" name="business" value="{$PayPal_email}"/>
                    <input type="hidden" name="notify_url" value="https://onlineshopping.com/api/paypal"/>
                    <input type="hidden" name="amount" value="{$PayPal_totale}"/>
                    <input type="hidden" name="custom" value=""/>
                    <input type="hidden" name="test_ipn" value="{$PayPal_sandbox}"/>
                    <input type="hidden" name="return" value="">
                    <input type="hidden" name="rm" value="2">
                    <input type="hidden" name="cbt" value="Ritorna al Negozio">
                    <div class="actions">
                        <input type="submit" id="paga_paypal" class="button" value="Continua su PayPal"/>
                    </div>
                </form>
            </div>
        </div>
        <div id="next" class="container">
            <div class="actions">
                <input type="submit" id="paga" class="button" value="Conferma e Paga"/>
            </div>
        </div>
    </div>
    <div id="cart" class="container">
        <h4>Carrello
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
        <p>Totale <span class="price" style="color:black"><b>{$valuta}{$totale}</b></span></p>
    </div>
</div>
