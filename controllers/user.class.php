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

        $user = $req->getString("username", NULL, "POST");
        $pw = $req->getString("password", NULL, "POST");
        try{
            /*  controllare se si tratta di un gestore o di un utente */
            \Singleton::Session()->login($user,$pw);
            $user = \Singleton::Session()->getUser();   /* questo e' un MODELS Utente, quindi ha la funzione getId()*/

            if(self::isGestore($user->getId())) header('Location: '. '../shop/gestore');
                    else header('Location: '."../shop/spesaConLogin");

        }catch(\ModelException $e){         // c-e errore con questo model, che cosa e??
            \Singleton::Session()->logout();
            echo "<pre>";
            echo str_replace("\n", "<br>", $e);
            echo "</pre>";
        }
    }

    public static function login2(Request $req){
        $user = $req->getString("username",NULL,"POST");
        $pw = $req->getString("password",NULL,"POST");
        $session = \Singleton::Session();
        $tmp = array("r"=>404);
        try{
            /*  controllare se si tratta di un gestore o di un utente */
            $session->login($user,$pw);
            $tmp["r"] = 200;
            $user = \Singleton::Session()->getUser();
            if(is_subclass_of($user,"\\Models\\Dipendente"))
                $tmp["type"] = "dipendente";
            else
                $tmp["type"] = "cliente";
            (new \Views\JSONView($tmp))->render();
        }catch(\ModelException $e){             //utente non trovato
            /*$v = new \Views\Error;            //Non so se inviare un json con scritto 404 o una pagina d'errore 404
            $v->isRest(TRUE);
            $v->error(404);*/
            (new \Views\JSONView($tmp))->render();
        }
    }

    public static function logout(Request $req){
        \Singleton::Session()->logout();
        echo "logged out";
    }

    private function isGestore($id){
        $DB= \Singleton::DB();
        $querry= $DB->prepare("SELECT count(*) FROM utenti WHERE tipo_utente='Gestore' AND id=$id;");
        if(!$querry->execute())
            throw new \SQLException("Error Executing Statement", $sql, $p->error, 3);
        $querry->bind_result($num);
        $querry->fetch();
        if($num==0) return false;
        else return true;
    }

    public static function default(Request $req){
        return self::login($req);
    }


}
