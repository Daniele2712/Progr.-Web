<?php
if(!defined("EXEC")){
    header("location: /index.php");
	return;
}

class EGestore extends EUtente{

    public function __construct($nome, $cognome, $telefono, $nascita){
        parent::__construct($nome, $cognome, $telefono, $nascita);
    }
}
