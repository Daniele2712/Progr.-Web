<?php
if(!defined("EXEC")){
    header("location: /index.php");
	return;
}

class Cshop{
    public function home($req){
        echo "home";
    }

}
