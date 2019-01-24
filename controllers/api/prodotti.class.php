<?php
namespace Controllers\Api;
use \Controllers\Controller as Controller;
use \Views\Request as Request;
if(!defined("EXEC")){
    header("location: /index.php");
	return;
}

class prodotti implements Controller{
    
    public static function get(Request $req){   // Qui se non setti i parametri, li metto io =null di nodo che quando chiamo la funzione gli passo dei parametri INIZIALIZZATI, anchse se a null, e php non mi riempier il log di inutili NOTICE dicendomi che ho passato variabili non inizializzate. In showDipendenti,invece, passo variabili non inizializzate il che genera PHP notice nel log
        header('Content-type: application/json');
        $params=$req->getOtherParams();

            $ok=TRUE;   // se l-utente sbaglia a scrivere salto molti controlli
            if(in_array("magazzino", $params) && $ok)
                {
                $indexId=array_search('magazzino', $params);
                    if(isset($params[$indexId+1])){$id_magazzino=$params[$indexId+1];}
                    else {$ok=FALSE; self::setError("expected_magazzino");}
                }
            else {$id_magazzino=null;};

            if(in_array("categoria", $params) && $ok)
                {
                $indexCategoria=array_search('categoria', $params);
                    if(isset($params[$indexCategoria+1])){if(self::existsCategoria($params[$indexCategoria+1], 'any')) {$categoria=$params[$indexCategoria+1];}
                                                          else {$ok=FALSE; self::setError("categoria_not_exists",$params[$indexCategoria+1]);}
                    }
                    else {$ok=FALSE; self::setError("expected_categoria");}
                }
            else {$categoria=null;};
            
            if(in_array("id_categoria", $params) && $ok)
                {
                $indexId=array_search('id_categoria', $params);
                    if(isset($params[$indexId+1])){$id_categoria=$params[$indexId+1];}
                    else {$ok=FALSE; self::setError("expected_id_categoria");}
                }
            else {$id_categoria='Tutte';};

            if(in_array("nome", $params) && $ok)
                {
                $indexId=array_search('nome', $params);

                    if(isset($params[$indexId+1]))
                        {
                        if($params[$indexId+1]!="") $nome=$params[$indexId+1];
                        else $nome=null;
                        }
                    else {$ok=FALSE; self::setError("expected_nome");}
                }
            else {$nome=null;};

            if(in_array("prezzo_min", $params) && $ok)
                {
                $indexId=array_search('prezzo_min', $params);
                    if(isset($params[$indexId+1]))
                        {
                        if(is_numeric($params[$indexId+1])) $prezzo_min=$params[$indexId+1];
                        else $prezzo_min=null;
                        }
                    else {$ok=FALSE; self::setError("expected_price_min");}
                }
            else {$prezzo_min=null;};

            if(in_array("prezzo_max", $params) && $ok)
                {
                $indexId=array_search('prezzo_max', $params);
                    if(isset($params[$indexId+1]))
                        {
                        if(is_numeric($params[$indexId+1])) $prezzo_max=$params[$indexId+1];
                        else $prezzo_max=null;
                        }
                    else {$ok=FALSE; self::setError("expected_price_max");}
                }
            else {$prezzo_max=null;};

            if($ok) self::showProdotti($id_magazzino, $categoria, $id_categoria, $nome, $prezzo_min, $prezzo_max);


    }

    public static function post(Request $req){
    }

