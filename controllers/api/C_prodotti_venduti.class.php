<?php
namespace Controllers\Api;
use \Controllers\Controller as Controller;
use \Views\Request as Request;
if(!defined("EXEC")){
    header("location: /index.php");
	return;
}

class C_prodotti_venduti implements Controller{

    public static function get(Request $req){   // Qui se non setti i parametri, li metto io =null di nodo che quando chiamo la funzione gli passo dei parametri INIZIALIZZATI, anchse se a null, e php non mi riempier il log di inutili NOTICE dicendomi che ho passato variabili non inizializzate. In showDipendenti,invece, passo variabili non inizializzate il che genera PHP notice nel log
        header('Content-type: application/json');
        $params=$req->getOtherParams();
        if(in_array("magazzino", $params))
                {
                $indexId=array_search('magazzino', $params);
                    if(isset($params[$indexId+1])){
                        $id_magazzino=$params[$indexId+1];
                        self::showProdottiVenduti($id_magazzino);
                    }
                    else {$ok=FALSE; self::setError("expected_id_magazzino");}
                }
            else {self::setError("expected_magazzino");};



    }

    public static function post(Request $req){
    }

    public static function default(Request $req){
        self::get($req);
    }


private static function showProdottiVenduti($mag){

        $prodotti=\Singleton::DB()->query("SELECT prodotti.id as id_prodotto, prodotti.nome as nome_prodotto, categorie.nome as categoria_prodotto, prodotti.descrizione as descrizione_prodotto, prodotti.info as info_prodotto, prodotti_venduti.quantita as quantita_prodotto, prodotti_venduti.id_magazzino as id_magazzino, prodotti_venduti.data as data FROM prodotti, categorie, prodotti_venduti WHERE categorie.id=prodotti.id_categoria AND prodotti_venduti.id_prodotto=prodotti.id AND prodotti_venduti.id_magazzino=$mag");

                while($r = $prodotti->fetch_assoc()) {$rows[] = $r;}
                    if(isset($rows)) echo json_encode($rows);
                    else self::setSuccess("empty");
}


private static function setError($error, $var=''){
    switch($error){
    case 'expected_magazzino':
        http_response_code(400);
        echo '{
            "message":"Expected /magazzino/INDEX"}';
        break;

    case 'expected_id_magazzino':
        http_response_code(400);
        echo '{
            "message":"Expected index number after .../magazzino/"}';
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
