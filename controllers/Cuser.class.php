<?php
if(!defined("EXEC")){
    header("location: /index.php");
	return;
}


class Cuser{
    public function getIndirizzi($req){

        $v = new VHome();
        $v->render();
    }

    public function login($req){
        $user = $req->getString("username");
        $pw = $req->getString("password");
        $user = Singleton::Session()->login($user,$pw);
        echo "<pre>";
        print_r($user);
        echo "</pre>";
    }
}
