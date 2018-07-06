<?php
namespace Models;
if(!defined("EXEC")){
    header("location: /index.php");
	return;
}

class Gestore extends Utente{

    public function __construct($nome, $cognome, $telefono, $nascita){
        parent::__construct($nome, $cognome, $telefono, $nascita);
    }
}
