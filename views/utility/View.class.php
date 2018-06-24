<?php
if(!defined("EXEC")){
    header("location: /index.php");
	return;
}

interface View{
    public function render();
}
