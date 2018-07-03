<?php
if(!defined("EXEC")){
    header("location: /index.php");
	return;
}

abstract class EUtente{
    private $idUtente;
    private $email;
    private $username;
    private $datiAnagrafici;

    public function __construct(int $idUtente, EDatiAnagrafici $datiAnagrafici, string $email="", string $username=""){
        $this->datiAnagrafici = clone $datiAnagrafici;
        $this->idUtente = $idUtente;
        $this->email = $email;
        $this->username = $username;
    }
}
