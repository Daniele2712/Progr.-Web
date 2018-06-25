<?php
if(!defined("EXEC")){
    header("location: /index.php");
	return;
}

class VHome extends HTMLView{
    protected $layout = "index";

    public function HTMLRender(){
    }
}
