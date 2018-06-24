{* Smarty *}

{*
Le cose che ricevero in ingresso qui sono 
1) una lista degli item che sono in vendita         $prodotti_for_tpl
2) una lista dei prodotti che stanno nel carello    $prodotti_for_carello
3)il nome di chi sta facendo la spesa???? forse...
*}
<!DOCTYPE html>
<html>
    <html lang="en">
    <head>
        <meta charset="utf-8"/>
       
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.1.0/css/all.css" integrity="sha384-lKuwvrZot6UHsBSfcMvOkWwlCMgc0TaWr+30HWe3a4ltaBwTZhyTEggF5tJv8tbt" crossorigin="anonymous">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
        <link rel="stylesheet" href="css/style_spesa.css">
        
        
    </head>
   
    <body>
        <div class="wrapper">
            <div id="logo"><img id ="imglogo" src="img/logo.png"/></div>
            
            <div id="search">
                <form id="searchform" method="get">
                <label for="search">Search</label> <input type="text" name="username" id="searchinput"> <input type="submit" name="searchgo" value="Go">
                </form>
                
            </div>
            <div id="profile">
                <i id="shoppingbasketimg" onclick="alert('wow')" class="fas fa-3x fa-shopping-basket"></i>
                <i id="listimg" class="fas fa-3x fa-clipboard-list"></i>            <!-- Forse e meglio mettere con in Jquerry i listener-->
                <i id="profileimg" class="fas fa-2x fa-user"> Sig Rossi Mario</i>
            </div>
            <div id="categories">
                <div class="categoryclass">elettrodomestici</div>
                <div class="categoryclass"> televisori</div>
                <div class="categoryclass">telefoni</div>
                <div class="categoryclass">portatili</div>
                
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
                {foreach from=$prodotti_for_tpl item="prodotto"}
                
                <div class="item">
                    <img class="item_img" src="img/jung.jpg">
                    <p class="item_price">
                        {*QUESTA PARTE ANDRA SOSTITUITA XKE VOGLIO PASSARLI UN PROOTTO FOR TPN CON GIA DENTRO IL CODICE HTML PER LA VALUTA*}
                    {if $prodotto.valuta eq 'EUR'}
                        &#8364;
                    {elseif $prodotto.valuta eq 'USD'}
                        &#36;
                    {elseif $prodotto.valuta eq 'GPB'}
                        &#163;
                    {elseif $prodotto.valuta eq 'BTC'}
                        Ƀ
                    {elseif $prodotto.valuta eq 'JPY'}
                        &#65509;
                    {else}
                        ???
                    {/if}{$prodotto.prezzo}</span>
                    <p class="item_description">{$prodotto.nome}</p>
                    <p class="item_more" onclick="showInfo(this)">Dettagli <i class="fas fa-info-circle"></i></p>
                    <div class="add_to_cart">
                        <i class="far fa-2x fa-minus-square" onclick="subtractOne(this)"></i>
                        <input type="input" size="1" name="quantity" id="item_quantity">
                        <i class="far fa-2x fa-plus-square" onclick="addOne(this)"></i>
                        <i class="fas fa-2x fa-cart-plus" onclick="addToCart(this)"></i>
                    </div>
                </div>
                
            {/foreach}
                
            </div>
            
            
             <div id="basket">
                 <div id="basked_wrapper">
                    <div id="basket-fa">
                        <i id="imgCarello" class="fas fa-4x fa-cart-plus"></i>
                        <span class="nameOfCart">Carrello Default  <i class="fas fa-info-circle"></i></span>
                    </div>
                        
                     <div class="cartList">
                            {foreach from=$prodotti_for_carello item="prodotto"}
                
                                <div class="inListProduct">
                                    <span>{$prodotti_for_carello.numero}</span>
                                    <span> x </span>
                                    <span>{$prodotti_for_carello.nome}</span>
                                    <span class="prezzo">
                                        {$prodotti_for_carello.valuta_html}
                                        {$prodotti_for_carello.prezzo}</span>
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
                 
       
                 
                 <div class="footer">footerrr</div>
        <script src="js/myscripts.js"></script>
    </body>
  
</html>
