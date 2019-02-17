<?php
namespace Controllers;
use \Views\Request as Request;
if(!defined("EXEC")){
    header("location: /index.php");
	return;
}

class User implements Controller{
    public static function getIndirizzi(Request $req){ 
        $sessione = \Singleton::Session();
        if(!$sessione->isLogged()){
            echo "non loggato";
            die();
        }
        $user = $sessione->getUser();
        if(get_class($user)==="Models\\UtenteRegistrato"){
            echo "<pre>";
            print_r($user->getIndirizzi());
            echo "</pre>";
        }
        //$v = new VHome();
        //$v->render();
    }

    public static function login(Request $req){
        $username = $req->getString("username",NULL,"POST");
        $pw = $req->getString("password",NULL,"POST");
        $session = \Singleton::Session();
        $tmp = array("r"=>404);
        try{
            /*  controllare se si tratta di un gestore o di un utente */
            $idUser=$session->login($username,$pw);
            $tmp["r"] = 200;
            $user = \Singleton::Session()->getUser();
            if(is_a($user,"\\Models\\Dipendente")) $tmp["type"]= $user->getRuolo();
            else  $tmp["type"] = "Cliente";   //forse si potrebbe aggiungere il caso in cui sia sottoclasse di utente registrato, e poi -lelse, dove e' utente/cliente
            (new \Views\JSONView($tmp))->render();
        }catch(\ModelException $e){             //utente non trovato
            (new \Views\JSONView($tmp))->render();
        }
    }

    public static function logout(Request $req){
        \Singleton::Session()->logout();
    }

    /*  da cancellare xke il controllore non deve fare le chiamate al DB
     * private function isGestore($id){
        $DB= \Singleton::DB();
        $querry= $DB->prepare("SELECT count(*) FROM utenti WHERE tipo_utente='Gestore' AND id=$id;");
        if(!$querry->execute())
            throw new \SQLException("Error Executing Statement", $sql, $p->error, 3);
        $querry->bind_result($num);
        $querry->fetch();
        if($num==0) return false;
        else return true;
    }*/

    public static function default(Request $req){
        return self::login($req);
    }


}
