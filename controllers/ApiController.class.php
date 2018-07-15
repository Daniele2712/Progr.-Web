<?php
namespace Controllers;
use \Views\Request as Request;

class ApiController{
    
    /*          API URLs
        GET
    /api/   ├── indirizzi                                   mostra indirizzi e ID di tutti i magazzini
            ├── categorie                                   mostra tutte le categorie
            ├── magazzini/  ├──                             mostra tutti gli item di tutti i magazzini
                            ├── id/$int ├──                 mosstra tutti gli item del magazzino con ID $int
                                        ├──categoria/$cat   mostra tutti gli item del magazzino con ID $int aventi categoria $cat
                            ├── categoria/$cat              mostra tutti gli item di tuti i magazzini con categoria $cat      
     
      
     
        DELETE
    /api/   ├── indirizzo/$id                               si puo cancellare soltanto se non e associato a nessun magazzino    
            ├── categoria/$str                              cancella la categoria CHE SI CHIAMA $str     
            ├── magazzin0/$id                               Si puo cancellare soltanto se il magazzino e vuoto                              
            ├── prodotto/$id                                cancella il prodotto CON ID $id
                                            
                                      
     
      
     */
    public function get($params){
        
        /*      Magari metti i metodi x vedere se esistono le categorie e i magazzini richiesti     */
        $params=$params->getOtherParams();
                   
        {switch (array_shift($params)){
    case 'magazzini':
        if(sizeof($params)==0 or $params[0]=='' ) $this->showAll();     
        else
            {
            $ok=TRUE;   // se l-utente sbaglia a scrivere salto molti controlli
            if(in_array("id", $params) && $ok)
                {
                $indexId=array_search('id', $params);
                    if(isset($params[$indexId+1])){$id_magazzino=$params[$indexId+1];}
                    else {$ok=FALSE; echo "Expected index number after .../id/";}
                };
                
            if(in_array("categoria", $params) && $ok)
                {
                $indexCategora=array_search('categoria', $params);
                    if(isset($params[$indexCategora+1])){$categoria_magazzino=$params[$indexCategora+1];}
                    else {$ok=FALSE; echo "Expected categora name after .../categora/";}
                };
                if($ok) {
                    if(!isset($id_magazzino)) $id_magazzino=NULL;
                    if(!isset($categoria_magazzino)) $categoria_magazzino=NULL;
                    $this->showProdotti($id_magazzino, $categoria_magazzino);}
            }
        
        break;
    
    case 'indirizzi':
        if(sizeof($params)==0 or $params[0]=='' )     $this->showIndirizzi();
        else echo "NO parameters were expected. The URL must end in .../indirizzi";
        break;
    
    
    case 'categorie':
        if(sizeof($params)==0 or $params[0]=='' )     $this->showCategorie();
         else echo "NO parameters were expected. The URL must end in .../categorie";
        break;
    default:
        echo"URL errato";
        break;
    }
        
    }       /*      SERVE LA PARENTESI GRAFFA   CHE CIRCONDA LO SWITCH???       */
    }
    
    
    public function delete($params){
        /*  MAGARI aggiungere anche cancellare la foto dle prodotto e il collegamento, non solo il prodotto*/
    
        /*      Magari metti i metodi x vedere se esistono le categorie e i magazzini richiesti     */
        $params=$params->getOtherParams();
        if(sizeof($params)<2) echo  "ERROR Not enought parameters Expected 2 parameters";
        elseif(sizeof($params)>2)   echo  "ERROR Too many parameters. Expected 2 parameters";
        else{
            
        switch (array_shift($params)){
    case 'prodotto':
        if($this->existsProdotto($params[0]))
        {
            if($this->prodottoNonNelCarrello($params[0])) $this->deleteProdotto($params[0]);
            else echo "Cannot delete product with id $params[0] becaust it is inside a basket."; 
        }
        else echo "Product with id $params[0] does not exist.";
        break;
    
    case 'indirizzi':
        if($this->existsIndirizzo($params[0])) $this->deleteIndirizzo($params[0]);
        else echo "Indirizzo with id $params[0] does not exist.";
        break;
    
    
    case 'magazzino':
        if($this->existsMagazzino($params[0])) 
        {
            if($this->isEmptyMagazzino($params[0]))$this->deleteMagazzino($params[0]);
            else echo "Magazzino is not empty. Empty it first, then try again.";
        }
        else echo "Magazzino with id $params[0] does not exist.";
        break;
        
    case 'categoria':   /*  L-imput di categoria dovrebbe essere una stringa*/
        if($this->existsCategoria($params[0])) 
        {
            $this->deleteCategory($params[0]);
        }
        else echo "Category with id $params[0] does not exist.";
        break;
        
        
    default:
        echo"ERROR Wrong URL";
        break;
    }
    }
    
        }
    
    
    
    
    
    
    
    
    /*      FUNCTIONS FOR DELETE       */
    private function existsProdotto($id){
        $dbResponse=\Singleton::DB()->query("SELECT COUNT(*) as num FROM `prodotti` WHERE prodotti.id=$id;");
                    while($r = mysqli_fetch_assoc($dbResponse)) {$rows[] = $r; }
                    if($rows[0]['num']==1) return TRUE;
                    else return FALSE;
    }
    
