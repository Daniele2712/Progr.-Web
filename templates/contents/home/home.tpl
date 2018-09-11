{* Smarty *}
<div id="homeContent">
    <div id="dialog">
        <div id="shop_button">
            <img id="start" src="/templates/contents/home/img/shopnow_button.png"/>
        </div>
        <div id="guest_address">
            <h1>Selezione il tuo indirizzo di spedizione</h1>
            <div id="add_location">
                <form class="login"  action="/shop/SpesaSenzaLogin" method="post">
                    <div><label for="citta">Citt&agrave;</label>
                      <input type="text" name="comune" class="autoload_comune">
                      <input type="hidden" name="comuneId" class="autoload_comune_id"></div>
                    <div><label>Via</label>
                      <input type="text" name="via"></div>
                    <div><label>Numero</label>
                      <input type="text" name="civico"></div>
                    <div><label>Interno</label>
                      <input type="text" name="note"></div>
                    <div class="actions">
                      <input type="submit" value="Inizia la spesa!">
                    </div>
                </form>
            </div>
        </div>
        <div id="user_address">
            <h1>Usare questo indirizzo di spedizione?</h1>
            <div class="location">

            </div>
        </div>
    </div>
</div>
