<?php
namespace Controllers;
use \Views\Request as Request;

class ApiController{
    
    /*          API URLs

    /api/   ├── indirizzi                                   mostra indirizzi e ID di tutti i magazzini
            ├── categorie                                   mostra tutte le categorie
            ├── magazzini/  ├──                             mostra tutti gli item di tutti i magazzini
                            ├── id/$int ├──                 mosstra tutti gli item del magazzino con ID $int
                                        ├──categoria/$cat   mostra tutti gli item del magazzino con ID $int aventi categoria $cat
                            ├── categoria/$cat              mostra tutti gli item di tuti i magazzini con categoria $cat      
     
      
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

}








?>