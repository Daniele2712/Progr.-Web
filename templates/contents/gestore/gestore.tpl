{* Smarty *}
<div id="gestoreContent">
        
    
    <div id="categories">
                <div class="categoryclass" id="inserisciProdotto">Inserisci prodotto</div>
                <div class="categoryclass" id="updateProdotto"> Update Prodotto</div>
                <div class="categoryclass" id="inserisciCategoria">Inserisci Categoria</div>
                <div class="categoryclass" id="updateOfferte">Update Offerte</div>
    </div>
        
    <div id="action">
    <div id='inserisciProdottoDiv'>
          <h1>Inserisci nuovo prodotto</h1>
          
          <form id="insertImage" method="POST" action="/upload/uploadProduct" enctype="multipart/form-data">

                <div><label>Image</label><input type="file" name="image"></div>
                <div><label>Nome</label><input type="text" name="nome" id="nomeProdotto"></div>
                <div><label>Descrizione</label><textarea cols="40" rows="4" name="descrizione" placeholder="Describe the product"></textarea></div>
                <div><label>Info</label><textarea cols="40" rows="4" name="info" placeholder="Info about the product"></textarea></div>
                <div><label>Categoria</label><input type="text" name="categoria"></div>
                <div><label>Price</label><input type="text" name="prezzo"></div>
                <div><label>Valuta</label><input type="text" name="valuta"></div>
                <div><label>Quantita</label><input type="text" name="quantita"></div>
                <button type="submit">INSERT</button>
          </form>


          {*    Seguiranno anche tante altro form che permettono al gestore di fare tutte le cose che vuole*}    
    </div>
    
    <div id='updateProdottoDiv'>
          <h1>UPDATEEEEE Product</h1>
          
    </div>
    
    <div id='inserisciCategoriaDiv'>
        <h1>Aggiungi nuova categoria</h1>
          <form id="categoryForm" method="POST" action="/upload/uploadCategory" enctype="multipart/form-data">
                <div><label>Nome Categoria</label><input type="text" name="categoria"></div>
                <div><label>Nome Padre</label><input type="text" name="padre"></div>
                <button type="submit">INSERT</button>
          </form>
    </div>
    
    <div id='updateOfferteDiv'>
          <h1>UPDATEEEE OFEERTRAAAADSA </h1>
    </div>
    
    </div>
  
</div>
