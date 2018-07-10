<?php
namespace Models;
if(!defined("EXEC")){
    header("location: /index.php");
	return;
}

class Gestore extends Utente{
    private $idGestore;

    public function __construct($idUtente, $datiAnagrafici, $email, $username, int $idGestore=0){
        parent::__construct($idUtente, $datiAnagrafici, $email, $username);
        $this->idGestore = $idGestore;
    }
}
