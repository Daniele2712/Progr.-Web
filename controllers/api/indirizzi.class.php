<?php
namespace Controllers\Api;
use \Controllers\Controller as Controller;
use \Views\Request as Request;
if(!defined("EXEC")){
    header("location: /index.php");
	return;
}

class indirizzi implements Controller{

    public static function get(Request $req){
        header('Content-type: application/json');
        $params=$req->getOtherParams();

        if(in_array("all",$params))
        {
            /*
                Le funzioni GetMagazziniOfAmministratore e getMagazziniOfDipendenteWithId restituiscono un array con i seguenti campi

             * id_magazzino
             * CAP_magazzino
             * nome_citta_magazzino
             * provincia_magazzino
             * via_magazzino
             * civico_magazzino

            */
            $session = \Singleton::Session();
            if(!$session->isLogged())       //se NON e' loggato
                {
                $v = new \Views\JSONView(array("r"=>403,"message"=>"Access denied. You have to be logged in."));
                $v->render();
                }
            else{   //vuol dire che e' loggato
                    $ruolo=$session->getRuoloOfLoggedUser();
                    if($ruolo=="Amministratore")
                    {
                        $magazzini = \Foundations\Dipendente::getMagazziniOfAmministratore();
                        $numero_magazzini= sizeof($magazzini);
                        if($numero_magazzini>0)
                        {
                        $v = new \Views\JSONView(array("r" => 200, "numero_magazzini"=>$numero_magazzini,"magazzini" => $magazzini));
                        $v->render();
                        }
                        else
                        {
                        self::setSuccess("empty");
                        }
                    }
                    elseif($ruolo=="Gestore")
                    {
                        $idGestore=$session->getUser()->getId();
                        $magazzini = \Foundations\Dipendente::getMagazziniOfDipendenteWithId($idGestore);
                        $numero_magazzini= sizeof($magazzini);
                        if($numero_magazzini>0)
                            {
                            $v = new \Views\JSONView(array("r" => 200, "numero_magazzini"=>$numero_magazzini,"magazzini" => $magazzini));
                            $v->render();
                            }
                        else
                        {
                            self::setSuccess("empty");
                        }
                    }
                    elseif($ruolo=="UtenteRegistrato")
                    {
                        $v = new \Views\JSONView(array("r"=>403, "message"=>"You don't have enough privileges. You are a normal user."));
                        $v->render();
                    }
                    else
                    {
                     $v = new \Views\JSONView(array("r"=>403, "message"=>"Vuol dire che non sei ne Gestore ne Amministratore e che nonostante cio hai passato il controllo..non so come"));
                     $v->render();
                    }
                }
            }
            else
            {
                $v = new \Views\JSONView(array("r"=>403,"message"=>"You have to add some parameters to the URL."));
                $v->render();
            }
    }

    public static function post(Request $req){
    }

    public static function default(Request $req){
        self::get($req);
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
