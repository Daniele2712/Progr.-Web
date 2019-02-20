{* Smarty *}
<div id="homeContent">
    {if isset($message) && $message}
        <div id="message_box">
            {$message}
        </div>
    {/if}
    <div id="dialog">
        <div id="shop_button">
            <img id="start" src="/templates/contents/home/img/shopnow_button.png"/>
        </div>
        <div id="guest_address">
            <h1>Seleziona il tuo indirizzo di spedizione</h1>
            <div id="add_location">
                <div><label for="citta">Citt&agrave;</label>
                  <input type="text" name="comune" class="autoload_comune">
                  <input type="hidden" name="comuneId" class="autoload_comune_id"></div>
                <div><label>Via</label>
                  <input type="text" name="via"></div>
                <div><label>Numero</label>
                  <input type="text" name="civico"></div>
                <div><label>Note</label>
                  <input type="text" name="note"></div>
                <div class="message"></div>
                <div id="actions">
                  <button class="button next">Continua</button>
                </div>
            </div>
        </div>
        <div id="user_address">
            <h1>Usare questo indirizzo di spedizione?</h1>
            <div id="location"></div>
            <div id="actions">
                <button class="button next">Continua</button>
                <button class="button change">Cambia</button>
            </div>
        </div>
        <div id="user_addresses">
            <h1>Seleziona il tuo indirizzo di spedizione</h1>
            <div id="locations">
            </div>
            <button id="add_new" class="button">
                Aggiungi
            </button>
        </div>
        <div id="new_user_address">
            <h1>Seleziona il tuo indirizzo di spedizione</h1>
            <div id="add_location">
                <div><label for="citta">Citt&agrave;</label>
                  <input type="text" name="comune" class="autoload_comune">
                  <input type="hidden" name="comuneId" class="autoload_comune_id"></div>
                <div><label>Via</label>
                  <input type="text" name="via"></div>
                <div><label>Numero</label>
                  <input type="text" name="civico"></div>
                <div><label>Note</label>
                  <input type="text" name="note"></div>
                <div id="actions">
                  <button class="button next">Continua</button>
                </div>
            </div>
        </div>
    </div>
</div>
