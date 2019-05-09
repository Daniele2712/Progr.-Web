<?php
namespace Controllers\Api;
use \Controllers\Controller as Controller;
use \Views\Request as Request;
if(!defined("EXEC")){
    header("location: /index.php");
	return;
}

class C_ruoli implements Controller{

    public static function get(Request $req){
        self::showRuoli($req);
    }

    public static function default(Request $req){
        self::get($req);
    }

    private static function showRuoli($req){
        $categorie=\Singleton::DB()->query("SELECT dipendenti_ruoli.id as id_ruolo, dipendenti_ruoli.ruolo as nome_ruolo FROM dipendenti_ruoli;");
        while($r = mysqli_fetch_assoc($categorie)) {$rows[] = $r; }
        if(isset($rows)) echo json_encode($rows);
        else self::setSuccess("empty");
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
