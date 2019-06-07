<?php
namespace Controllers\Api;
use \Controllers\Controller as Controller;
use \Views\Request as Request;
if(!defined("EXEC")){
    header("location: /index.php");
	return;
}

class C_contratti implements Controller{

    public static function get(Request $req){
        self::showContratti($req);
    }

    public static function default(Request $req){
        self::get($req);
    }

    private static function showContratti($req){
        $categorie=\Singleton::DB()->query("SELECT id as id_contratto, contratto as tipo_contratto FROM `dipendenti_contratti` ");
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
