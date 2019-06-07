<?php
namespace Controllers;
use \Views\Request as Request;
if(!defined("EXEC")){
    header("location: /index.php");
	return;
}

class C_shop{
    public static function home(Request $req){
        $v = new \Views\V_Home();
        $v->render();
    }

    public static function gestore(Request $req){

         $session = \Singleton::Session();
            if($session->isLogged())            //nel caso l-utente abbia digitato direttamente l-indirizzo senza essersi loggato, lo mando alla home
            {
              if($session->getUser()->getRuolo()=='Gestore')
              {
                \Foundations\Log::logMessage("Gestore(id:".$session->getUser()->getId().") logged",$req);
                $v = new \Views\V_Gestore();
                $v->setUser();
                $v->render();

              }
              else
              {
                \Foundations\Log::logMessage("!Privilege Escalation Attempt! Loged User(id:".$session->getUser()->getId().") tried to access Gestore Page!",$req);
                var_dump($req->getServerName());
                header('Location: '."http://".$req->getServerName());
              }
            }
            else
            {
              header('Location: '."http://".$req->getServerName());
              \Foundations\Log::logMessage("!Privilege Escalation Attempt! Non Logged User tried to access Gestore Page!",$req);
            }
    }

    public static function amministratore(Request $req){

         $session = \Singleton::Session();
            if($session->isLogged())            //nel caso l-utente abbia digitato direttamente l-indirizzo senza essersi loggato, lo mando alla home
            {
              if($session->getUser()->getRuolo()=='Amministratore')
              {
                \Foundations\Log::logMessage("Administrator(id:".$session->getUser()->getId().") logged",$req);
                $v = new \Views\V_Amministratore();
                $v->setUser();
                $v->render();
              }
              else
              {
                \Foundations\Log::logMessage("!Privilege Escalation Attempt! Loged User(id:".$session->getUser()->getId().") tried to access Admin Page!",$req);
                header('Location: '."http://".$req->getServerName());
              }
            }
            else
            {
              header('Location: '."http://".$req->getServerName());
              \Foundations\Log::logMessage("!Privilege Escalation Attempt! Non Logged User tried to access Admin Page!",$req);
            }
    }


    public static function default(Request $req){
        return self::home($req);
    }
}
