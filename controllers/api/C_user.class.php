<?php

namespace Controllers\Api;

use \Controllers\Controller as Controller;
use \Controllers\Error as Error;
use \Views\Request as Request;

if (!defined("EXEC")) {
    header("location: /index.php");
    return;
}

class C_user implements Controller {

    public static function get(Request $req) {
        $p = $req->getParam(0);
        if ($p === "addresses") {
            return self::addresses($req);
        } elseif ($p === "indirizziMagazzini") {
            self::indirizziMagazzini($req);
        } else
            Error::Error400($request);
    }

    public static function post(Request $req){
        $cmd = $req->getString("cmd","","POST");
        switch($cmd){
            case "register":
                $nome = $req->getString("nome", "", "POST");
                $cognome = $req->getString("cognome", "", "POST");
                $email = $req->getString("email", "", "POST");
                $username = $req->getString("username", "", "POST");
                $password = $req->getString("password", "", "POST");
                $comuneId = $req->getInt("comuneId", 0, "POST");
                $via = $req->getString("via", "", "POST");
                $civico = $req->getString("civico", "", "POST");
                $note = $req->getString("note", "", "POST");
                \Models\Utenti\M_UtenteRegistrato::nuovo($nome, $cognome, $email, $username, $password, $comuneId, $via, $civico, $note);
                $v = new \Views\JSONView(array("r" => 200));
                return $v->render();
                break;
        }
        $v = new \Views\JSONView(array("r" => 404));
        return $v->render();
    }

    public static function default(Request $req){
        self::get($req);
    }

    private static function addresses(Request $req) {
        $session = \Singleton::Session();
        if ($session->isLogged()) {
            $user = $session->getUser();
            if (is_a($user, "\\Models\\Utenti\\M_UtenteRegistrato")) {
                $v = new \Views\Api\V_IndirizziUtente(array("r" => 200));
                $v->setIndirizzi($user->getIndirizzi());
                $v->setIndirizzoPreferito($user->getIndirizzoPreferito());
                $v->render();
            } else {
                $v = new \Views\JSONView(array("r" => 403));
                return $v->render();
            }
        } else {
            $v = new \Views\JSONView(array("r" => 403));
            return $v->render();
        }
    }



}
