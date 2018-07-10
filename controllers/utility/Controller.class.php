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
<<<<<<< HEAD
}
=======
}
>>>>>>> bdb7c65b1cb79b0a810bcd14e613228cb35ce8b3
