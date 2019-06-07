<?php
namespace Controllers\Api;
use \Views\Request as Request;

class C_ApiController{

    /*          API URLs
        GET
    /api/   ├── indirizzi                                   mostra indirizzi e ID di tutti i magazzini       ritorna qualcosa tipo: {"id_magazzino":"1","citta":"l'aquila","provincia":"AQ","cap":"67100","via":"viale croce rossa","civico":"2"}
            ├── categorie                                   mostra tutte le categorie                        ritorna qualcosa tipo: {"id":"1","nome_categoria":"alimentari","id_padre":null}
            ├── prodotti/  ├──                              mostra tutti gli item di tutti i magazzini
                            ├── id/$int ├──                 mosstra tutti gli item del magazzino con ID $int
                                        ├──categoria/$cat   mostra tutti gli item del magazzino con ID $int aventi categoria $cat
                            ├── categoria/$cat              mostra tutti gli item di tuti i magazzini con categoria $cat
            ├── dipendenti  /nome/cognome/ruolo/
     * i filtri per i prodotti sono :
     * nome(non serve il nome completo, basta anche una sottostringa del nome)
     * magazzino
     * categoria
     * prezzo_min
     * prezzo_max
     * i filtri x i prodotti si possono concatenare in qualunque orodine
     *
      //non e' molto intuitivo...il fatto e; che puoi ottenere i prodotti chiamando magazzini....
     faccio un altra cosa..con prodotti...
     * tipo
     * /api/prodotti/magazzino/2/categoria/elettro/pricemin/13,2/pricemax/44/nome/abc

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
    public static function get($request){  // dovrebbe essere una richiesta quello che get riceve

        header('Content-type: application/json');

        /*      Magari metti i metodi x vedere se esistono le categorie e i magazzini richiesti     */
        $params=$request->getOtherParams();

