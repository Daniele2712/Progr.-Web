<?php
namespace Views;
if(!defined("EXEC")){
    header("location: /index.php");
	return;
}

/**
 * interfaccia delle Views
 */
interface View{
    /**
     * metodo da richiamare per mostrare l'output
     */
    public function render();
}
