<?php

namespace Controllers\Api;

use \Controllers\Controller as Controller;
use \Views\Request as Request;

if (!defined("EXEC")) {
    header("location: /index.php");
    return;
}

class user implements Controller {

    public static function get(Request $req) {
        $p = $req->getParam(0);
        if ($p === "addresses") {
            return self::addresses($req);
        } elseif ($p === "indirizziMagazzini") {
            self::indirizziMagazzini($req);
        } else
            Error::Error400($request);
        }

        public static function default(Request $req){
        self::get($req);
    }

    private static function addresses(Request $req) {
        $session = \Singleton::Session();
        if ($session->isLogged()) {
            $user = $session->getUser();
            if (is_a($user, "\\Models\\UtenteRegistrato")) {
                $v = new \Views\Api\IndirizziUtente(array("r" => 200));
                $v->setIndirizzi($user->getIndirizzi());
                $v->setIndirizzoPreferito($user->getIndirizzoPreferito());
                $v->render();
            } else {
                $v = new \Views\JSONView(array("r" => 403));
                $v->render();
            }
        } else {
            $v = new \Views\JSONView(array("r" => 403));
            $v->render();
        }
    }

    private static function indirizziMagazzini(Request $req) {
        $session = \Singleton::Session();
        if ($session->isLogged()) {
            $user = $session->getUser();
            if (is_a($user, "\\Models\\Dipendente")){
                $ruolo = $user->getRuolo();
                if ($ruolo == 'Gestore') {
                    $userId = $user->getId();
                    $magazzini = \Foundations\Dipendente::getMagazziniOfDipendenteWithId($userId);
                    $numero_magazzini= sizeof($magazzini);
                    $v = new \Views\JSONView(array("r" => 200, "numero_magazzini"=>$numero_magazzini,"magazzini" => $magazzini));
                    $v->render();
                } elseif ($ruolo == "Amministratore") {
                    /*  vede tutti i magazzini e quindi non ha un indirizzo preciso....anzi...forse deve avere tutti gli id amgazzini e i rispetivi indirizzi,... */
                } else {
                    $v = new \Views\JSONView(array("r" => 403));
                    $v->render();
                }
            } else {
                $v = new \Views\JSONView(array("r" => 403));
                $v->render();
            }
        }
    }

}
