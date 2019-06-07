<?php
namespace Controllers\Api;
use \Controllers\Controller as Controller;
use \Views\Request as Request;
if(!defined("EXEC")){
    header("location: /index.php");
	return;
}

class C_prodotti implements Controller{

public static function get(Request $req){   // Qui se non setti i parametri, li metto io =null di nodo che quando chiamo la funzione gli passo dei parametri INIZIALIZZATI, anchse se a null, e php non mi riempier il log di inutili NOTICE dicendomi che ho passato variabili non inizializzate. In showDipendenti,invece, passo variabili non inizializzate il che genera PHP notice nel log
  if (!\Singleton::Session()::isAdminOrGestore()) {\Foundations\Log::logMessage("Tentato accesso al Controller di prodotti da parte di utenti che non sono gestori ne amministratori", $req); echo "accesso Negato</br>"; return;}
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
          if(isset($params[$indexCategoria+1])){
            if($params[$indexCategoria+1]=="") $id_categoria=null;
            else{
              if(\Foundations\F_Categoria::seekName($params[$indexCategoria+1])) {$categoria=$params[$indexCategoria+1];}
              else {$ok=FALSE; self::setError("categoria_not_exists",$params[$indexCategoria+1]);}
            }
          }
          else {$ok=FALSE; self::setError("expected_categoria");}
        }
  else {$categoria=null;}

  if(in_array("id_categoria", $params) && $ok)
      {
      $indexId=array_search('id_categoria', $params);
          if(isset($params[$indexId+1])){
            if($params[$indexId+1]=="") $id_categoria=null;
            else{
              if(\Foundations\F_Categoria::seek($params[$indexId+1])) $id_categoria=$params[$indexId+1];
              else {$ok=FALSE; self::setError("id_categoria_non_existent");}
            }
          }
          else {$ok=FALSE; self::setError("expected_id_categoria");}
      }
  else {$id_categoria=null;};

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

  if($ok)
  {
    $risposta=\Foundations\F_Prodotto::getProdottiFiltrati($id_magazzino, $categoria, $id_categoria, $nome, $prezzo_min, $prezzo_max);
    if(!empty($risposta)) echo json_encode($risposta);
    else self::setSuccess("empty");
  }
}

public static function post(Request $req){}

public static function default(Request $req){
    self::get($req);
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
    case 'id_categoria_non_existent':
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