    public static function default(Request $req){
        self::get($req);
    }
    
    
private static function showProdotti($id_magazzino, $categoria, $id_categoria, $nome, $prezzo_min, $prezzo_max){        // !!! ATTENZIONE LA FUNZIONE SHOW DIPENDENTI DOVREBBE VERIFICARE PRIMA SE IN EFFETTI L-UTENTE CHE RICHIEDE DI VEDERE I PRODOTTI HA IL DIRITTO DI FARLO PER EVITARE CHE UN GESTORE VEDA PRODOTTI DI TUTTI I MAGAZZINI    
        // {"id_prodotto":"2","nome_prodotto":"piselli","categoria_prodotto":"alimentari","descrizione_prodotto":"blabla","info_prodotto":"altro bla","prezzo_prodotto":"7.95","simbolo_valuta_prodotto":"&euro;","id_magazzino":"1","quantita_prodotto":"178"}
        //aggiungere eventuali controlli sul tipo di variabile che gli viene passato e possibili sql injection
        if($id_magazzino===null) $sql_id_magazzino="items_magazzino.id_magazzino LIKE '%'";
        else $sql_id_magazzino="id_magazzino=$id_magazzino";        //possiible che devo trasformare il id in un nnumero??? con intval? Oppure i singoli apici....

        if($categoria===null) $sql_nome_categoria="categorie.nome LIKE '%'";
        else $sql_nome_categoria="categorie.nome='$categoria'";
        
        if($id_categoria=='Tutte') $sql_id_categoria="categorie.id LIKE '%'";
        else $sql_id_categoria="categorie.id='$id_categoria'";

        if($nome===null) $sql_nome_prodotto="prodotti.nome LIKE '%'";
        else $sql_nome_prodotto= "prodotti.nome LIKE '%$nome%'";

        if($prezzo_min===null) $sql_prezzo_min="prodotti.prezzo LIKE '%'";
        else $sql_prezzo_min = "prodotti.prezzo > $prezzo_min";

        if($prezzo_max===null) $sql_prezzo_max="prodotti.prezzo LIKE '%'";
        else $sql_prezzo_max="prodotti.prezzo < $prezzo_max";

        /* HO PROBLEMI A USARE LA PREPARED STATEMENT!!!  DEVO RISOLVERE PERCHE NON VOGLIO FARE TUTTO CON LA QUERRY*/
        /*
        $conn= \Singleton::DB();
        $stmt = $conn->prepare("SELECT prodotti.id as id_prodotto, prodotti.nome as nome_prodotto, categorie.nome as categoria_prodotto, prodotti.descrizione as descrizione_prodotto, prodotti.info as info_prodotto, prodotti.prezzo as prezzo_prodotto, valute.simbolo as simbolo_valuta_prodotto, items_magazzino.id_magazzino as id_magazzino, items_magazzino.quantita as quantita_prodotto FROM prodotti, categorie, items_magazzino, valute WHERE categorie.id=prodotti.id_categoria AND valute.id=prodotti.id_valuta AND items_magazzino.id_prodotto=prodotti.id AND ? AND ? AND ? AND ? AND ? AND ?");
        $stmt->bind_param("ssssss", $sql_id_magazzino, $sql_nome_categoria, $sql_id_categoria, $sql_nome_prodotto, $sql_prezzo_min, $sql_prezzo_max);
        $stmt->execute();
        $prodotti=$stmt->get_result();
        $stmt->close();
         while($r = $prodotti->fetch_assoc()) {$rows[] = $r;}
                    if(isset($rows)) echo json_encode($rows);
                    else self::setSuccess("empty");
        }
        */
        /*  SOLUZIONE CON LA QUERRY */
        $prodotti=\Singleton::DB()->query("SELECT prodotti.id as id_prodotto, prodotti.nome as nome_prodotto, categorie.nome as categoria_prodotto, prodotti.descrizione as descrizione_prodotto, prodotti.info as info_prodotto, prodotti.prezzo as prezzo_prodotto, valute.simbolo as simbolo_valuta_prodotto, items_magazzino.id_magazzino as id_magazzino, items_magazzino.quantita as quantita_prodotto FROM prodotti, categorie, items_magazzino, valute WHERE categorie.id=prodotti.id_categoria AND valute.id=prodotti.id_valuta AND items_magazzino.id_prodotto=prodotti.id AND $sql_id_magazzino AND $sql_nome_categoria AND $sql_id_categoria AND $sql_nome_prodotto AND $sql_prezzo_min AND $sql_prezzo_max");
        while($r = $prodotti->fetch_assoc()) {$rows[] = $r;}
                    if(isset($rows)) echo json_encode($rows);
                    else self::setSuccess("empty");
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

private static function setError($error, $var=''){
    switch($error){
    case 'expected_magazzino':
        http_response_code(400);
        echo '{
            "message":"Expected index number after .../magazzino/"}';
        break;

    case 'expected_categoria':
        http_response_code(400);
        echo '{
            "message":"Expected categoria name after .../categoria/"}';
        break;
    
    case 'categoria_not_exists':
        http_response_code(400);
        echo '{
            "message":"The category you entered after .../categoria/ does not exist."}';
        break;
    
     case 'expected_nome':
        http_response_code(400);
        echo '{"message":"Expected string after .../nome/"}';
        break;
    
    case 'expected_price_min':
        http_response_code(400);
       echo '{"message":"Expected price_min after .../price_min/"}';
        break;

    case 'expected_price_max':
        http_response_code(400);
       echo '{"message":"Expected price_max after .../price_max/"}';
        break;
    
    case 'expected_id_categoria':
        http_response_code(400);
       echo '{"message":"Expected id_categoria after .../id_categoria/"}';
        break;
    }
}

private static function setSuccess($info){
    switch($info){
    case 'empty':
        http_response_code(200);
        echo '{"message":"Everything went right but the result is empty"}';
    break;   
   }
}

}   
