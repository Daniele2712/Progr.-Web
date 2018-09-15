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
