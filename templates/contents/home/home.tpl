{* Smarty *}
<div id="homeContent">
    <div id="dialog">
        <div id="shop_button">
            <img id="start" src="/templates/contents/home/img/shopnow_button.png"/>
        </div>
        <div id="guest_address">
            <h1>Seleziona il tuo indirizzo di spedizione</h1>
            <div id="add_location">
                <div><label for="citta">Citt&agrave;</label>
                  <input type="text" name="comune" class="autoload_comune" tabindex="1">
                  <input type="hidden" name="comuneId" class="autoload_comune_id"></div>
                <div><label>Via</label>
                  <input type="text" name="via" tabindex="2"></div>
                <div><label>Numero</label>
                  <input type="text" name="civico" tabindex="3"></div>
                <div><label>Note</label>
                  <input type="text" name="note" tabindex="4"></div>
                <div id="actions">
                  <div class="button next" tabindex="5">Continua</div>
                </div>
            </div>
        </div>
        <div id="user_address">
            <h1>Usare questo indirizzo di spedizione?</h1>
            <div id="location"></div>
            <div id="actions">
                <div class="button next">Continua</div>
                <div class="button change">Cambia</div>
            </div>
        </div>
        <div id="user_addresses">
            <h1>Seleziona il tuo indirizzo di spedizione</h1>
            <div id="locations">
            </div>
            <div id="add_new" class="button">
                Aggiungi
            </div>
        </div>
        <div id="new_user_address">
            <h1>Seleziona il tuo indirizzo di spedizione</h1>
            <div id="add_location">
                <div><label for="citta">Citt&agrave;</label>
                  <input type="text" name="comune" class="autoload_comune" tabindex="1">
                  <input type="hidden" name="comuneId" class="autoload_comune_id"></div>
                <div><label>Via</label>
                  <input type="text" name="via" tabindex="2"></div>
                <div><label>Numero</label>
                  <input type="text" name="civico" tabindex="3"></div>
                <div><label>Note</label>
                  <input type="text" name="note" tabindex="4"></div>
                <div id="actions">
                  <div class="button next" tabindex="5">Continua</div>
                </div>
            </div>
        </div>
    </div>
</div>
