<?php
namespace Models;
if(!defined("EXEC")){
    header("location: /index.php");
	return;
}

abstract class Utente extends Model{
    private $idUtente;
    private $email;
    private $username;
    private $datiAnagrafici;

    public function __construct(int $idUtente, DatiAnagrafici $datiAnagrafici, string $email="", string $username=""){
        $this->datiAnagrafici = clone $datiAnagrafici;
        $this->idUtente = $idUtente;
        $this->email = $email;
        $this->username = $username;
    }

    
    public function getUsername(){
        return $this->username;
    }
    
    public function getId(): int{
        return $this->idUtente;
    }
}
