<?php
namespace Controllers;
use \Views\Request as Request;
if(!defined("EXEC")){
    header("location: /index.php");
	return;
}

/**
 * Interfaccia controller, implementata da tutti i controller
 */
interface Controller{
    /**
     * azione di default del controller
     */
    public function default(Request $req);
}
