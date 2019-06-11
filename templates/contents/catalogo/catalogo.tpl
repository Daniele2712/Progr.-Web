{* Smarty *}

{function name=pager current=0 link='' }
    <div class=pager>
        {$last = 0}
        {foreach $pages as $page}
            {if $page != $last+1}
                <span>...</span>
            {/if}
            {if $current === $page}
                <div class="page button current">{$page}</div>
            {else}
                <a class="page button" href="{$link}/{$page}">{$page}</a>
            {/if}
            {$last = $page}
        {/foreach}
    </div>
{/function}

<div id="categories">
    {foreach from=$categories item="cat"}
        <a class="categoryclass {$cat.active}" href="/spesa/catalogo/{$cat.id}">{$cat.nome}</a>
    {/foreach}
</div>
<div id="left">
    {if count($subcategories) > 0}
        <div id="subcategories" class="dialog">
            <h1 align="center">sottocategorie</h1>
            {foreach from=$subcategories item="sub"}
                <a class="subcategoryclass {$sub.active}" href="/spesa/catalogo/{$sub.id}">{$sub.nome}</a>
            {/foreach}
        </div>
      {/if}

    <div id="filters" class="dialog">
        <form id="filterform" method="POST">
            <h1 align="center">filtri</h1>
            <div class="dialog-wrapper">
              {foreach from=$filtri_for_tpl item="filtro"}
                  <div class="divfiltri" data-type="{$filtro.tipo}">
                      {if $filtro.tipo == "checkbox"}
                          <label>{$filtro.nome}</label><input type="checkbox" value='1' name='filter_{$filtro.nome}'/>
                      {elseif $filtro.tipo == "range"}
                          <p>{$filtro.nome}</p>
                          <div><label>Min</label><input type='text' name='filter_{$filtro.nome}_min'
                          {if isset($filtro.valore)}
                              value="{$filtro.valore[0]}"
                          {/if}
                          /></div><div><label>Max</label><input type='text' name='filter_{$filtro.nome}_max'
                          {if isset($filtro.valore)}
                              value="{$filtro.valore[1]}"
                          {/if}
                          /></div>
                      {elseif $filtro.tipo == "value"}
                        <div><label>{$filtro.nome}</label><input type='text' name='{$filtro.nome}'
                          {if isset($filtro.valore)}
                              value="{$filtro.valore}"
                          {/if}
                          /></div>
                      {elseif $filtro.tipo == "radio"}
                          <p>{$filtro.nome}</p>
                          {foreach from=$filtro.opzioni item=o}
                              <div><label>{$o.nome}</label><input type="radio" value="{$o.id}" name="filter_{$filtro.nome}"
                              {if isset($filtro.valore) && $filtro.valore == $o.id}
                                  checked
                              {/if}
                              /></div>
                          {/foreach}
                      {elseif $filtro.tipo == "multicheckbox"}
                          <p>{$filtro.nome}</p>
                          {foreach from=$filtro.opzioni item=o}
                              <div><label>{$o.nome}</label><input type="checkbox" value="{$o.id}" name="filter_{$filtro.nome}[]"
                              {if isset($filtro.valore) && in_array($o.id,$filtro.valore)}
                                  checked
                              {/if}/></div>
                          {/foreach}
                      {/if}
                  </div>
              {/foreach}
                <input type="hidden" name="filtered" value="true"/>
                <button id="reset_filters" type=button class="button">Reset Filtri</button>
                <button class="button">Filtra</button>
            </div>
        </form>
    </div>
</div>
{pager pages=$pages current=$current_page link=$link}
<div id="items">
    {foreach from=$items_for_tpl item="prodotto"}
        <div class="item">
            <img src="/download/image/{$prodotto.imgId}"/>
            <p class="item_price">{$prodotto.valuta} {$prodotto.prezzo}</p>
            <div class="item_info"> <h4>{$prodotto.nome} </h4> {$prodotto.info} </div>
            <a class="item_more" onclick="popupToggle({$prodotto.id})">Dettagli <i class="fas fa-info-circle"></i></a>
            <div class="add_to_cart">
                <i class="far fa-2x fa-minus-square" onclick="subtractOne(this)"></i>
                <input type="text" size="1" class="qta">
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
{pager pages=$pages current=$current_page link=$link}
<div id="basket">
    <div id="basked_wrapper" class="dialog">
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
            <button id="payButton" class="button">Paga</button>
        </div>
    </div>
</div>