    private function prodottoNonNelCarrello($id){
        $dbResponse=\Singleton::DB()->query("SELECT COUNT(*) as num FROM `items_carrello` WHERE items_carrello.id_prodotto=$id;");
                    while($r = mysqli_fetch_assoc($dbResponse)) {$rows[] = $r; }
                    if($rows[0]['num']==0) return TRUE;
                    else return FALSE;
    }
    
    private function deleteProdotto($id){
        $tuttoOK=TRUE;
        /*      Deleting product    */
        if(\Singleton::DB()->query("DELETE FROM prodotti WHERE prodotti.id=$id;")) echo "SUCCESS - Product with id $id DELETED";
        else {$tuttoOK=FALSE;echo "ERROR deleting product with id $id";}
        
        
        
        
        /*          PROVO QUESTE COSE PER FARE IL DEBUG MA NON FUNZIONA     */
        /*  Se metto a mano la stringa SELECT id_immagine FROM `immagini_prodotti` WHERE id_prodotto=$id mi rida il risultato giusto, ma se lo fa php NON FUNZIONA, mi rida un array vuoto*/
        $dbResponse=\Singleton::DB()->query("SELECT id_immagine FROM `immagini_prodotti` WHERE id_prodotto=$id;");
                    while($r = mysqli_fetch_assoc($dbResponse)) {$rows[] = $r; }
                    echo var_dump($dbResponse);
                    echo var_dump($rows);
                    if(isset($rows[0]['id_immagine'])) echo $idImmage=$rows[0]['id_immagine'];
                    else echo "NON E SETTATOOOO!";
       return; 
        /*      FINE DEBUG        */ 
     
       
       
       
       
       /*      Deleting immage    */       /*    il mio if(querry) non rida sempre vero in caso sia andato tutto bene... anzi, rida TURUE anche quando le righe affettate possono essere 0*/
        if($tuttoOK && \Singleton::DB()->query("DELETE FROM immagini WHERE id IN (SELECT id_immagine FROM `immagini_prodotti` WHERE id_prodotto='$id');")) echo "SUCCESS - Image associated with product $id DELETED";
        else {$tuttoOK=FALSE; echo "ERROR deleting immage associated with product $id";}
        
        /*      Deleting link immage-product inside immagini_prodotti    */
        if($tuttoOK && \Singleton::DB()->query("DELETE FROM immagini_prodotti WHERE immagini_prodotti.id_prodotto=$id;")) echo "SUCCESS - Link immage - product($id) DELETED";
        else {$tuttoOK=FALSE; echo "ERROR deleting link immage - product($id) DELETED";}
        }
    
    private function existsIndirizzo($id){
        $dbResponse=\Singleton::DB()->query("SELECT COUNT(*) as num FROM `indirizzi` WHERE indirizzi.id=$id;");
                    while($r = mysqli_fetch_assoc($dbResponse)) {$rows[] = $r; }
                    if($rows[0]['num']==1) return TRUE;
                    else return FALSE;
    }
    
    private function deleteIndirizzo($id){
        if(\Singleton::DB()->query("DELETE FROM indirizzi WHERE indirizzi.id=$id;")) echo "SUCCESS - indirizzo with id $id DELETED";
        else echo "ERROR deleting indirizzo with id $id";
        
    }
    
    private function existsMagazzino($id){
        $dbResponse=\Singleton::DB()->query("SELECT COUNT(*) as num FROM `magazzini` WHERE magazzini.id=$id;");
                    while($r = mysqli_fetch_assoc($dbResponse)) {$rows[] = $r; }
                    if($rows[0]['num']==1) return TRUE;
                    else return FALSE;
    }
    
     private function isEmptyMagazzino($id){
        $dbResponse=\Singleton::DB()->query("SELECT COUNT(*) as num FROM `items_magazzino` WHERE items_magazzino.id_magazzino=$id;");
        while($r = mysqli_fetch_assoc($dbResponse)) {$rows[] = $r; }
                    if($rows[0]['num']==0) return TRUE;
                    else return FALSE;
    }
     private function deleteMagazzino($id){
        if(\Singleton::DB()->query("DELETE FROM magazzini WHERE magazzini.id=$id;")) echo "SUCCESS - magazzino with id $id DELETED";
        else echo "ERROR deleting magazzino with id $id";
        /*      Non penso devo cancelare qualcos..altro*/
    }
    
