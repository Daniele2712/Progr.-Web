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
            ├── magazzini/$id                               Si puo cancellare soltanto se il magazzino e vuoto                              
            ├── prodotto/$id                                cancella il prodotto CON ID $id
                                            
        POST
    /api/   ├── indirizzo                                   si puo cancellare soltanto se non e associato a nessun magazzino    
            ├── categoria                                   cancella la categoria CHE SI CHIAMA $str     
            ├── magazzin                                    Si puo cancellare soltanto se il magazzino e vuoto                              
            ├── prodotto                                    cancella il prodotto CON ID $id           
     
            OPTIONS
     /ANY URL
     */
    public function get($params){
        
        header('Content-type: application/json');
        
        /*      Magari metti i metodi x vedere se esistono le categorie e i magazzini richiesti     */
        $params=$params->getOtherParams();
                   
        switch (array_shift($params)){
    case 'magazzini':
        if(sizeof($params)==0 or $params[0]=='' ) $this->showAll();     
        else
            {
            $ok=TRUE;   // se l-utente sbaglia a scrivere salto molti controlli
            if(in_array("id", $params) && $ok)
                {
                $indexId=array_search('id', $params);
                    if(isset($params[$indexId+1])){$id_magazzino=$params[$indexId+1];}
                    else {$ok=FALSE; $this->setError("expected_index");}
                };
                
            if(in_array("categoria", $params) && $ok)
                {
                $indexCategoria=array_search('categoria', $params);
                    if(isset($params[$indexCategoria+1])){if($this->existsCategoria($params[$indexCategoria+1], 'any')) {$categoria_magazzino=$params[$indexCategoria+1];}
                                                          else {$ok=FALSE; $this->setError("categoria_not_exists",$params[$indexCategoria+1]);}
                    }
                    else {$ok=FALSE; $this->setError("expected_categoria");}
                };
                if($ok) {
                    if(!isset($id_magazzino)) $id_magazzino=NULL;
                    if(!isset($categoria_magazzino)) $categoria_magazzino=NULL;
                    if($ok) $this->showProdotti($id_magazzino, $categoria_magazzino);}
                    
            }
        
        break;
    
    case 'indirizzi':
        if(sizeof($params)==0 or $params[0]=='' )     $this->showIndirizzi();
        else $this->setError("no_parameters_after_indirizzi");
        break;
    
    
    case 'categorie':
        if(sizeof($params)==0 or $params[0]=='' )     $this->showCategorie();
         else $this->setError("no_parameters_after_categorie");
         break;
    default:
        $this->setError("wrong_url");
        break;
    }
        
   
    }
    
    
    public function delete($params){
        
        header('Content-type: application/json');
        /*  MAGARI aggiungere anche cancellare la foto dle prodotto e il collegamento, non solo il prodotto*/
    
        /*      Magari metti i metodi x vedere se esistono le categorie e i magazzini richiesti     */
        $params=$params->getOtherParams();
        if(sizeof($params)<2) $this->setError("delete_more_params");
        elseif(sizeof($params)>2)   $this->setError("delete_less_params");
        elseif($params[1]=="") $this->setError("delete_more_params");   
        else{
            
            switch (array_shift($params)){
        case 'prodotto':
            if($this->existsProdotto($params[0]))
            {
                if($this->prodottoNonNelCarrello($params[0])) $this->deleteProdotto($params[0]);
                else $this->setError("is_inside_basket",$params[0]);
            }
            else $this->setError("prodotto_not_exists",$params[0]);
            break;

        case 'indirizzo':
            if($this->indirizzo_is_binded_to_magazzino($params[0])) $this->setError("indirizzo_binded",$params[0]);
            elseif($this->existsIndirizzo($params[0])) $this->deleteIndirizzo($params[0]);
            else $this->setError("indirizzo_not_exists",$params[0]);    /*  OPPURE PUO ESSEER CHE NON HA FUNZIONATO XKE ESISTE UN AMGAZZINO CHE HA UN INDIRIZZO COME IL MIO E ON DELETE RESTRICT!*/
            break;


        case 'magazzino':
            if($this->existsMagazzino($params[0])) 
            {
                if($this->isEmptyMagazzino($params[0]))$this->deleteMagazzino($params[0]);
                else $this->setError("magazzino_not_empty",$params[0]);
            }
            else $this->setError("magazzino_not_exists",$params[0]);
            break;

        case 'categoria':   /*  L-imput di categoria dovrebbe essere una stringa*/
            if($this->existsCategoria($params[0],'any')) 
            {
                $this->deleteCategory($params[0]);
            }
            else $this->setError("categoria_not_exists",$params[0]);
            break;


        default:
            $this->setError("wrong_url");
            break;
        }
    }
    
    }
        
    public function post($params){
        
        header('Content-type: application/json');
        $params=$params->getOtherParams();
        if(sizeof($params)!=1) $this->setError("only_one_parameter");
        else{
            
            
        switch (array_shift($params)){
    case 'prodotto':
        $rawData = file_get_contents("php://input");
        //echo var_dump($rawData)."</br>";
        $rawData =  json_decode($rawData, TRUE);
        //echo var_dump($rawData);
        if(isset($rawData['nome']) && isset($rawData['info']) && isset($rawData['descrizione']) && isset($rawData['prezzo']) && isset($rawData['valuta']))
        {
            $ok=TRUE;
            $nom=$rawData['nome'];
            $inf=$rawData['info'];
            $des=$rawData['descrizione'];
            if($rawData['id_categoria']=="NULL") $cat=NULL;
            else {
                if($this->existsIdCategoria($rawData['id_categoria'])) $cat= $rawData['id_categoria'];
                else {$this->setError('id_categoria_not_exists',$rawData['id_categoria']);$ok=FALSE;}
            }
            if(is_numeric($rawData['prezzo'])) $pre=floatval($rawData['prezzo']);
            else {$this->setError('is_not_float',$rawData['prezzo']);$ok=FALSE;}
            if($this->isValut($rawData['valuta'])) $val=$rawData['valuta'];
            else {$this->setError('is_not_valut',$rawData['prezzo']);$ok=FALSE;}
            
            if($ok)
                {
                if(\Singleton::DB()->query("INSERT INTO `prodotti` (`id`, `nome`, `info`, `descrizione`, `id_categoria`, `prezzo`, `valuta`) VALUES (NULL, '$nom', '$inf', '$des', $cat, $pre, '$val');")) $this->setSuccess("created");
                else $this->setError("sql");
                }
            else{echo "something went wrong!";}
        }
            else $this->setError("fill_fields");
        break;
    
    case 'indirizzo':
        $rawData = file_get_contents("php://input");
        //echo var_dump($rawData)."</br>";
        $rawData =  json_decode($rawData, TRUE);
        //echo var_dump($rawData);
        if(isset($rawData['citta']) && isset($rawData['provincia']) && isset($rawData['cap']) && isset($rawData['via']) && isset($rawData['civico']))
        {
            $ok=TRUE;
            $cit=$rawData['citta'];
            if(strlen($rawData['provincia'])>2) {$this->setError('provincia_lunga',$rawData['provincia']);$ok=FALSE;}
            else $pro=$rawData['provincia'];
            $cap=intval($rawData['cap']);
            $via=$rawData['via'];
            $civ=intval($rawData['civico']);
            if(isset($rawData['note'])) $not= "'".$rawData['note']."'";
            else $not=NULL;
            
            if($ok){  
              if(\Singleton::DB()->query("INSERT INTO `comuni` (`id`, `CAP`, `nome`, `provincia`) VALUES (NULL, '$cap', '$cit', '$pro');"))
              {
               $lastId=\Singleton::DB()->lastId();
              if(\Singleton::DB()->query("INSERT INTO `indirizzi` (`id`, `id_comune`, `via`, `civico`, `note`) VALUES (NULL, '$lastId', '$via', '$civ', $not);")) $this->setSuccess("created");
              else $this->setError("sql");
              }
              else $this->setError("sql");
            }
        }
            else $this->setError("fill_fields");
        
        break;
    
    
    case 'magazzino':
        $rawData = file_get_contents("php://input");
        //echo var_dump($rawData)."</br>";
        $rawData =  json_decode($rawData, TRUE);
        //echo var_dump($rawData);
        if(isset($rawData['id_gestore']) && isset($rawData['id_indirizzo']))
        {
           
            $ok=TRUE;
            /*  TODO Mi sembra che qui se metti come id_gestore o id_indiirzzo 1abc, lui lo legge come 1 x via della funzione intval */
            if(is_numeric($rawData['id_indirizzo'])) $ind=intval($rawData['id_indirizzo']);
            else {$this->setError('is_not_int',$rawData['id_indirizzo']);$ok=FALSE;}
            if($ok AND is_numeric($rawData['id_gestore'])) $ges=intval($rawData['id_gestore']);
            else {$this->setError('is_not_int',$rawData['id_gestore']); $ok=FALSE;}
           
            if($ok)
            {
            if(!$this->existsGestore($ges)) $this->setError("gestore_inesistente");
            elseif(!$this->existsIndirizzo($ind))  $this->setError("indirizzo_inesistente");
                else{
                        if(\Singleton::DB()->query("INSERT INTO `magazzini` (`id`, `id_gestore`, `id_indirizzo`) VALUES (NULL, '$ges', '$ind');")) $this->setSuccess("created");
                        else $this->setError("sql");
                    }
            }
        }
        
            else $this->setError("fill_fields");
        
        break;
        
    case 'categoria':   
       $rawData = file_get_contents("php://input");
        //echo var_dump($rawData)."</br>";
        $rawData =  json_decode($rawData, TRUE);
        //echo var_dump($rawData);
       
        if(isset($rawData['nome']) && isset($rawData['id_padre']))
        {
            $ok=TRUE;
            $nom=$rawData['nome'];
            if($rawData['id_padre']=="NULL")
            {
                if(\Singleton::DB()->query("INSERT INTO `categorie` (`id`, `nome`, `padre`) VALUES (NULL, '$nom', NULL);")) $this->setSuccess("created");
                else $this->setError("sql");
            }
            elseif($this->existsIdCategoria($rawData['id_padre'])) $pad=$rawData['id_padre'];
            else {$this->setError('id_categoria_not_exists',$rawData['id_padre']); $ok=FALSE;}
            if($ok)
            {
                if($this->existsCategoria($nom, $pad)) $this->setError("categoria_esistente");
                    else{
                            if(\Singleton::DB()->query("INSERT INTO `categorie` (`id`, `nome`, `padre`) VALUES (NULL, '$nom', $pad);")) $this->setSuccess("created");
                            else $this->setError("sql");
                        }

            }
        }
        else $this->setError("fill_fields");
        
        break;
        
        
    default:
        echo"ERROR Wrong URL";
        break;
    }
    }

    }
    
    
    
    public function options($params){
        header('Allow: OPTIONS, GET, DELETE, POST');
        header('Content-type: application/json');
    $answer=
    '{      "OPTIONS": {"description" : "Will always return you this json, no matter the url or the request body"},
            "POST": {
                        "description": "Create creates a categoria, magazzino, indirizzo, prodotto based on the fisrt parameter in thre ULR, after the /api/ .",
                        "URLs":"/api/categoria  OR /api/magazzino  OR /api/indirizzo  OR /api/prodotto",
                        "examples": {
                         "POST to /api/prodotto":
                                    {
                                    "nome": "string",
                                    "info": "string",
                                    "descrizione": "string",
                                    "id_categoria": "int -- [OPTIONAL]",
                                    "prezzo": "flaot",
                                    "valuta": "EUR/USD/GBP/BTC/JPY"
                                    },
                        "POST to /api/magazzino" : 
                                    {
                                    "id_gestore": "string",
                                    "id_indirizzo": "string"
                                   },
                        "POST to /api/indirizzo" :
                                    {
                                    "citta":"string",
                                    "provincia":"string",
                                    "cap":"int",
                                    "via":"string",
                                    "civico":"int",
                                    "note":"string -- [OPTIONAL]"
                                    },
                        "POST to /api/categoria" : 
                                    {
                                    "nome":"string",
                                    "id_padre":"int --[or `NULL`]"
                                    }
                
                                    
                    }
                       },
            
            "GET": {
                        "description": "Get a list of categorie, magazzini, indirizzi or prodotti based on the parameters in thre URL, after the /api/ .",
                        "URLs":"/api/categorie...  OR /api/magazzini...  OR /api/indirizzi...  ",
                        "Rules":"Magazzini ID/CATEGORIA . indirizzi, categorie no param",
                        "examples /api/magazzini": {   "/api/magazzini": "to see all products in all magazzini",
                                                       "/api/magazzini/id/2": "to see all products in magazzino with id 2",
                                                       "/api/magazzini/id/2/categoria/verdura": "to see all products in all magazzino 2 having categoria `verdura`",
                                                       "/api/magazzini/categoria/verdura": "to see all products in all magazzini having categoria `verdura`",
                                                       "/api/indirizzi": "to see indirizzi of all magazzini",
                                                       "/api/categorie": "to see all categorie"
                                                    }
                    },
            
            "DELETE": {
                        "description": "Delete a categoria, magazzino, indirizzo or prodotto based on the fisrt parameter in thre ULR, after the /api/ .",
                        "URLs":"/api/categorie  OR /api/magazzine  OR /api/indirizze  OR /api/prodotte",
                        "examples": {   "/api/magazzino/2": "to delete magazzino with id 2",
                                        "/api/prodotto/14": "to delete prodotto with id 14",
                                        "/api/indirizzo/4": "to delete indirizzo with id 4",
                                        "/api/categoria/verdura": "to delete categoria `verdura`(input must be string) -> items with categoria verdura will have riassigned caregoria to NULL"
                                    }
                      }
                    
    }';
    
    echo $answer;
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
         /*      Deleting immage    */       /*    il mio if(querry) non rida sempre vero in caso sia andato tutto bene... anzi, rida TURUE anche quando le righe affettate possono essere 0*/
        if(\Singleton::DB()->query("DELETE FROM immagini WHERE id IN (SELECT id_immagine FROM `immagini_prodotti` WHERE id_prodotto='$id');"));
        else {$tuttoOK=FALSE; $this->setError("immage",$id);}
        
        /*      Deleting product    */
        if($tuttoOK && \Singleton::DB()->query("DELETE FROM prodotti WHERE prodotti.id=$id;")) {$this->setSuccess("deleted");}
        else {$tuttoOK=FALSE;$this->setError("prod_but_immage_cancelled",$id);}
        }
    
    private function existsIndirizzo($id){
        $dbResponse=\Singleton::DB()->query("SELECT COUNT(*) as num FROM `indirizzi` WHERE indirizzi.id=$id;");
                    while($r = mysqli_fetch_assoc($dbResponse)) {$rows[] = $r; }
                    if($rows[0]['num']==1) return TRUE;
                    else return FALSE;
    }
    
    private function deleteIndirizzo($id){
        if(\Singleton::DB()->query("DELETE FROM indirizzi WHERE indirizzi.id=$id;")) {$this->setSuccess("deleted");}
        else {$this->setError("error_deleting_indirizzo",$id);} /*  TODO questo else non serve a niente, come tutto gli altri che ho fatto...xke a quanto   */
        
    }
    
    private function existsMagazzino($id){
        $dbResponse=\Singleton::DB()->query("SELECT COUNT(*) as num FROM `magazzini` WHERE magazzini.id=$id;");
                    while($r = mysqli_fetch_assoc($dbResponse)) {$rows[] = $r; }
                    if($rows[0]['num']==1) return TRUE;
                    else return FALSE;
    }
    
    private function existsGestore($id){
        $dbResponse=\Singleton::DB()->query("SELECT COUNT(*) as num FROM `gestori` WHERE gestori.id=$id;");
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
        if(\Singleton::DB()->query("DELETE FROM magazzini WHERE magazzini.id=$id;")) {$this->setSuccess("deleted");}
        else {$this->setError("error_deleting_magazzino",$id);}
        /*      Non penso devo cancelare qualcos..altro*/
    }
    
    
    private function existsCategoria($nome, $IDpadre){  /*  Questa funzione puo essere chiamata sia con uno che con 2 parametri...opppure devo per forza specificare il null??? */
        if($IDpadre=='any'){
            $dbResponse=\Singleton::DB()->query("SELECT COUNT(*) as num FROM `categorie` WHERE categorie.nome='$nome';");
                    while($r = mysqli_fetch_assoc($dbResponse)) {$rows[] = $r; }
                    if($rows[0]['num']==0) return FALSE;
                    else return TRUE;     
            
        }
        else
            {
            $dbResponse=\Singleton::DB()->query("SELECT COUNT(*) as num FROM `categorie` WHERE categorie.nome='$nome' and categorie.padre=$IDpadre;");
                    while($r = mysqli_fetch_assoc($dbResponse)) {$rows[] = $r; }
                    if($rows[0]['num']==0) return FALSE;
                    else return TRUE;
        }
    }
    
    private function existsIdCategoria($id){
        $dbResponse=\Singleton::DB()->query("SELECT COUNT(*) as num FROM `categorie` WHERE categorie.id='$id';");
                    while($r = mysqli_fetch_assoc($dbResponse)) {$rows[] = $r; }
                    if($rows[0]['num']==0) return FALSE;
                    else return TRUE;
        
        
    }
    
    
    
    private function deleteCategory($id){
        if(\Singleton::DB()->query("DELETE FROM categorie WHERE categorie.nome='$id';")) {$this->setSuccess("deleted");}
        else {$this->setError("error_deleting_categoria",$id);}
    }
    
    
    /*      END OF FUNCTIONS FOR DELETE       */
    
    
       
    
    private function isValut($valut){
        $x=strtolower($valut);
         if($x=='eur' or $x=='usd' or $x=='gbp' or $x=='btc' or $x=='jpy') return TRUE;
         else return FALSE;
    }
    
    private function indirizzo_is_binded_to_magazzino($IDindirizzo){
        $dbResponse=\Singleton::DB()->query("SELECT COUNT(*) as num FROM magazzini WHERE magazzini.id_indirizzo=$IDindirizzo;");
                    while($r = mysqli_fetch_assoc($dbResponse)) {$rows[] = $r; }
                    if($rows[0]['num']==0) return FALSE;
                    else return TRUE; 
    }
    
    
    
    
    /*      FUNCTIONS FOR GET       */
    
    
    private function showIndirizzi(){
                    $Magazzini=\Singleton::DB()->query("SELECT comuni.nome as citta,comuni.provincia as provincia, comuni.CAP as cap, indirizzi.via, indirizzi.civico FROM `magazzini`,comuni,indirizzi WHERE magazzini.id_indirizzo=indirizzi.id AND indirizzi.id_comune=comuni.id;");
                    while($r = mysqli_fetch_assoc($Magazzini)) {$rows[] = $r; }
                    if(isset($rows))echo json_encode($rows);  
                    else $this->setSuccess("empty"); 
    }
    
    private function showAll(){
                    $items=\Singleton::DB()->query("SELECT prodotti.nome as nome_prodotto,prodotti.info, prodotti.descrizione, categorie.nome as nome_categoria, prodotti.prezzo, prodotti.valuta FROM prodotti,categorie WHERE prodotti.id_categoria=categorie.id UNION SELECT prodotti.nome as nome_prodotto,prodotti.info, prodotti.descrizione, prodotti.id_categoria as nome_categoria, prodotti.prezzo, prodotti.valuta FROM prodotti WHERE prodotti.id_categoria IS NULL;");
                    while($r = mysqli_fetch_assoc($items)) {$rows[] = $r; }
                    if(isset($rows))echo json_encode($rows);  
                    else $this->setSuccess("empty");
                }
                
     private function showProdotti($id_magazzino, $categoria_magazzino){
         if(is_numeric(intval($id_magazzino))) $id_magazzino=intval($id_magazzino);
         if($id_magazzino!=NULL){   /*      MAGAZZINO SETTATO   */
             if($categoria_magazzino!=NULL)
             {      /*      MAGAZZINO E CATEGORIA SETTATI*/
                 $items=\Singleton::DB()->query("SELECT prodotti.nome as nome_prodotto,prodotti.info, prodotti.descrizione, prodotti.prezzo, prodotti.valuta, items_magazzino.quantita FROM prodotti,categorie,items_magazzino WHERE prodotti.id_categoria=categorie.id AND categorie.nome='$categoria_magazzino' AND items_magazzino.id_magazzino=$id_magazzino AND prodotti.id=items_magazzino.id_prodotto;");
                    while($r = mysqli_fetch_assoc($items)) {$rows[] = $r; }
                    if(isset($rows)) echo json_encode($rows);  
                    else $this->setSuccess("empty");
                    
             }
             else{  /*      MAGAZZINO SETTATA E CATEGORIA NULL*/
                    $items=\Singleton::DB()->query("SELECT prodotti.nome as nome_prodotto,prodotti.info, prodotti.descrizione, categorie.nome as categoria, prodotti.prezzo, prodotti.valuta, items_magazzino.quantita FROM prodotti,categorie,items_magazzino WHERE items_magazzino.id_magazzino=$id_magazzino AND items_magazzino.id_prodotto=prodotti.id AND categorie.id=prodotti.id_categoria;");
                    while($r = mysqli_fetch_assoc($items)) {$rows[] = $r; }
                    if(isset($rows)) echo json_encode($rows);  
                    else $this->setSuccess("empty");
             }
             
         }
         else{      /*      MAGAZZINO NON SETTATO       */
                if($categoria_magazzino!=NULL)
                {      /*      MAGAZZINO NON SETTATO E CATEGORIA SETTATI*/
                    $items=\Singleton::DB()->query("SELECT prodotti.id, prodotti.nome as nome_prodotto,prodotti.info, prodotti.descrizione, prodotti.prezzo, prodotti.valuta, items_magazzino.quantita, items_magazzino.id_magazzino FROM prodotti,categorie,items_magazzino WHERE prodotti.id_categoria=categorie.id AND categorie.nome='$categoria_magazzino' AND items_magazzino.id_prodotto=prodotti.id");
                       while($r = mysqli_fetch_assoc($items)) {$rows[] = $r; }
                       if(isset($rows)) echo json_encode($rows);  
                       else $this->setSuccess("empty");

                }
                else{  /*      NIENTE SETTATO       */
                       
                       $this->setError("wrong_url");
                }
                }
            }
    
    private function showCategorie(){
        $categorie=\Singleton::DB()->query("SELECT categorie.id, categorie.nome as nome_categoria, categorie.padre as id_padre FROM categorie;");
        while($r = mysqli_fetch_assoc($categorie)) {$rows[] = $r; }
        if(isset($rows)) echo json_encode($rows);
        else $this->setSuccess("empty");
    }
