{* Smarty *}
<div id="gestoreContent">
        
    
    <div id="macrosezioni">
                <div class="macrosezione" id="statistiche">Statistiche</div>
                <div class="macrosezione active" id="amministrazione">Amministrazione</div>
                <div class="macrosezione" id="impostazioni">Impostazioni</div>
    </div>
    
    <div id="sezioni">
        <div id="sezioniStatistiche">
            <div class="sezione" id="sezioneStatisticheMini">Statistiche</div>
            <div class="sezione" id="sezioneOrdini">Ordini</div>
            <div class="sezione" id="sezioniProdottiRicevuti">Prodotti ricevuti</div>
            <div class="sezione" id="sezioneProdottiVenduti">Prodotti venduti</div>
            
        </div>
            
        <div id="sezioniAmministrazione">
            <div class="sezione" id="sezioneMagazzini">Magazzino</div>
            <div class="sezione active" id="sezioneProdotti">Prodotti</div>
            <div class="sezione" id="sezioneDipendenti">Dipendenti</div>
        </div>
        
        <div id="sezioniImpostazioni">
            <div class="sezione" id="sezioneIInformazioni">Informazioni</div>
        </div>
    </div>
    
    <div id="sectionContent">
    
    <div id="sezioneMagazziniDiv" class="divGestionale notUpdated">
        <div class="upper">
            <div class="scritta">
                <span><b>Magazzini</b></span>
            </div>
            <div class="aggiungi">
                <span><button type="button"><i class="fas fa-plus"></i>&nbsp;Aggiungi&nbsp;Un bel niente&nbsp;<i class="fas fa-plus"></i></button></span> 
            </div>
            <div class="scrittaMagazzino">
                <b>Magazzino:</b>
            </div>
            <div class="nomeMagazzino">
                <span>Loading&nbsp;<i class="fa fa-spinner fa-spin" style="font-size:24px"></i></span>
                <span id="idMagazzino">1</span>
            </div> 
        </div>
            
        <div id="MagazziniLower">
            <div id='tableMagazzini' class="table">
                <div id='ColonneMagazzino' class='magazzino'>
                    <div id='idMagazzino'><b>ID</b></div>
                    <div id='cittaMagazzino'><b>Citta'</b></div>
                    <div id='CAPMagazzino'><b>CAP</b></div>
                    <div id='viaMagazzino'><b>Via</b></div>
                    <div id='numeroMagazzino'><b>Numero</b></div>
                    <div id='modificaMagazzino'><b>Modifica</b></div>
                </div>
                
                <div class='lineaDiSeparazione'></div>
                
                <div id='ElencoMagazzini'>
                    <div class='magazzino'>
                        <div>2</div>
                        <div>Roma</div>
                        <div>66100</div>
                        <div>Via XX Settembre</div>
                        <div>55</div>
                        <div><a href='.....ID'>Cambia Indirizzo</a></div>
                    </div>
                </div>
            </div>

        </div>
    </div>
            
            
            
    <div id="sezioneProdottiDiv" class="divGestionale notUpdated">
        <div class="upper">
            <div class="scritta">
                <span><b>Prodotti</b></span>
            </div>
            <div class="aggiungi">
                <button type="button" id="addProductButton"><i class="fas fa-plus"></i>&nbsp;Aggiungi&nbsp;Prodotto&nbsp;<i class="fas fa-plus"></i></button>
                <button type="button" id="addCategoriaButton"><i class="fas fa-plus"></i>&nbsp;Aggiungi&nbsp;Categoria&nbsp;<i class="fas fa-plus"></i></button> 
            </div>
            <div class="scrittaMagazzino">
                <b>Magazzino:</b>
            </div>
            <div class="nomeMagazzino">
                <span>Roma, 66100, Via col vento 24</span>
            </div> 
        </div>
        
        <div id="prodottiFiltro">     
            <div id="ProdottiFiltroPrezzo">
                         Price:
                          <input type="input" size="1" name="price-min" id="ProdottoPriceMin" placeholder='MIN'>&nbsp;-
                          <input type="input" size="1" name="price-max" id="ProdottoPriceMax" placeholder='MAX'>
            </div>

            <div id="ProdottiFiltroCategoria">
                Categoria:  <select id='inputProdottiFiltroCategoria'>
                                <option value="Tutte">Tutte</option>
                            </select>   
            </div>



            <div id="ProdottiFiltroNome">
                Nome:&nbsp;<input id="inputProdottiFiltroNome" type="text">
            </div>
            <div id="ProdottiSearch">
                 <button type="button" id="ProdottiSearchButton">FILTER&nbsp;<i class="fas fa-search"></i></button> 
            </div>
        </div>
        
        
        
        <div id="ProdottiLower">
            <div id='tableProdotti' class="table">
                <div id='ColonneProdotti' class='prodotto'>
                    <div id='idProdotto'><b>ID</b></div>
                    <div id='nomeProdotto'><b>Nome</b></div>
                    <div id='nomeProdotto'><b>Categoria</b></div>
                    <div id='descrizioneProdotto'><b>Descrizione</b></div>
                    <div id='infoProdotto'><b>Info</b></div>
                    <div id='prezzoProdotto'><b>€</b></div>
                    <div id='quantitaProdotto' title="ID Magazzino"><b>Mag.</b></div>
                    <div id='quantitaProdotto' title="Quantita'"><b>Qta</b></div>
                    <div><i class="far fa-image"></i></div>
                    <div id='modificaProdotto'><i class="far fa-edit"></i></div>
                    <div id='cancellaProdotto'><i class="fas fa-trash-alt"></i></div>
                    
                </div>
                <div class='lineaDiSeparazione'></div>
                <div id='ElencoProdotti'>
                </div>
            </div>

        </div>
            
            
      <div id="addProductDiv">
        <h1>Inserisci nuovo prodotto</h1>

      <form id="inserisciProdotto" method="POST" action="/upload/uploadProduct" enctype="multipart/form-data">

            <div><label>Image :</label><input type="file" name="image"></div>
            <div><label>Nome :</label><input type="text" name="nome" id="nomeProdotto"></div>
            <div><label>Descrizione :</label><textarea cols="40" rows="4" name="descrizione" placeholder="Describe the product"></textarea></div>
            <div><label>Info :</label><textarea cols="40" rows="4" name="info" placeholder="Info about the product"></textarea></div>
            <div>
                <label>Categoria :</label>
                <select id='listaCategorieInsert' name="categoria">
                </select>
            </div>
            <div><label>Price :</label><input type="text" name="prezzo"></div>
            <div><label>Valuta :</label><input type="text" name="valuta"></div>
            <div><label>Quantita :</label><input type="text" name="quantita"></div>
                {* DEVO FARE IN MODO CHE I GESTORI POSSONO SCEGLIERE SOLO TRA I PROPRI MAGAZZINI  *}      
            <div>
                <label>Magazzino :</label>
                <select class='listaNomiMagazzini'>
                </select>
            </div>
            <button type="submit">INSERT</button>
      </form>      
    </div>
        
    <div id="addCategoriaDiv">
    <h1>Aggiungi nuova categoria</h1>
      <form id="categoryForm" method="POST" action="/upload/uploadCategory" enctype="multipart/form-data">
            <div><label>Nome Categoria</label><input type="text" name="categoria"></div>
            <div><label>Nome Padre</label><input type="text" name="padre"></div>
            <button type="submit">INSERT</button>
      </form>
    </div>
        
     </div>        
             
             
             
             
             
        
    
        
    
        
    <div id="sezioneDipendentiDiv" class="divGestionale notUpdated">
        <div class="upper">
            <div class="scritta">
                <span><b>Dipendenti</b></span>
            </div>
            <div class="aggiungi">
                <button type="button" id="addEmplayee"><i class="fas fa-plus"></i>&nbsp;Aggiungi&nbsp;Dipendente&nbsp;<i class="fas fa-plus"></i></button> 
            </div>
            <div class="scrittaMagazzino">
                <b>Magazzino:</b>
            </div>
            <div class="nomeMagazzino">
                <span>Roma, 66100, Via col vento 24</span>
            </div> 
        </div>
            
        
        
        <div id="dipendentiFiltro">     
            <div id="DipendentiFiltroNome">
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Nome:&nbsp;<input id="inputDipendentiFiltroNome" type="text">
            </div>
            
            <div id="DipendentiFiltroRuolo">
                Ruolo:  <select id='inputDipendentiFiltroRuolo'>
                                <option>Tutti</option>
                        </select>   
            </div>

            <div id="DipendentiFiltroCognome">
                Cognome:&nbsp;<input id="inputDipendentiFiltroCognome" type="text">
            </div>
            
            <div id="DipendentiSearch">
                 <button type="button" id="DipendentiSearchButton">FILTER&nbsp;<i class="fas fa-search"></i></button> 
            </div>
        </div>

            <div id="DipendentiLower">
            <div id='tableDipendetni' class="table">
                <div id='ColonneDipendenti' class='dipendente'>
                    <div id='idDipendente'><b>ID</b></div>
                    <div id='nomeDipendente'><b>Nome</b></div>
                    <div id='cognomeDipendente'><b>Cognome</b></div>
                    <div id='ruoloDipendente'><b>Ruolo</b></div>
                    <div id='stipendioOrarioDipendente'><b>€/ora</b></div>
                    <div id='turniDipendente'><b>Turni</b></div>
                    <div id='modificaProdotto'><i class="far fa-edit"></i></div>
                    <div id='cancellaProdotto'><i class="fas fa-trash-alt"></i></div>
                    
                </div>
                
                <div class='lineaDiSeparazione'></div>
                
                <div id='ElencoDipendenti'>
                </div>
            </div>
            </div>


        <div class="addEmployeeDiv divGestionale">
            <form id="inserisciDipendente" method="POST" action="/upload/uploadDipendente" enctype="multipart/form-data">

                <div><label>Nome :</label><input type="text" name="nome" id="nomeDipendente"></div>
                <div><label>Cognome :</label><textarea cols="40" rows="4" name="cognome" placeholder="Cognome" id="cognomeDipendente"></textarea></div>
                <div><label>Ruolo :</label><textarea cols="40" rows="4" name="info" placeholder="ruolo del dipendente"></textarea></div>
                <div>
                    <label>Contratto :</label>
                    <select id='asd' name="contratto">
                    </select>
                </div>
                <div><label>Stipendio :</label><input type="text" name="stipendioOrario"></div>  
                <div>
                    <label>Magazzino :</label>
                    <select class='listaNomiMagazzini'>
                    </select>
                </div>
                <button type="submit">INSERT</button>
            </form>
        </div>
    </div>
    
    
     
     
    </div>
    
        
    
  
</div>
             </div>
