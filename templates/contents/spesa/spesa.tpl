{* Smarty *}

        <div class="wrapper">

            <div id="categories">
                <div class="categoryclass">elettrodomestici</div>
                <div class="categoryclass"> televisori</div>
                <div class="categoryclass">telefoni</div>
                <div class="categoryclass">portatili</div>
                
                
                
                
                 {foreach from=$categorie_for_tpl item="cat"}   
                    <div class="categoryclass">{$cat}</div>
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
                    <img class="item_img" src="/templates/img/jung.jpg">        {* Qui ci andra il blob  *}
                    <p class="item_price">{$prodotto.valuta} {$prodotto.prezzo}</p>
                    <div class="item_info"> <h4>{$prodotto.nome} </h4> {$prodotto.info} </div>
                    <a class="item_more" onclick="popupToggle({$prodotto.id})">Dettagli <i class="fas fa-info-circle"></i></a>
                    <div class="add_to_cart">
                        <i class="far fa-2x fa-minus-square" onclick="subtractOne(this)"></i>
                        <input type="input" size="1" name="quantity" id="item_quantity">
                        <i class="far fa-2x fa-plus-square" onclick="addOne(this)"></i>
                        <i class="fas fa-2x fa-cart-plus" onclick="addToCart(this)"></i>
                    </div>
                    <div class="moreabout" id="moreabout{$prodotto.id}">
                    
                        <h2>Details</h2>
                        <a class="close" onclick="popupToggle({$prodotto.id})">&times;</a>
                        <div class="contentofdescription">
			{$prodotto.descrizione}
                        </div>
	
                    </div>
                </div>

            {/foreach}

            </div>


             <div id="basket">
                 <div id="basked_wrapper">
                    <div id="basket-fa">
                        <i id="imgCarello" class="fas fa-4x fa-cart-plus"></i>
                        <span class="nameOfCart">Carrello Default</span>
                    </div>

                     <div class="cartList">
                            {foreach from=$prodotti_for_carello item="prodotto"}

                                <div class="inListProduct">
                                    <span>{$prodotto.quantita}</span>
                                    <span> x </span>
                                    <span>{$prodotto.nome}</span>
                                    <span class="prezzo">{$prodotto.valuta}  {$prodotto.totale}</span>
                                </div>
                      

                            {/foreach}



                                <div class="inListProduct">
                                    <span>15</span>
                                    <span> x </span>
                                    <span> Miele </span>
                                    <span class="prezzo"> &#8364; 13,50 </span>
                                </div>

                                <div class="inListProduct">
                                    <span>15</span>
                                    <span> x </span>
                                    <span class="inListName" title="Mieledsadasdsad asdasd"> Mieledsadasdsad asdasd </span>
                                    <span class="prezzo"> &#8364; 13,50 </span>
                                </div>

                                <div class="inListProduct">
                                    <span>15</span>
                                    <span> x </span>
                                    <span> dsdsdsdsds </span>
                                    <span class="prezzo"> &#8364; 13,50 </span>
                                </div>

                                <div id="cart_total">
                                    <span id="totale_nome"> TOTALE </span>
                                    <span class="prezzo_totale"> &#8364; 132,50 </span>
                                </div>


                        </div>


                    </div>

                </div>
                            
                            </div>


