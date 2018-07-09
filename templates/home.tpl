{* Smarty *}

        <div id="homeContent">
            
                <div id="locator">
                    <h1>Selezione il tuo inzirizzo di spedizione</h1>
                    <div id="selectlocation">
                        <form class="login"  action="/shop/spesaSenzaLogin" method="post">

                            <div><label for="citta">Citta'</label>
                              <input type="text" name="citta" id="citta"></div>
                            <div><label>Via</label>
                              <input type="text" name="via" id="via"></div>
                            <div><label>Numero</label>
                              <input type="text" name="numero" id="numero"></div>
                            <div><label>Interno</label>
                              <input type="text" name="interno" id="interno"></div>
                            <div class="actions" id='inizialaspesa'>
                              <input type="submit" name="inizialaspesa" value="Inizia la spesa!">
                            </div>
                        </form>
                    </div>
               </div>
        
        </div>
    