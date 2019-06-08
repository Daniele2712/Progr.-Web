{* Smarty *}
<div id="gestoreContent">
    <div id="veil"></div>


<div id="macrosezioni">
            <div class="macrosezione" id="statistiche">Statistiche</div>
            <div class="macrosezione active" id="amministrazione">Amministrazione</div>
            <div class="macrosezione" id="impostazioni">Impostazioni</div>
</div>

<div id="sezioni">
    <div id="sezioniStatistiche" class="gruppoDiSezioni">
        <div class="sezione" id="sezioneStatistiche">Statistiche</div>
        <div class="sezione notUpdated" id="sezioneOrdini">Ordini</div>
        <div class="sezione notUpdated" id="sezioneProdottiRicevuti">Prodotti ricevuti</div>
        <div class="sezione notUpdated" id="sezioneProdottiVenduti">Prodotti venduti</div>

    </div>

    <div id="sezioniAmministrazione"  class="gruppoDiSezioni">
        <div class="sezione" id="sezioneMagazzini">Magazzino</div>
        <div class="sezione active" id="sezioneProdotti">Prodotti</div>
        <div class="sezione" id="sezioneDipendenti">Dipendenti</div>
        <div class="sezione" id="sezioneGestori">Gestori</div>
    </div>

    <div id="sezioniImpostazioni"  class="gruppoDiSezioni">
        <div class="sezione" id="sezioneProfilo">Profilo</div>
        <div class="sezione" id="sezioneSitoWeb">Sito Web</div>
    </div>
</div>

