{* Smarty *}

<div class="wrapper">
        <div id="title"><h2>I tuoi ordini</h2></div>
        
    {if $registrato eq 'false'}
         <div class="enterCode">
                 <span>Input the code you recived</span> <input id="code" type='text'/><button onclick="searchByCode()">SEARCH</button>
         </div>
         
         <div class="ordersBox">
       <div class="Columns">
            <span>Dettagli</span>
            <span>Richiesta</span>
            <span>Arrivo</span>
            <span>SubTotale</span>
            <span>Spedizione</span>
            <span>Totale</span>
            <span>Stato</span>
       </div>
             
         
             <div class="orders">
                 
                 
                 
             </div> 
         
         </div>
             
    {elseif $registrato eq 'true'}     
   <div class="ordersBox">
       <div class="Columns">
            <span>Dettagli</span>
            <span>Richiesta</span>
            <span>Arrivo</span>
            <span>SubTotale</span>
            <span>Spedizione</span>
            <span>Totale</span>
            <span>Stato</span>
       </div>
    
       
     
     
         <div class="orders">
            {foreach from=$arrayOrdini item='ordine'}

                <div class="ordineEntry">
                    <div class="orderDetails">
                        <span><i onclick="mostra_dettagli('{$ordine->id}')" title="{$ordine->id}" class="fa fa-plus-square fa-2x " aria-hidden="true"></i></span>
                        <span>{$ordine->data_ordine}</span>
                        <span>{$ordine->data_consegna}</span>
                        <span>{$ordine->subtotale}</span>
                        <span>{$ordine->spese_spedizione}</span>
                        <span>{$ordine->totale}</span>
                        <span>{$ordine->stato}</span>
                    </div>
                     <div class="productsDetails" id="productsDetailsOrder{$ordine->id}" ></div>
                </div>
                {/foreach}
           </div>
            
     </div>
     {else}
         Non dovrebbe mai comparire questa scritta. 
     {/if}

       
 

</div>