/*          END FUNCTIONS FOR GET       */
    
    


    private function setSuccess($success){
        switch($success){
            
    case 'created':
        http_response_code(201);
        echo '{
            "message":"Successful Post"
            }';
        break;
    
    case 'deleted':
    case 'empty':
        http_response_code(200);    //posso mettere anche 204 ma il borwser non reindirizzera il bliente sulla pagina con il json e il cliente non vedra il json. Potra capire tuttavia che e e andato tutto bene dal codice
        echo '{
            "message":"Everything went fine but there are no results"
            }';
        break;
    
    default:
        http_response_code(501);
        break;
    }
    }
    
    
    private function setError($error,$other='NULL'){
        switch($error){
    case 'fill_fields':
        http_response_code(400);
        echo '{
            "message":"You must fill all fields",
            "tip":"For help use the OPTIONS request"
            }';
    
    case 'expected_index':
        http_response_code(400);
        echo '{
            "message":"Expected index number after .../id/",
            "tip":"For help use the OPTIONS request"
            }';
        break;
    
    
    case 'expected_categoria':
        http_response_code(400);
        echo '{
            "message":"Expected categoria name after .../categoria/",
            "tip":"For help use the OPTIONS request"
            }';
        break;
        
    case 'no_parameters_after_indirizzi':
        http_response_code(400);
        echo '{
            "message":"NO parameters were expected. The URL must end in .../indirizzi",
            "tip":"For help use the OPTIONS request"
            }';
        break;
    
    case 'no_parameters_after_categorie':
        http_response_code(400);
        echo '{
            "message":"NO parameters were expected. The URL must end in .../categorie",
            "tip":"For help use the OPTIONS request"
            }';
        break;    
    
    case 'wrong_url':
        http_response_code(400);
        echo '{
            "message":"The URL inserted is in the wrong format",
            "tip":"For help use the OPTIONS request"
            }';
        break;
    
    case 'delete_more_params':
        http_response_code(400);
        echo '{
            "message":"Not enought parameters. Expected 2 parameters",
            "tip":"For help use the OPTIONS request"
            }';
        break;
    
    case 'delete_less_params':
        http_response_code(400);
        echo '{
            "message":"Too many parameters. Expected only 2 parameters",
            "tip":"For help use the OPTIONS request"
            }';
        break;
    
    case 'is_inside_basket':
        http_response_code(400);
        echo '{
            "message":"Cannot delete product with id '.$other.' becaust it is inside a basket",
            "tip":"For help use the OPTIONS request"
            }';
        break;
    
    case 'prodotto_not_exists':
        http_response_code(400);
        echo '{
            "message":"Product with id '.$other.' does not exist",
            "tip":"For help use the OPTIONS request"
            }';
        break;
    
    case 'indirizzo_not_exists':
        http_response_code(400);
        echo '{
            "message":"Indirizzo with id '.$other.' does not exist",
            "tip":"For help use the OPTIONS request"
            }';
        break;
    
    case 'magazzino_not_empty':
        http_response_code(400);
        echo '{
            "message":"Magazzino '.$other.'. is not empty. You can delte a magazzino only if it-s empty",
            "tip":"For help use the OPTIONS request"
            }';
        break;
    
    case 'magazzino_not_exists':
        http_response_code(400);
        echo '{
            "message":"Magazzino with id '.$other.' does not exist",
            "tip":"For help use the OPTIONS request"
            }';
        break;
    
    case 'categoria_not_exists':
        http_response_code(400);
        echo '{
            "message":"Categoria '.$other.' does not exist",
            "tip":"For help use the OPTIONS request"
            }';
        break;
    
    case 'id_categoria_not_exists':
        http_response_code(400);
        echo '{
            "message":"Categoria with id '.$other.' does not exist",
            "tip":"For help use the OPTIONS request"
            }';
        break;
    
    case 'only_one_parameter':
        http_response_code(400);
        echo '{
            "message":"Expected only 1 parameter",
            "tip":"For help use the OPTIONS request"
            }';
        break;
    
    case 'immage':
        http_response_code(500);
        echo '{
            "message":"ERROR deleting immage associated with product '.$other.'. Aborted the deletion of item with id '.$other.'",
            "tip":"For help use the OPTIONS request"
            }';
        break;
    
    case 'prod_but_immage_cancelled':
        http_response_code(500);
        echo '{
            "message":"ERROR deleting product with id '.$other.'" but his immage from table `immagini` was already deleted",
            "tip":"For help use the OPTIONS request"
            }';
        break;
    
    case 'error_deleting_indirizzo':
        http_response_code(500);
        echo '{
            "message":"ERROR deleting indirizzo with id '.$other.'",
            "tip":"For help use the OPTIONS request"
            }';
        break;
    
    case 'error_deleting_magazzino':
        http_response_code(500);
        echo '{
            "message":"ERROR deleting magazzino with id '.$other.'",
            "tip":"For help use the OPTIONS request"
            }';
        break;
    
    case 'error_deleting_categoria':
        http_response_code(500);
        echo '{
            "message":"ERROR deleting categoria with id '.$other.'",
            "tip":"For help use the OPTIONS request"
            }';
        break;
    
    case 'sql':
        http_response_code(500);
        echo '{
            "message":"ERROR (sql)",
            "tip":"For help use the OPTIONS request"
            }';
        break;
        
        case 'gestore_inesistente':
        http_response_code(400);
        echo '{
            "message":"Id of gestore does not exist.",
            "tip":"For help use the OPTIONS request"
            }';
        break;
        
        case 'indirizzo_inesistente':
        http_response_code(400);
        echo '{
            "message":"Id of indirizzo does not exist.",
            "tip":"For help use the OPTIONS request"
            }';
        break;
    
    case 'categoria_esistente':
        http_response_code(400);
        echo '{
            "message":"This category already exists.",
            "tip":"For help use the OPTIONS request"
            }';
        break;
    case 'is_not_float':
        http_response_code(400);
        echo '{
            "message":"Expected a parameter to be float, insted recived '.$other.'",
            "tip":"For help use the OPTIONS request"
            }';
        break;
    case 'is_not_valut':
        http_response_code(400);
        echo '{
            "message":"Expected a parameter to be float, insted recived '.$other.'",
            "tip":"For help use the OPTIONS request"
            }';
        break;
    
    case 'is_not_int':
        http_response_code(400);
        echo '{
            "message":"Expected a parameter to be an integer, insted recived '.$other.'",
            "tip":"For help use the OPTIONS request"
            }';
        break;
    case 'provincia_lunga':
        http_response_code(400);
        echo '{
            "message":"Provincia is too long. It must be maximum 2 character. Found provincia '.$other.',
            "tip":"For help use the OPTIONS request"
            }';
        break;
    
    case 'indirizzo_binded':
        http_response_code(400);
        echo '{
            "message":"The id '.$other.' that you are trying to delete is binded to a magazzino",
            "tip":"For help use the OPTIONS request"
            }';
        break;
    
    
    
    
    
    
    /*  Non dovrebbe mai essere chiamato default xke sono io che faccio le chiamate  a setError e sono io che scelgo quale e il parametro*/
    default:
        http_response_code(502);
        echo '{
            "tip":"For help use the OPTIONS request"
            }';
        break;
        
    }
    }
    
}
    
?>