<?php
namespace Views;
if(!defined("EXEC")){
    header("location: /index.php");
	return;
}

class Home extends HTMLView{
    protected $layout = "layout";
    protected $content = "index";
}
