{* Smarty *}
<div id="gestoreContent">
        
    
    <div id="macrosezioni">
                <div class="macrosezione" id="statistiche">Statistiche</div>
                <div class="macrosezione active" id="amministrazione">Amministrazione</div>
                <div class="macrosezione" id="impostazioni">Impostazioni</div>
    </div>
    
    <div id="sezioni">
        <div id="sezioniStatistiche">
            sono l-amministratoreee!!!!!!!!!1
            <div class="sezione" id="sezioneOrdini">Ordini</div>
            {if $logged != 'Amministratore'}
            <div class="sezione" id="sezioniProdottiRicevuti">Prodotti ricevuti</div>
            <div class="sezione" id="sezioneProdottiVenduti">Prodotti venduti</div>
            {/if}
        </div>
            
        <div id="sezioniAmministrazione">
           
                <div class="sezione active" id="sezioneProdotti">Prodotti</div>
            {if $logged != 'Amministratore'}  
                <div class="sezione active" id="sezioneMagazzini">Magazzini</div>
            {else}
                 
                 <div class="sezione active" id="sezioneMagazzini">Magazzino</div>
            {/if}
            <div class="sezione" id="sezioneDipendenti">Dipendenti</div>
            {if $logged != 'Amministratore'}
            <div class="sezione" id="sezioneAggiungiCategorie">Aggiungi Categoie</div>
            <div class="sezione" id="sezioneFiltri">Friltri</div>
            <div class="sezione" id="sezioneOfferte">Offerte</div>
            {/if}
        </div>
        
        <div id="sezioniImpostazioni">
            <div class="sezione" id="">Password</div>
            <div class="sezione" id="">Impostazione Sito</div>
            <div class="sezione" id="">Informazioni</div>
        </div>
    </div>
    
    <div id="content">
    
    <div class="sezioneProdottiDiv divGestionale">
        <div id="ProdottiUpper">
        <div id="scrittaProdotti">
            <span><b>Prodotti</b></span>
            {if $logged != 'Amministratore'}
                <button type='button' onclick="aggiungiProdoto()">Aggiungi Prodotto</button>
            {/if}    
        </div>
            {if $logged eq 'Gestore'}
                <span id="scrittaLocazione"><b>Magazzino</b>: Via Giuseppe Verdi 22, Milano {*{$indirizzoMagazzino}*}</span>
            {elseif $logged == 'Amministratore'}
                <div id="ProdottiFiltroMagazzino">
                   Magazzino: <select class='listaNomiMagazzini'><option>Tutti</option></select>
                    </div>
            {else}<span id="scrittaLocazione">Come sei arrivato qui se non sei ne gestore ne amministratore?</span>
            {/if}
        
        
             
        <div id="ProdottiFiltroPrezzo">
            SONO AMMINISTRATORE
                      <label>Price range</label>
                      <input type="input" size="1" name="price-min" id="ProdottoPriceMin" placeholder='MIN'>&nbsp;--
                      <input type="input" size="1" name="price-max" id="ProdottoPriceMax" placeholder='MAX'>
        </div>
        
        <div id="ProdottiFiltroCategoria">
            Categoria: <select class='ListaCategorie'><option>Tutte</option></select>   
        </div>
             
         
              
        <div id="ProdottiNomeFiltro">
            Nome:&nbsp;<input id="inputProdottiNomeFilter" type="text">
        </div>
        <div id="ProdottiSearch">
             <button type="button" id="ProdottiSearchButton">FILTER&nbsp;<i class="fas fa-search"></i></button> 
        </div>
        </div>
        
        
        <div id="ProdottiLower">
            <div id='tableProdotti'>
                <div id='ColonneProdotti' class='prodotto'>
                    <div id='idProdotto'><b>ID</b></div>
                    <div id='nomeProdotto'><b>Nome</b></div>
                    <div id='nomeProdotto'><b>Categoria</b></div>
                    <div id='descrizioneProdotto'><b>Descrizione</b></div>
                    <div id='infoProdotto'><b>Info</b></div>
                    <div id='prezzoProdotto'><b>€</b></div>
                    <div id='quantitaProdotto'><b>Magazzino</b></div>
                    <div id='quantitaProdotto'><b>Qta</b></div>
                    <div><i class="far fa-image"></i></div>
                    <div id='modificaProdotto'><i class="far fa-edit"></i></div>
                    <div id='cancellaProdotto'><i class="fas fa-trash-alt"></i></div>
                    
                </div>
                <div id='lineaDiSeparazione'></div>
                <div id='ElencoProdotti'>
                    
                    <div class='prodotto'>
                        <div>32</div>
                        <div>Collina</div>
                        <div>Verde e azzurra</div>
                        <div>info disponibili sul nostro sito di fiducia</div>
                        <div>13,43€</div>
                        <div>55</div>
                        <div>Roma, Via Giuseppe Garibaldi 3</div>
                        <div>55</div>
                         <div><i class="far fa-image"></i></div>
                        <div><i class="far fa-edit"></i></div>
                        <div><i class="fas fa-trash-alt"></i></div>
                    </div>
                       
                </div>
            </div>

        </div>
        
     </div>        
             
             
             
             
             
        
    <div class="sezioneAggiungiProdottiDiv divGestionale">
      <h1>Inserisci nuovo prodotto</h1>

      <form id="inserisciProdotto" method="POST" action="/upload/uploadProduct" enctype="multipart/form-data">

            <div><label>Image :</label><input type="file" name="image"></div>
            <div><label>Nome :</label><input type="text" name="nome" id="nomeProdotto"></div>
            <div><label>Descrizione :</label><textarea cols="40" rows="4" name="descrizione" placeholder="Describe the product"></textarea></div>
            <div><label>Info :</label><textarea cols="40" rows="4" name="info" placeholder="Info about the product"></textarea></div>
            <div>
                <label>Categoria :</label>
                <select class='ListaCategorie' name="categoria">
                </select>
            </div>
            <div><label>Price :</label><input type="text" name="prezzo"></div>
            <div><label>Valuta :</label><input type="text" name="valuta"></div>
            <div><label>Quantita :</label><input type="text" name="quantita"></div>
            {if $logged != 'Amministratore'}{*      !! DEVO CAMBIARE IL != in ==  , != e solo provvisorio per programmare delle cose    *}      
            <div>
                <label>Magazzino :</label>
                <select class='listaNomiMagazzini'>
                </select>
            </div>
            {/if}
            <button type="submit">INSERT</button>
      </form>      
    </div>
        
    <div class="sezioneAggiungiCategorieDiv divGestionale">
    <h1>Aggiungi nuova categoria</h1>
      <form id="categoryForm" method="POST" action="/upload/uploadCategory" enctype="multipart/form-data">
            <div><label>Nome Categoria</label><input type="text" name="categoria"></div>
            <div><label>Nome Padre</label><input type="text" name="padre"></div>
            <button type="submit">INSERT</button>
      </form>
    </div>
    
    
        
    <div class="updateOfferte divGestionale">
          <h1>UPDATEEEE OFEERTA </h1>
    </div>
        
    
        
    <div class="sezioneDipendentiDiv divGestionale">
    <h1>Dipendnteni </h1>
    </div>
    
    <div class="sezioneAggiungiDipendentiDiv divGestionale">
    <h1>aggiungi dipendenti </h1>
    </div>
     
     
    </div>
    
        
    
  
</div>
             </div>
