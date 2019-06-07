<?php
namespace Controllers\Api;
use \Controllers\Controller as Controller;
use \Views\Request as Request;
if(!defined("EXEC")){
    header("location: /index.php");
	return;
}

class C_dipendenti implements Controller{

    public static function get(Request $req){
        header('Content-type: application/json');
        $params=$req->getOtherParams();

            $ok=TRUE;   // se l-utente sbaglia a scrivere salto molti controlli
            $filters=array(); // questo filtro lo passero alla funzione F_Dipendente::showDipendenti

            if($ok && in_array("nome", $params)) {
                  $index=array_search('nome', $params);
                  if(isset($params[$index+1])) {$filters['nome']=$params[$index+1];}
                  else {$ok=FALSE; self::setError("expected_nome");}
                }

            if($ok && in_array("cognome", $params)){
                  $index=array_search('cognome', $params);
                  if(isset($params[$index+1])) {$filters['cognome']=$params[$index+1];}
                  else {$ok=FALSE; self::setError("expected_cognome");}
                }

            if($ok && in_array("ruolo", $params))
                {
                  $index=array_search('ruolo', $params);
                    if(isset($params[$index+1]))
                        {
                          if(self::existsRuolo($params[$index+1]))  { $filters['ruolo']=$params[$index+1]; }
                          else {$ok=FALSE; self::setError("ruolo_not_exists",$params[$index+1]);}
                        }
                    else {$ok=FALSE; self::setError("expected_ruolo");}
                }

            if($ok && in_array("idMagazzino", $params))   //non verifico se il magazzino esiste o meno
                {
                $index=array_search('idMagazzino', $params);
                    if(isset($params[$index+1])) {
                       if(\Foundations\F_Magazzino::seek($params[$index+1])) {$filters['idMagazzino']=$params[$index+1];}
                       else {\Foundations\Log::logMessage("Qualcuno cerca di di filtrare per un Magazzino che non esiste, non sarebbe dovuto accadere.",$req); $ok=FALSE;}
                     }
                    else {$ok=FALSE; self::setError("expected_magazzino");};
                }

              if($ok && in_array("username", $params)){
                    $index=array_search('username', $params);
                    if(isset($params[$index+1])) {$filters['username']=$params[$index+1];}
                    else {$ok=FALSE; self::setError("expected_username");}
                  }

              if($ok && in_array("email", $params)){
                    $index=array_search('email', $params);
                    if(isset($params[$index+1])) {$filters['email']=$params[$index+1];}
                    else {$ok=FALSE; self::setError("expected_email");}
                  }
              if($ok && in_array("telefono", $params)){
                    $index=array_search('telefono', $params);
                    if(isset($params[$index+1])) {$filters['telefono']=$params[$index+1];}
                    else {$ok=FALSE; self::setError("expected_telefono");}
                  }
                  /*  Ora, se va tutto bene faccio la chiamata che mi mostra i dipendenti filtrati. Se i parametri non li passo, la classe F_Dipendenti scegliera tutti di quella categoria, senza FILTRARE*/
                if($ok) $dipendenti=\Foundations\utenti\F_Dipendente::showDipendenti($filters);      // !!! ATTENZIONE LA FUNZIONE SHOW DIPENDENTI DOVREBBE VERIFICARE PRIMA SE IN EFFETTI L-UTENTE CHE RICHIEDE DI VEDERE I DIPENDENTI HA IL DIRITTO DI FARLO PER EVITARE CHE UN GESTORE VEDA UTENTI DI TUTTI I MAGAZZINI

                /*essendo una api devo ritornare il risultato in formato json*/
                if($dipendenti) { $v = new \Views\JSONView(array("r" => 200, "dipendenti"=>$dipendenti)); $v->render();}  //non devo passarli i dati del dipendente in formato json, si occuper la JSONView di trasformarlo in Json prima di renderizzarlo
                else{ self::setSuccess("empty");}
    }

    public static function post(Request $req){
    }

    public static function default(Request $req){
        self::get($req);
    }




private static function existsRuolo($ruolo){
    return true;
}

private static function setError($error, $var=''){
    switch($error){
    case 'expected_nome':
        http_response_code(400);
        echo '{
            "message":"Expected nome after .../nome/"}';
        break;

    case 'expected_cognome':
        http_response_code(400);
        echo '{
            "message":"Expected cognome after .../cognome/"}';
        break;

     case 'ruolo_not_exists':
        http_response_code(400);
        echo '{"message":"The role '.$var.' does not exist."}';
        break;

    case 'expected_ruolo':
        http_response_code(400);
        echo '{
            "message":"You must enter a role after .../ruolo/"}';
        break;

    case 'expected_magazzino':
        http_response_code(400);
        echo '{
            "message":"You must enter a magazzino after .../magazzino/"}';
        break;
    case 'expected_username':
        http_response_code(400);
        echo '{
            "message":"You must enter a username after .../magazzino/"}';
    break;
    case 'expected_telefono':
        http_response_code(400);
        echo '{
            "message":"You must enter a telefono after .../magazzino/"}';
        break;
    case 'expected_email':
        http_response_code(400);
        echo '{
            "message":"You must enter an email after .../magazzino/"}';
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