    private function existsCategoria($id){
        $dbResponse=\Singleton::DB()->query("SELECT COUNT(*) as num FROM `categorie` WHERE categorie.nome=$id;");
                    while($r = mysqli_fetch_assoc($dbResponse)) {$rows[] = $r; }
                    if($rows[0]['num']==1) return TRUE;
                    else return FALSE;
    }
    
    
    private function deleteCategory($id){
        if(\Singleton::DB()->query("DELETE FROM categorie WHERE categorie.nome=$id;")) echo "SUCCESS - category with id $id DELETED";
        else echo "ERROR deleting magazzino with id $id";
    }
    
    
    /*      END OF FUNCTIONS FOR GET       */
    
    
       
    
    
    
    
    
    
    
    
    /*      FUNCTIONS FOR GET       */
    
    
    private function showIndirizzi(){
                    $Magazzini=\Singleton::DB()->query("SELECT comuni.nome as citta,comuni.provincia as provincia, comuni.CAP as cap, indirizzi.via, indirizzi.civico FROM `magazzini`,comuni,indirizzi WHERE magazzini.id_indirizzo=indirizzi.id AND indirizzi.id_comune=comuni.id;");
                    while($r = mysqli_fetch_assoc($Magazzini)) {$rows[] = $r; }
                    echo json_encode($rows); 
    }
    
    private function showAll(){
                    $items=\Singleton::DB()->query("SELECT prodotti.nome as nome_prodotto,prodotti.info, prodotti.descrizione, categorie.nome as nome_categoria, prodotti.prezzo, prodotti.valuta FROM prodotti,categorie WHERE prodotti.id_categoria=categorie.id;");
                    while($r = mysqli_fetch_assoc($items)) {$rows[] = $r; }
                    echo json_encode($rows);   
                }
                
     private function showProdotti($id_magazzino, $categoria_magazzino){
         if(is_numeric(intval($id_magazzino))) $id_magazzino=intval($id_magazzino);
         if($id_magazzino!=NULL){   /*      MAGAZZINO SETTATO   */
             if($categoria_magazzino!=NULL)
             {      /*      MAGAZZINO E CATEGORIA SETTATI*/
                 $items=\Singleton::DB()->query("SELECT prodotti.nome as nome_prodotto,prodotti.info, prodotti.descrizione, prodotti.prezzo, prodotti.valuta, items_magazzino.quantita FROM prodotti,categorie,items_magazzino WHERE prodotti.id_categoria=categorie.id AND categorie.nome='$categoria_magazzino' AND items_magazzino.id_magazzino=$id_magazzino AND prodotti.id=items_magazzino.id_prodotto;");
                    while($r = mysqli_fetch_assoc($items)) {$rows[] = $r; }
                    if(isset($rows)) echo json_encode($rows);
                    else echo "Nessun risultato";
                    
             }
             else{  /*      MAGAZZINO SETTATA E CATEGORIA NULL*/
                    $items=\Singleton::DB()->query("SELECT prodotti.nome as nome_prodotto,prodotti.info, prodotti.descrizione, categorie.nome as categoria, prodotti.prezzo, prodotti.valuta, items_magazzino.quantita FROM prodotti,categorie,items_magazzino WHERE items_magazzino.id_magazzino=$id_magazzino AND items_magazzino.id_prodotto=prodotti.id AND categorie.id=prodotti.id_categoria;");
                    while($r = mysqli_fetch_assoc($items)) {$rows[] = $r; }
                     if(isset($rows)) echo json_encode($rows);
                    else echo "Nessun risultato";
             }
             
         }
         else{      /*      MAGAZZINO NON SETTATO       */
                if($categoria_magazzino!=NULL)
                {      /*      MAGAZZINO NON SETTATO E CATEGORIA SETTATI*/
                    $items=\Singleton::DB()->query("SELECT prodotti.nome as nome_prodotto,prodotti.info, prodotti.descrizione, prodotti.prezzo, prodotti.valuta, items_magazzino.quantita, items_magazzino.id_magazzino FROM prodotti,categorie,items_magazzino WHERE prodotti.id_categoria=categorie.id AND categorie.nome='$categoria_magazzino';");
                       while($r = mysqli_fetch_assoc($items)) {$rows[] = $r; }
                       if(isset($rows)) echo json_encode($rows);
                       else echo "Nessun risultato";

                }
                else{  /*      NIENTE SETTATO       */
                       
                       echo "URL SBAGLIATO";
                }
                }
            }
    
    private function showCategorie(){
        $categorie=\Singleton::DB()->query("SELECT categorie.nome FROM categorie;");
        while($r = mysqli_fetch_assoc($categorie)) {$rows[] = $r; }
        if(isset($rows)) echo json_encode($rows);
        else echo "Non ci sono categorie";
    }
/*          END FUNCTIONS FOR GET       */
}








?>