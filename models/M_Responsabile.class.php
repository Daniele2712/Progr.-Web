<?php
namespace Models;
if(!defined("EXEC")){
    header("location: /index.php");
	return;
}

class M_Responsabile extends Dipendente{
    private $idResponsabile;

    public function __construct($idUtente, $datiAnagrafici, $email, $username, int $idResponsabile=0){
        parent::__construct($idUtente, $datiAnagrafici, $email, $username);
        $this->idResponsabile = $idResponsabile;
    }
}