        switch (array_shift($params)){




    case 'carrello':
        $sessione= \Singleton::Session();
        if($sessione->isLogged()){
        $idCarrello=$sessione->getCart()->getId();
        $db=\Singleton::DB();
        // prima richiesta al db x scoprire tutti gli item del carrello con id del utente loggato, e i loro prezzi
        $tizioPreparato=$db->prepare('SELECT DISTINCT items_carrello.id, prodotti.nome, items_carrello.quantita, items_carrello.totale , items_carrello.id_valuta FROM items_carrello LEFT JOIN prodotti ON prodotti.id=items_carrello.id_prodotto WHERE items_carrello.id_carrello=?');
        $tizioPreparato->bind_param("i", $idCarrello);
        $tizioPreparato->execute();
        //$tizioPreparato->bind_result($useless, $nome, $quantita,$prezzo,$idValuta);     //la cosa con useless l-ho scelta cosi mi prende risultati veramente distinti, quindi alla querry dovevo aggiungere l-id della tabbella items_carrello, e di conseguenza dovevo anche bindarlo
        $res = $tizioPreparato->get_result();
        $tizioPreparato->close();
        while($row = $res->fetch_assoc()){   // fevi fetchare tutti i risultati, xke se non liberi lo spazio x ricevere la risposta non puoi fare un altra prepare, dice qualcosa tipo: le 2 richeiste non sono in sync
           //da fare modifiche x la parte valuta
            $valuta=\Foundations\Valuta::find($row["id_valuta"])[2];
            $oggettoDaRitornare['inListProducts'][]=array(
                                                        "nome" => $row["nome"],
                                                        "quantita" => $row["quantita"],
                                                        "item_prezzo" => $row["totale"],
                                                        "item_valuta" => $valuta,
                                                    );
        };
        // segue la richiesta x scoprire il totale(prezzo e valuta) di TUTTO il carrello
        $tizioPreparato=$db->prepare('SELECT carrelli.totale, carrelli.id_valuta FROM carrelli WHERE id=?;');
        $tizioPreparato->bind_param("i", $idCarrello);
        $tizioPreparato->execute();
        $tizioPreparato->bind_result($totPrezzo, $totIdValuta);
        $tizioPreparato->fetch();
        $tizioPreparato->close();
        $totValuta=\Foundations\Valuta::find($totIdValuta)[2];
        $oggettoDaRitornare['totale_prezzo']=$totPrezzo;
        $oggettoDaRitornare['totale_valuta']=$totValuta;
        echo json_encode($oggettoDaRitornare);
        }
        else self::setError("non_loggato");
        break;




    case 'indirizzi':
        if(sizeof($params)==0 or $params[0]=='' )     self::showIndirizzi();
        else self::setError("no_parameters_after_indirizzi");
        break;


    case 'categorie':
        if(sizeof($params)==0 or $params[0]=='' )     self::showCategorie();
         else self::setError("no_parameters_after_categorie");
         break;




     default:
        self::setError("wrong_url");
        break;
    }


    }


    public static function delete($request){

        header('Content-type: application/json');
        /*  MAGARI aggiungere anche cancellare la foto dle prodotto e il collegamento, non solo il prodotto*/

        /*      Magari metti i metodi x vedere se esistono le categorie e i magazzini richiesti     */
        $params=$request->getOtherParams();
        if(sizeof($params)<2) self::setError("delete_more_params");
        elseif(sizeof($params)>2)   self::setError("delete_less_params");
        elseif($params[1]=="") self::setError("delete_more_params");
        else{

            switch (array_shift($params)){
        case 'prodotto':
            if(self::existsProdotto($params[0]))
            {
                if(self::prodottoNonNelCarrello($params[0])) self::deleteProdotto($params[0]);
                else self::setError("is_inside_basket",$params[0]);
            }
            else self::setError("prodotto_not_exists",$params[0]);
            break;

        case 'indirizzo':
            if(self::indirizzo_is_binded_to_magazzino($params[0])) self::setError("indirizzo_binded",$params[0]);
            elseif(self::existsIndirizzo($params[0])) self::deleteIndirizzo($params[0]);
            else self::setError("indirizzo_not_exists",$params[0]);    /*  OPPURE PUO ESSEER CHE NON HA FUNZIONATO XKE ESISTE UN AMGAZZINO CHE HA UN INDIRIZZO COME IL MIO E ON DELETE RESTRICT!*/
            break;


        case 'magazzino':
            if(self::existsMagazzino($params[0]))
            {
                if(self::isEmptyMagazzino($params[0]))self::deleteMagazzino($params[0]);
                else self::setError("magazzino_not_empty",$params[0]);
            }
            else self::setError("magazzino_not_exists",$params[0]);
            break;

        case 'categoria':   /*  L-imput di categoria dovrebbe essere una stringa*/
            if(self::existsCategoria($params[0],'any'))
            {
                self::deleteCategory($params[0]);
            }
            else self::setError("categoria_not_exists",$params[0]);
            break;


        default:
            self::setError("wrong_url");
            break;
        }
    }

    }

    public static function post($request){


        header('Content-type: application/json');
        $params=$request->getOtherParams();
        if(sizeof($params)!=1) self::setError("only_one_parameter");
        else{


        switch (array_shift($params)){


    case 'aggiungiProdotto':
        $allOk=TRUE;
        $sessione= \Singleton::Session();
        if($sessione->isLogged()){

            $idProdotto=$request->getParam('productId', 'ALL', NULL, 'POST');
            $prodotto= \Foundations\Prodotto::find($idProdotto);        // e; un model
            if($prodotto!=null)
            {
                $idValuta=$prodotto->getPrezzo()->getValuta();
                $quantita=$request->getParam('quantity', 'ALL', NULL, 'POST');
                if(is_numeric($quantita) && $quantita>0)
                    {
                    $totale=$prodotto->getPrezzo()->getPrezzo()*$quantita;
                    $idCarrello=$sessione->getCart()->getId();
                    $lastId=\Foundations\Carrello::insertItems_Carrello($idCarrello,$idProdotto, $totale, $idValuta, $quantita);
                    self::SetSuccess('created');
                    }
                else
                {
                  self::setError("quantita_prodotto_errata", $idProdotto);
                }
            }
            else{
                self::setError("prodotto_not_exists", $idProdotto);
            }
        }
        else self::setError("non_loggato");

        break;

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
                if(self::existsIdCategoria($rawData['id_categoria'])) $cat= $rawData['id_categoria'];
                else {self::setError('id_categoria_not_exists',$rawData['id_categoria']);$ok=FALSE;}
            }
            if(is_numeric($rawData['prezzo'])) $pre=floatval($rawData['prezzo']);
            else {self::setError('is_not_float',$rawData['prezzo']);$ok=FALSE;}
            if(self::isValut($rawData['valuta'])) $val=$rawData['valuta'];
            else {self::setError('is_not_valut',$rawData['prezzo']);$ok=FALSE;}

            if($ok)
                {
                if(\Singleton::DB()->query("INSERT INTO `prodotti` (`id`, `nome`, `info`, `descrizione`, `id_categoria`, `prezzo`, `valuta`) VALUES (NULL, '$nom', '$inf', '$des', $cat, $pre, '$val');")) self::setSuccess("created");
                else self::setError("sql");
                }
            else{echo "something went wrong!";}
        }
            else self::setError("fill_fields");
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
            if(strlen($rawData['provincia'])>2) {self::setError('provincia_lunga',$rawData['provincia']);$ok=FALSE;}
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
              if(\Singleton::DB()->query("INSERT INTO `indirizzi` (`id`, `id_comune`, `via`, `civico`, `note`) VALUES (NULL, '$lastId', '$via', '$civ', $not);")) self::setSuccess("created");
              else self::setError("sql");
              }
              else self::setError("sql");
            }
        }
            else self::setError("fill_fields");

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
            else {self::setError('is_not_int',$rawData['id_indirizzo']);$ok=FALSE;}
            if($ok AND is_numeric($rawData['id_gestore'])) $ges=intval($rawData['id_gestore']);
            else {self::setError('is_not_int',$rawData['id_gestore']); $ok=FALSE;}

            if($ok)
            {
            if(!self::existsGestore($ges)) self::setError("gestore_inesistente");
            elseif(!self::existsIndirizzo($ind))  self::setError("indirizzo_inesistente");
                else{
                        if(\Singleton::DB()->query("INSERT INTO `magazzini` (`id`, `id_gestore`, `id_indirizzo`) VALUES (NULL, '$ges', '$ind');")) self::setSuccess("created");
                        else self::setError("sql");
                    }
            }
        }

            else self::setError("fill_fields");

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
                if(\Singleton::DB()->query("INSERT INTO `categorie` (`id`, `nome`, `padre`) VALUES (NULL, '$nom', NULL);")) self::setSuccess("created");
                else self::setError("sql");
            }
            elseif(self::existsIdCategoria($rawData['id_padre'])) $pad=$rawData['id_padre'];
            else {self::setError('id_categoria_not_exists',$rawData['id_padre']); $ok=FALSE;}
            if($ok)
            {
                if(self::existsCategoria($nom, $pad)) self::setError("categoria_esistente");
                    else{
                            if(\Singleton::DB()->query("INSERT INTO `categorie` (`id`, `nome`, `padre`) VALUES (NULL, '$nom', $pad);")) self::setSuccess("created");
                            else self::setError("sql");
                        }

            }
        }
        else self::setError("fill_fields");

        break;


    default:
        self::setError("wrong_url");
        break;
    }
    }

    }



    public static function options($params){
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










    /*      static functionS FOR DELETE       */
    private static function existsProdotto($id){
        $dbResponse=\Singleton::DB()->query("SELECT COUNT(*) as num FROM `prodotti` WHERE prodotti.id=$id;");
                    while($r = mysqli_fetch_assoc($dbResponse)) {$rows[] = $r; }
                    if($rows[0]['num']==1) return TRUE;
                    else return FALSE;
    }

    private static function prodottoNonNelCarrello($id){
        $dbResponse=\Singleton::DB()->query("SELECT COUNT(*) as num FROM `items_carrello` WHERE items_carrello.id_prodotto=$id;");
                    while($r = mysqli_fetch_assoc($dbResponse)) {$rows[] = $r; }
                    if($rows[0]['num']==0) return TRUE;
                    else return FALSE;
    }

    private static function deleteProdotto($id){
        $tuttoOK=TRUE;
         /*      Deleting immage    */       /*    il mio if(querry) non rida sempre vero in caso sia andato tutto bene... anzi, rida TURUE anche quando le righe affettate possono essere 0*/
        if(\Singleton::DB()->query("DELETE FROM immagini WHERE id IN (SELECT id_immagine FROM `immagini_prodotti` WHERE id_prodotto='$id');"));
        else {$tuttoOK=FALSE; self::setError("immage",$id);}

        /*      Deleting product    */
        if($tuttoOK && \Singleton::DB()->query("DELETE FROM prodotti WHERE prodotti.id=$id;")) {self::setSuccess("deleted");}
        else {$tuttoOK=FALSE;self::setError("prod_but_immage_cancelled",$id);}
        }

    private static function existsIndirizzo($id){
        $dbResponse=\Singleton::DB()->query("SELECT COUNT(*) as num FROM `indirizzi` WHERE indirizzi.id=$id;");
                    while($r = mysqli_fetch_assoc($dbResponse)) {$rows[] = $r; }
                    if($rows[0]['num']==1) return TRUE;
                    else return FALSE;
    }

    private static function deleteIndirizzo($id){
        if(\Singleton::DB()->query("DELETE FROM indirizzi WHERE indirizzi.id=$id;")) {self::setSuccess("deleted");}
        else {self::setError("error_deleting_indirizzo",$id);} /*  TODO questo else non serve a niente, come tutto gli altri che ho fatto...xke a quanto   */

    }

    private static function existsMagazzino($id){
        $dbResponse=\Singleton::DB()->query("SELECT COUNT(*) as num FROM `magazzini` WHERE magazzini.id=$id;");
                    while($r = mysqli_fetch_assoc($dbResponse)) {$rows[] = $r; }
                    if($rows[0]['num']==1) return TRUE;
                    else return FALSE;
    }

    private static function existsGestore($id){
        $dbResponse=\Singleton::DB()->query("SELECT COUNT(*) as num FROM `gestori` WHERE gestori.id=$id;");
                    while($r = mysqli_fetch_assoc($dbResponse)) {$rows[] = $r; }
                    if($rows[0]['num']==1) return TRUE;
                    else return FALSE;
    }

     private static function isEmptyMagazzino($id){
        $dbResponse=\Singleton::DB()->query("SELECT COUNT(*) as num FROM `items_magazzino` WHERE items_magazzino.id_magazzino=$id;");
        while($r = mysqli_fetch_assoc($dbResponse)) {$rows[] = $r; }
                    if($rows[0]['num']==0) return TRUE;
                    else return FALSE;
    }
     private static function deleteMagazzino($id){
        if(\Singleton::DB()->query("DELETE FROM magazzini WHERE magazzini.id=$id;")) {self::setSuccess("deleted");}
        else {self::setError("error_deleting_magazzino",$id);}
        /*      Non penso devo cancelare qualcos..altro*/
    }


    private static function existsCategoria($nome, $IDpadre){  /*  Questa funzione puo essere chiamata sia con uno che con 2 parametri...opppure devo per forza specificare il null??? */
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

    private static function existsIdCategoria($id){
        $dbResponse=\Singleton::DB()->query("SELECT COUNT(*) as num FROM `categorie` WHERE categorie.id='$id';");
                    while($r = mysqli_fetch_assoc($dbResponse)) {$rows[] = $r; }
                    if($rows[0]['num']==0) return FALSE;
                    else return TRUE;


    }



    private static function deleteCategory($id){
        if(\Singleton::DB()->query("DELETE FROM categorie WHERE categorie.nome='$id';")) {self::setSuccess("deleted");}
        else {self::setError("error_deleting_categoria",$id);}
    }


    /*      END OF static functionS FOR DELETE       */




    private static function isValut($valut){
        $x=strtolower($valut);
         if($x=='eur' or $x=='usd' or $x=='gbp' or $x=='btc' or $x=='jpy') return TRUE;
         else return FALSE;
    }

    private static function indirizzo_is_binded_to_magazzino($IDindirizzo){
        $dbResponse=\Singleton::DB()->query("SELECT COUNT(*) as num FROM magazzini WHERE magazzini.id_indirizzo=$IDindirizzo;");
                    while($r = mysqli_fetch_assoc($dbResponse)) {$rows[] = $r; }
                    if($rows[0]['num']==0) return FALSE;
                    else return TRUE;
    }




    /*      static functionS FOR GET       */


    private static function showIndirizzi(){
                    $Magazzini=\Singleton::DB()->query("SELECT indirizzi.id as id_magazzino, comuni.nome as citta,comuni.provincia as provincia, comuni.CAP as cap, indirizzi.via, indirizzi.civico FROM `magazzini`,comuni,indirizzi WHERE magazzini.id_indirizzo=indirizzi.id AND indirizzi.id_comune=comuni.id;");
                    while($r = mysqli_fetch_assoc($Magazzini)) {$rows[] = $r; }
                    if(isset($rows))echo json_encode($rows);
                    else self::setSuccess("empty");
    }



     private static function showProdotti($id_magazzino, $categoria, $nome, $prezzo_min, $prezzo_max){
        //aggiungere eventuali controlli sul tipo di variabile che gli viene passato e possibili sql injection
        if(!isset($id_magazzino)) $sql_id_magazzino="id_magazzino LIKE '%'";
        else $sql_id_magazzino="id_magazzino=$id_magazzino";        //possiible che devo trasformare il id in un nnumero??? con intval? Oppure i singoli apici....

        if(!isset($categoria)) $sql_nome_categoria="categorie.nome LIKE '%'";
        else $sql_nome_categoria="categorie.nome='$categoria'";

        if(!isset($nome)) $sql_nome_prodotto="prodotti.nome LIKE '%'";
        else $sql_nome_prodotto= "prodotti.nome LIKE '%$nome%'";

        if(!isset($prezzo_min)) $sql_prezzo_min="prodotti.prezzo > -1";
        else $sql_prezzo_min = "prodotti.prezzo > $prezzo_min";

        if(!isset($prezzo_max)) $sql_prezzo_max="prodotti.prezzo < 999999999";
        else $sql_prezzo_max="prodotti.prezzo < $prezzo_max";


         $items=\Singleton::DB()->query("SELECT DISTINCT prodotti.id as id_prodotto , prodotti.nome as nome_prodotto,  prodotti.descrizione as descrizione_prodotto, prodotti.info as info_prodotto, prodotti.prezzo as prezzo_prodotto, prodotti.valuta as valuta_prodotto, items_magazzino.quantita as quantita_prodotto , categorie.id as id_categoria, categorie.nome as nome_categoria, items_magazzino.id_magazzino as id_magazzino, comuni.nome as comune_magazzino, comuni.provincia as provincia_magazzino, comuni.CAP as cap_magazzino, indirizzi.via as via_magazzino, indirizzi.civico as civico_magazzino FROM prodotti,categorie,items_magazzino,magazzini, indirizzi, comuni WHERE $sql_id_magazzino AND items_magazzino.id_prodotto=prodotti.id AND prodotti.id_categoria=categorie.id AND $sql_nome_categoria AND $sql_nome_prodotto AND $sql_prezzo_min AND $sql_prezzo_max AND id_magazzino=magazzini.id AND magazzini.id_indirizzo=indirizzi.id AND indirizzi.id_comune=comuni.id ;");
         while($r = mysqli_fetch_assoc($items)) {$rows[] = $r; }
                    if(isset($rows)) echo json_encode($rows);
                    else self::setSuccess("empty");
            }




    private static function showCategorie(){
        $categorie=\Singleton::DB()->query("SELECT categorie.id as id_categoria, categorie.nome as nome_categoria, categorie.padre as id_padre FROM categorie;");
        while($r = mysqli_fetch_assoc($categorie)) {$rows[] = $r; }
        if(isset($rows)) echo json_encode($rows);
        else self::setSuccess("empty");
    }



/*          END static functionS FOR GET       */

    private static function utenteLoggato(){
        return true;
    }



    private static function setSuccess($success){  //valido solo x post, get che non ritornano niente  o delete, negli altri casi gli devo stampare il json con le info giuste
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


    private static function setError($error,$other='NULL'){
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

    case 'quantita_prodotto_errata':
        http_response_code(400);
        echo '{
            "message":"The quantity of product with id'.$other.' is invalid (negative, zero, or we don-t have enought products in the store).",
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

    case 'non_loggato':
        http_response_code(400);
        echo '{
            "message":"You must log in to do the operation requested"
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
