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
}
