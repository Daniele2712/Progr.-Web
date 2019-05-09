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
            if(in_array("nome", $params) && $ok)
                {
                $index=array_search('nome', $params);
                    if(isset($params[$index+1]))
                        {
                        if($params[$index+1]!=""){$nome_dipendente=$params[$index+1];}
                        else $nome_dipendente=null;
                        }
                    else {$ok=FALSE; self::setError("expected_nome");}
                }
            else $nome_dipendente=null;

            if(in_array("cognome", $params) && $ok)
                {
                $index=array_search('cognome', $params);
                    if(isset($params[$index+1]))
                        {
                        if($params[$index+1]!="") {$cognome_dipendente=$params[$index+1];}
                        else $cognome_dipendente=null;
                        }
                    else {$ok=FALSE; self::setError("expected_cognome");}
                }
            else $cognome_dipendente=null;

            if(in_array("ruolo", $params) && $ok)
                {
                $index=array_search('ruolo', $params);
                    if(isset($params[$index+1]))
                        {
                           if($params[$index+1]!="") {
                                if(self::existsRuolo($params[$index+1]))  { $ruolo_dipendente=$params[$index+1]; }
                                else {$ok=FALSE; self::setError("ruolo_not_exists",$params[$index+1]);}
                                }
                            else $ruolo_dipendente=null;

                        }
                    else {$ok=FALSE; self::setError("expected_ruolo");};
                }
                 else $ruolo_dipendente=null;

            if(in_array("magazzino", $params) && $ok)   //non verifico se il magazzino esiste o meno
                {
                $index=array_search('magazzino', $params);
                    if(isset($params[$index+1]))
                        {
                           if($params[$index+1]!="") { $id_magazzino_dipendente=$params[$index+1]; }
                           else $id_magazzino_dipendente=null;
                        }
                    else {$ok=FALSE; self::setError("expected_magazzino");};
                }
            else $id_magazzino_dipendente=null;


                if($ok) self::showDipendenti($nome_dipendente, $cognome_dipendente, $ruolo_dipendente, $id_magazzino_dipendente);      // !!! ATTENZIONE LA FUNZIONE SHOW DIPENDENTI DOVREBBE VERIFICARE PRIMA SE IN EFFETTI L-UTENTE CHE RICHIEDE DI VEDERE I DIPENDENTI HA IL DIRITTO DI FARLO PER EVITARE CHE UN GESTORE VEDA UTENTI DI TUTTI I MAGAZZINI

    }

    public static function post(Request $req){
    }

    public static function default(Request $req){
        self::get($req);
    }


 private static function showDipendenti($nome_dipendente, $cognome_dipendente, $ruolo_dipendente, $id_magazzino_dipendente){  // !!! ATTENZIONE LA FUNZIONE SHOW DIPENDENTI DOVREBBE VERIFICARE PRIMA SE IN EFFETTI L-UTENTE CHE RICHIEDE DI VEDERE I DIPENDENTI HA IL DIRITTO DI FARLO PER EVITARE CHE UN GESTORE VEDA UTENTI DI TUTTI I MAGAZZINI

        // IL FORMATO RITORNATO SARA DEL TIPO: {"id_dipendente":"8","nome_dipendente":"Luigi","cognome_dipendente":"Verdi","ruolo_dipendente":"Pulizie","paga_oraria_dipendente":"6.31","id_magazzino_dipendente":"2"}
        if($nome_dipendente===null) {$sql_nome_dipendente="dati_anagrafici.nome LIKE '%'";}
        else {$sql_nome_dipendente="dati_anagrafici.nome LIKE '%$nome_dipendente%'";}

        if($cognome_dipendente===null) {$sql_cognome_dipendente="dati_anagrafici.cognome LIKE '%'";}
        else{$sql_cognome_dipendente="dati_anagrafici.cognome LIKE '%$cognome_dipendente%'";}

        if($ruolo_dipendente==="Tutti" || $ruolo_dipendente===null) {$sql_ruolo_dipendente="dipendenti_ruoli.ruolo LIKE '%'";}
        else{$sql_ruolo_dipendente="dipendenti_ruoli.ruolo='$ruolo_dipendente'";}

        if($id_magazzino_dipendente===null) {$sql_id_magazzino_dipendente="dipendenti.id_magazzino LIKE '%'";}
        else {$sql_id_magazzino_dipendente="dipendenti.id_magazzino='$id_magazzino_dipendente'";}

        // AGGIUNGI GLI SQL FILTER
        $fullQuerry="SELECT dipendenti.id as id_dipendente , dati_anagrafici.nome as nome_dipendente,  dati_anagrafici.cognome as cognome_dipendente, dipendenti_ruoli.ruolo as ruolo_dipendente,  dipendenti.paga_oraria as paga_oraria_dipendente, dipendenti.id_magazzino as id_magazzino_dipendente FROM dipendenti,dati_anagrafici,utenti,dipendenti_ruoli WHERE dati_anagrafici.id=utenti.id_datianagrafici AND utenti.id=dipendenti.id_utente AND dipendenti.ruolo=dipendenti_ruoli.id AND $sql_nome_dipendente AND $sql_cognome_dipendente AND $sql_ruolo_dipendente AND $sql_id_magazzino_dipendente";
        $dipendenti=\Singleton::DB()->query($fullQuerry);
         while($r = mysqli_fetch_assoc($dipendenti)) {$rows[] = $r; }
                    if(isset($rows)) echo json_encode($rows);
                    else self::setSuccess("empty");
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
