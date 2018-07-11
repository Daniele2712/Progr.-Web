{* Smarty *}
<div id="gestoreContent">

<div id='insertProduct'>
    {*   ITEMS:  	descrizione	id	id_categoria	info	 nome	prezzo	quantita	valuta    *}
  <form class="insertImage" method="POST" action="/upload/uploadProduct" enctype="multipart/form-data">
  	
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
  
  
</div>