<div id="sectionContent">

    <div id="sezioneStatisticheDiv" class="divGestionale">
        <div class="upperStats">
            <div class="scrittaStats">
                <span><b>Magazzino :</b></span>
            </div>
            <div class="nomeMagazzinoStats">
                <span class="magazzinoSelezionato">Loading&nbsp;<i class="fa fa-spinner fa-spin" style="font-size:24px"></i></span>
            </div>
        </div>
        <div class="lowerStats">
            <div id="statisticheAnnuali" class="minisezione active"><span>Annuale</span></div>
            <div id="statisticheSettimanali" class="minisezione"><span>Settimanale</span></div>
            <div id="statisticheMensili" class="minisezione"><span>Mensile</span></div>
        </div>

        <div id="statsContainer">
            <div id="statisticheAnnualiDiv" class="statsImages selected">
              <a href="/api/img/mese2.png" data-lightbox="statsAnnuali"><img src="/api/img/mese2.png"/></a>
              <a href="/api/img/mese3.png" data-lightbox="statsAnnuali"><img src="/api/img/mese3.png"/></a>
              <a href="/api/img/settimana13.png" data-lightbox="statsAnnuali"><img src="/api/img/settimana13.png"/></a>
              <a href="/api/img/settimana14.png" data-lightbox="statsAnnuali"><img src="/api/img/settimana14.png"/></a>
            </div>

            <div id="statisticheMensiliDiv" class="statsImages" style="display:none;">
              <a href="/api/img/settimana14.png" data-lightbox="statsMensili"><img src="/api/img/settimana14.png"/></a>
              <a href="/api/img/mese2.png" data-lightbox="statsMensili"><img src="/api/img/mese2.png"/></a>
              <a href="/api/img/settimana13.png" data-lightbox="statsMensili"><img src="/api/img/settimana13.png"/></a>
              <a href="/api/img/mese3.png" data-lightbox="statsMensili"><img src="/api/img/mese3.png"/></a>
            </div>

            <div id="statisticheSettimanaliDiv" class="statsImages" style="display:none;">
              <a href="/api/img/settimana13.png" data-lightbox="statsSettimanali"><img src="/api/img/settimana13.png"/></a>
              <a href="/api/img/settimana14.png" data-lightbox="statsSettimanali"><img src="/api/img/settimana14.png"/></a>
              <a href="/api/img/settimana15.png" data-lightbox="statsSettimanali"><img src="/api/img/settimana15.png"/></a>
              <a href="/api/img/mese3.png" data-lightbox="statsSettimanali"><img src="/api/img/mese3.png"/></a>
            </div>
        </div>



    </div>

    <div id="sezioneOrdiniDiv" class="divGestionale">
        <div class="upperStats">
            <div class="scrittaStats">
                <span><b>Magazzino :</b></span>
            </div>
            <div class="nomeMagazzinoStats">
                <span class="magazzinoSelezionato">Loading&nbsp;<i class="fa fa-spinner fa-spin" style="font-size:24px"></i></span>
            </div>
        </div>

        <div id='tableOrdini' class="table">
                <div id='ColonneOrdini' class='ordine'>
                    <div id='idOrdine'><b>ID</b></div>
                    <div id='tipoPagamentoOrdine'><b>Tipo</b></div>
                    <div id='indirizzoOrdine' title="Indirizzo"><b>Indirizzo</b></div>
                    <div id='datiAnagraficiOrdine' title="Richiedente"><b>Utente</b></div>
                    <div id='subtotaleOrdine' title="Subtotale"><b>SubT</b></div>
                    <div id='spese_spedizioneOrdine' title="Costo Spedizione"><b>Sped</b></div>
                    <div id='totaleOrdine' title="Spesa Totale"><b>Tot</b></div>
                    <div id='dataRichiestaOrdine' title="Data Richiesta"><b>D.R</b></div>
                    <div id='dataConsegnaOrdine' title="Data Consegna"><b>D.C</b></div>
                </div>
                <div class='lineaDiSeparazione'></div>
                <div id='ElencoOrdini' class="elenco">
                </div>
            </div>
    </div>

    <div id="sezioneProdottiRicevutiDiv" class="divGestionale">
        <div class="upperStats">
            <div class="scrittaStats">
                <span><b>Magazzino :</b></span>
            </div>
            <div class="nomeMagazzinoStats">
                <span class="magazzinoSelezionato">Loading&nbsp;<i class="fa fa-spinner fa-spin" style="font-size:24px"></i></span>
            </div>
        </div>

        <div id='tableProdottiRicevuti' class="table">
                <div id='ColonneProdottiRicevuti' class='prodottoRicVen'>
                    <div id='idProdottoRicevuti'><b>ID</b></div>
                    <div id='nomeProdottoRicevuti'><b>Nome</b></div>
                    <div id='nomeProdottoRicevuti'><b>Categoria</b></div>
                    <div id='descrizioneProdottoRicevuti'><b>Descrizione</b></div>
                    <div id='infoProdottoRicevuti'><b>Info</b></div>
                    <div id='quantitaProdottoRicevuti' title="Quantita'"><b>Quantita</b></div>
                    <div id='dataProdottoRicevuti'><b>Data</b></div>
                </div>

                <div class='lineaDiSeparazione'></div>
                <div id='ElencoProdottiRicevuti' class="elenco">
                </div>
        </div>
    </div>

    <div id="sezioneProdottiVendutiDiv" class="divGestionale">
         <div class="upperStats">
            <div class="scrittaStats">
                <span><b>Magazzino :</b></span>
            </div>
            <div class="nomeMagazzinoStats">
                <span class="magazzinoSelezionato">Loading&nbsp;<i class="fa fa-spinner fa-spin" style="font-size:24px"></i></span>
            </div>
        </div>

        <div id='tableProdottiVenduti' class="table">
                <div id='ColonneProdottiVenduti' class='prodottoRicVen'>
                    <div id='idProdottoVenduti'><b>ID</b></div>
                    <div id='nomeProdottoVenduti'><b>Nome</b></div>
                    <div id='nomeProdottoVenduti'><b>Categoria</b></div>
                    <div id='descrizioneProdottoVenduti'><b>Descrizione</b></div>
                    <div id='infoProdottoVenduti'><b>Info</b></div>
                    <div id='quantitaProdottoVenduti' title="Quantita'"><b>Quantita</b></div>
                    <div id='dataProdottoVenduti'><b>Data</b></div>
                </div>
                <div class='lineaDiSeparazione'></div>
                <div id='ElencoProdottiVenduti' class="elenco">
                </div>
            </div>
    </div>




    <div id="sezioneMagazziniDiv" class="divGestionale">
        <div class="upper">
            <div class="scritta">
                <span><b>Magazzini</b></span>
            </div>
            <div class="aggiungi">
                <span><button type="button" id="addMagazzinoButton"><i class="fas fa-plus"></i>&nbsp;Aggiungi&nbsp;un&nbsp;magazzino&nbsp;<i class="fas fa-plus"></i></button></span>
            </div>
            <div class="scrittaMagazzino">
                <b>Magazzino:</b>
            </div>
            <div id="selezionaMagazzino" class="nomeMagazzino">
                <span class="magazzinoSelezionato">Loading&nbsp;<i class="fa fa-spinner fa-spin" style="font-size:24px"></i></span>
                <span id="idMagazzino"></span>
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

                <div id='ElencoMagazzini' class="elenco">
                </div>
            </div>

        </div>

        <div id="addMagazzinoDiv">
            <span id="addMagazzinoExitButton">&nbsp;X&nbsp;</span>
            <div class="insertTitle"><h1>Inserisci nuovo magazzino</h1></div>
            <form id="addMagazzinoDivForm" method="POST" action="/upload/uploadMagazzino" enctype="multipart/form-data">
                <div><label>Citta :</label><input type="text" name="citta" id="nomeCitta" placeholder="Roma" class=autoload_comune></input><input type="hidden" name="hiddenCitta" class="autoload_comune_id"></div>

                <div><label>CAP :</label><input type="text" name="cap" id="cap" placeholder="64100"></div>
                <div><label>Provincia :</label><input type="text" name="provincia" id="provincia" placeholder="RM"></div>
                <div><label>Via :</label><input type="text" name="via" placeholder="Via Giuseppe Verdi"></div>
                <div><label>Civico :</label><input type="text" name="civico" placeholder="127"></div>
                <button type="submit">INSERT</button>
            </form>
        </div>
    </div>



    <div id="sezioneProdottiDiv" class="divGestionale">
        <div class="upper">
            <div class="scritta">
                <span><b>Prodotti</b></span>
            </div>
            <div class="aggiungi">
                <button type="button" id="addProductButton" class="pointer"><i class="fas fa-plus"></i>&nbsp;Aggiungi&nbsp;Prodotto&nbsp;<i class="fas fa-plus"></i></button>
                <button type="button" id="addCategoriaButton" class="pointer"><i class="fas fa-plus"></i>&nbsp;Aggiungi&nbsp;Categoria&nbsp;<i class="fas fa-plus"></i></button>
            </div>
            <div class="scrittaMagazzino">
                <b>Magazzino:</b>
            </div>
            <div class="nomeMagazzino">
                <span class="magazzinoSelezionato">Loading&nbsp;<i class="fa fa-spinner fa-spin" style="font-size:24px"></i></span>
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
                                <option value="">Tutte</option>
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
                <div id='ElencoProdotti' class="elenco">
                </div>
            </div>

        </div>


      <div id="addProductDiv">
        <span id="addProductExitButton">&nbsp;X&nbsp;</span>
        <div class="insertTitle"><h1>Inserisci nuovo prodotto</h1></div>

      <form id="inserisciProdottoForm" method="POST" action="/upload/uploadProduct" enctype="multipart/form-data">
            <div>
                <label>Default Image :</label><input type="file" name="favoriteImage" id="aggiungiProdotti-favoriteImage">
                <div id="image-base64"></div>
            </div>
            <div>
                <label>Other Images :</label><input type="file" name="otherImages[]" id="aggiungiProdotti-otherImages" multiple>
                <div id="image-base64"></div>
            </div>
            <div><label>Nome :</label><input type="text" name="nome" id="nomeProdotto"></div>
            <div><label>Descrizione :</label><textarea cols="40" rows="3" name="descrizione" placeholder="Describe the product"></textarea></div>
            <div><label>Info :</label><textarea cols="40" rows="3" name="info" placeholder="Info about the product"></textarea></div>
            <div><label>Categoria :</label> <select id='aggiungiProdotti-categoria' name="categoria"></select></div>
            <div><label>Price :</label><input type="text" name="prezzo"></div>
            <div><label>Valuta :</label><select id='aggiungiProdotti-valuta' name="valuta"></select></div>
            <div><label>Quantita :</label><input type="text" name="quantita"></div>
            <div><label>Magazzino :</label><select class='listaNomiMagazzini' name="magazzino"></select></div>
            <button type="submit">INSERT</button>
      </form>
            <div id="addProductMessage"></div>
    </div>

    <div id="addCategoriaDiv">
    <span id="addCategoriaExitButton">&nbsp;X&nbsp;</span>
    <div class="insertTitle"><h1>Aggiungi nuova categoria</h1></div>
      <form id="inserisciCategoriaForm" method="POST" action="/upload/uploadCategory" enctype="multipart/form-data">
            <div><label>Nome Categoria</label><input type="text" name="categoria"></div>
            <div><label>Nome Padre</label><input type="text" name="padre"></div>
            <button type="submit">INSERT</button>
      </form>
    </div>

    </div>







    <div id="sezioneDipendentiDiv" class="divGestionale">
        <div class="upper">
            <div class="scritta">
                <span><b>Dipendenti</b></span>
            </div>
            <div class="aggiungi">
                <button type="button" id="addEmployeeButton" class="pointer"><i class="fas fa-plus"></i>&nbsp;Aggiungi&nbsp;Dipendente&nbsp;<i class="fas fa-plus"></i></button>
            </div>
            <div class="scrittaMagazzino">
                <b>Magazzino:</b>
            </div>
            <div class="nomeMagazzino">
                <span class="magazzinoSelezionato">Loading&nbsp;<i class="fa fa-spinner fa-spin" style="font-size:24px"></i></span>
            </div>
        </div>



        <div id="dipendentiFiltro">
            <div id="DipendentiFiltroNome">
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Nome:&nbsp;<input id="inputDipendentiFiltroNome" type="text">
            </div>

            <div id="DipendentiFiltroRuolo">
                Ruolo:  <select class='ruoliDipendenti' id="inputDipendentiFiltroRuolo">
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

                <div id='ElencoDipendenti' class="elenco">
                </div>
            </div>
            </div>



        <div id="addEmployeeDiv">
            <span id="addEmployeeExitButton">&nbsp;X&nbsp;</span>
            <div class="insertTitle"><h1>Inserisci nuovo Dipendente</h1></div>
            <form id="addEmployeeDivForm" method="POST" action="/upload/uploadDipendente" enctype="multipart/form-data">

                <div><label>Nome :</label><input type="text" name="nome" placeholder="Nome" id="nomeDipendente"></div>
                <div><label>Cognome :</label><input type="text" name="cognome" placeholder="Cognome" id="cognomeDipendente"></textarea></div>
                <div><label>Email :</label><input type="text" name="email" placeholder="example@yahoo.com" id="emailDipendente" autocomplete="off"></textarea></div>
                <div><label>Username :</label><input type="text" name="username" placeholder="Username" id="usernameDipendente" autocomplete="off"></textarea></div>
                <div><label>Password :</label><input type="password" name="password" placeholder="**********" id="passwordDipendente" autocomplete="off"></textarea></div>
                <div><label>Ruolo :</label><select name="ruoloDipendente" class="ruoliDipendenti"></select></div>
                <div><label>Contratto :</label><select name="contrattoDipendente" class="selectContrattoDipendente" ></select></div>
                <div><label>Stipendio :</label><input name="stipendioOrario" type="text"  placeholder="€ / ORA"></div>
                <div><label>Magazzino :</label><select name="magazzino" class='listaNomiMagazzini'></select></div>
                <button type="submit">INSERT</button>
            </form>
        </div>
    </div>

    <div id="sezioneGestoriDiv" class="divGestionale">
        <div class="upper">
            <div class="scritta">
                <span><b>Gestori</b></span>
            </div>
            <div class="aggiungi">
                <button type="button" id="addGestoreButton" class="pointer"><i class="fas fa-plus"></i>&nbsp;Aggiungi&nbsp;Gestori&nbsp;<i class="fas fa-plus"></i></button>
            </div>
            <div class="scrittaMagazzino">
                <b>Magazzino:</b>
            </div>
            <div class="nomeMagazzino">
                <span >Tutti i magazzini</span>
            </div>
        </div>



            <div id="GestoriLower">
            <div id='tableGestori' class="table">
                <div id='ColonneGestori' class='gestore'>
                    <div id='idGestore'><b>ID</b></div>
                    <div id='nomeGestore'><b>Nome</b></div>
                    <div id='cognomeGestore'><b>Cognome</b></div>
                    <div id='telGestore'><b>Tel</b></div>
                    <div id='emailGestore'><b>Email</b></div>
                    <div id='stipendioOrarioGestore'><b>€/ora</b></div>
                    <div id='magazzinoGestore'><b>Mag</b></div>
                    <div id='modificaGestore'><i class="far fa-edit"></i></div>
                    <div id='cancellaGestore'><i class="fas fa-trash-alt"></i></div>
                </div>

                <div class='lineaDiSeparazione'></div>

                <div id='ElencoGestori' class="elenco">
                </div>
            </div>
            </div>



        <div id="addGestoreDiv">
            <span id="addGestoreExitButton">&nbsp;X&nbsp;</span>
            <div class="insertTitle"><h1>Inserisci nuovo Gestore</h1></div>
            <form id="addGestoreDivForm" method="POST" action="/upload/uploadGestore" enctype="multipart/form-data">

                <div><label>Nome :</label><input type="text" name="nome" placeholder="Nome" id="nomeGestore" autocomplete="off"></div>
                <div><label>Cognome :</label><input type="text" name="cognome" placeholder="Cognome" id="cognomeGestore" autocomplete="off"></textarea></div>
                <div><label>Email :</label><input type="text" name="email" placeholder="example@yahoo.com" id="emailGestore" autocomplete="off"></textarea></div>
                <div><label>Username :</label><input type="text" name="username" placeholder="Username" id="usernameGestore" autocomplete="off"></textarea></div>
                <div><label>Password :</label><input type="password" name="password" placeholder="**********" id="passwordGestore" autocomplete="off"></textarea></div>
                <div><label>Contratto :</label><select name="contrattoDipendente" class="selectContrattoDipendente" ></select></div>
                <div><label>Stipendio :</label><input name="stipendioOrario" type="text"  placeholder="€ / ORA" autocomplete="off"></div>
                <div><label>Magazzino :</label><select name="magazzino" class='listaNomiMagazzini'></select></div>
                <button type="submit">INSERT</button>
            </form>
        </div>
    </div>


    <div id="sezioneProfiloDiv" class="divGestionale">
        <div id="ProfiloDiv">
            <div><button>Cambia Password</button></div>
        </div>
     </div>

    <div id="sezioneSitoWebDiv" class="divGestionale">
        <div id="SitoWebDiv">
            <div><button>Cambia sfondo del Website</button></div>
            <div><button>Cambia Colore Tema</button></div>
            <div><button>Cambia Nome Website</button></div>
        </div>
     </div>



</div>
</div>
