{* Smarty *}
<div class="wrapper">
    <div id="categories">
        {foreach from=$categorie_for_tpl item="cat"}
            <a class="categoryclass" href="/spesa/catalogo/{$cat.id}">{$cat.nome}</a>
        {/foreach}
    </div>
    <div id="filters">
        <form id="filterform" method="POST">
            <h1 align="center"> FILTERS </h1>
            {foreach from=$filtri_for_tpl item="filtro"}
                <div class="divfiltri" data-type="{$filtro.tipo}">
                    {if $filtro.tipo == "checkbox"}
                        <label>{$filtro.nome}</label><input type="checkbox" value='1' name='filter_{$filtro.nome}'/>
                    {elseif $filtro.tipo == "range"}
                        <p>{$filtro.nome}</p>
                        <label>Min</label><input name='filter_{$filtro.nome}_min'
                        {if isset($filtro.valore)}
                            value="{$filtro.valore[0]}"
                        {/if}
                        /><label>Max</label><input name='filter_{$filtro.nome}_max'
                        {if isset($filtro.valore)}
                            value="{$filtro.valore[1]}"
                        {/if}
                        />
                    {elseif $filtro.tipo == "value"}
                        <label>{$filtro.nome}</label><input name='{$filtro.nome}'
                        {if isset($filtro.valore)}
                            value="{$filtro.valore}"
                        {/if}
                        />
                    {elseif $filtro.tipo == "radio"}
                        <p>{$filtro.nome}</p>
                        {foreach from=$filtro.opzioni item=o}
                            <label>{$o.nome}</label><input type="radio" value="{$o.id}" name="filter_{$filtro.nome}"
                            {if isset($filtro.valore) && $filtro.valore == $o.id}
                                checked
                            {/if}
                            /><br/>
                        {/foreach}
                    {elseif $filtro.tipo == "multicheckbox"}
                        <p>{$filtro.nome}</p>
                        {foreach from=$filtro.opzioni item=o}
                            <label>{$o.nome}</label><input type="checkbox" value="{$o.id}" name="filter_{$filtro.nome}[]"
                            {if isset($filtro.valore) && in_array($o.id,$filtro.valore)}
                                checked
                            {/if}/><br/>
                        {/foreach}
                    {/if}
                </div>
            {/foreach}
            <!--<div id="pricefilters" class="divfiltri">
                <label for="price-min">Price min:</label>
                <input type="input" name="price-min" id="price-min">
                <i class="fas fa-euro-sign"></i>

                <label for="price-max">Price max:</label>
                <input type="input" name="price-max" id="price-max" placeholder="MAX">
                <i class="fas fa-euro-sign"></i>
                <!-- PRICE CASELLA CON PLACEHOLDER MIN - MAX-->
            <!--</div>
            <div id="ingredienti" class="divfiltri">
                <label>Senza Lattosio</label><input id="lattosio" type="checkbox">
                <label>Senza Glutine</label><input id="glutine" type="checkbox">
                <label>Carne Maiale</label><input id="carne_maiale" type="checkbox">
                <label>Carne Pollo</label><input id="carne_pollo" type="checkbox">
                <label>Formaggi</label><input id="latte" type="checkbox">
                <label>Macrocategoria1</label><input id="latte" type="checkbox">
                <label>Macrocategoria2</label><input id="latte" type="checkbox">
            </div>
            <div class="filterdiv" id="computer">
                <!--
                FAI UNA COSA DOVE PUO SCEGLIERE LE CARATTERSITICHE< ROBA VARIA
                -->
            <!--</div>-->
            <input type="hidden" name="filtered" value="true"/>
            <input type="submit" value="Filtra">
        </form>
    </div>
    <div id="items">
        {foreach from=$items_for_tpl item="prodotto"}
            <div class="item">
                <img src="/download/image/{$prodotto.imgId}"/>
                <p class="item_price">{$prodotto.valuta} {$prodotto.prezzo}</p>
                <div class="item_info"> <h4>{$prodotto.nome} </h4> {$prodotto.info} </div>
                <a class="item_more" onclick="popupToggle({$prodotto.id})">Dettagli <i class="fas fa-info-circle"></i></a>
                <div class="add_to_cart">
                    <i class="far fa-2x fa-minus-square" onclick="subtractOne(this)"></i>
                    <input type="input" size="1" class="qta">
                    <i class="far fa-2x fa-plus-square" onclick="addOne(this)"></i>
                    <i class="fas fa-2x fa-cart-plus" onclick='addToCart(this, {$prodotto.id})'></i>
                </div>
                <div class="moreabout">

                    <h2>Details</h2>
                    <a class="close" onclick="popupToggle({$prodotto.id})">&times;</a>
                    <div class="contentofdescription">
                        {$prodotto.descrizione}
                        Sono disponibili {$prodotto.supply} pezzi.
                    </div>
                </div>
            </div>
        {/foreach}
    </div>
    <div id="basket">
        <div id="basked_wrapper">
            <div id="basket-fa">
                <i id="imgCarello" class="fas fa-4x fa-cart-plus"></i>
            </div>
            <div>
                <div class="cartList">
                    {foreach from=$prodotti_for_carello item="prodotto"}
                        <div class="inListProduct" data-id="{$prodotto.id}">
                            <div>{$prodotto.quantita}</div>
                            <div class="nome">{$prodotto.nome}</div>
                            <div class="prezzo">{$valuta_for_carrello} {$prodotto.totale}</div>
                        </div>
                    {/foreach}
                </div>
                <div id="cart_total">
                    <span id="totale_nome"> TOTALE </span>
                    <span id="prezzo_totale">{$valuta_for_carrello} {$total_for_carrello}</span>
                </div>
            </div>

            <div id="pay">
                <button id="payButton">Pay Now</button>
            </div>
        </div>
    </div>
</div>
