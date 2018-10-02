{* Smarty *}
<div class="wrapper">
    <div id="categories">
        {foreach from=$categorie_for_tpl item="cat"}
            <a class="categoryclass" href="/spesa/catalogo/{$cat.id}">{$cat.nome}</a>
        {/foreach}
    </div>
    <div id="filters">
        <form id="filterform" action="altert('sended')">
            <h1 align="center"> FILTERS </h1>
            <div id="pricefilters" class="divfiltri">
                <label for="price-min">Price min:</label>
                <input type="input" name="price-min" id="price-min">
                <i class="fas fa-euro-sign"></i>

                <label for="price-max">Price max:</label>
                <input type="input" name="price-max" id="price-max" placeholder="MAX">
                <i class="fas fa-euro-sign"></i>
                <!-- PRICE CASELLA CON PLACEHOLDER MIN - MAX-->
            </div>
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
            </div>
            <input type="submit" value="Submit">
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
                    <input type="input" size="1" id="quantityOfProduct{$prodotto.id}">
                    <i class="far fa-2x fa-plus-square" onclick="addOne(this)"></i>
                    <i class="fas fa-2x fa-cart-plus" onclick='addToCart(this)'></i>
                </div>
                <div class="moreabout" id="moreabout{$prodotto.id}">

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
            <div class="cartList">
            </div>
        </div>
    </div>
</div>
