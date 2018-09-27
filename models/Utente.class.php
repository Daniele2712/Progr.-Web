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
    private $idValuta;

    public function __construct(int $idUtente, DatiAnagrafici $datiAnagrafici, string $email="", string $username="", int $idValuta = NULL){
        $this->datiAnagrafici = clone $datiAnagrafici;
        $this->idUtente = $idUtente;
        $this->email = $email;
        $this->username = $username;
        if($idValuta === NULL)
            $idValuta = Money::EUR();
        $this->idValuta = $idValuta;
    }


    public function getUsername(){
        return $this->username;
    }

    public function getId(): int{
        return $this->idUtente;
    }

    public function getIdValuta(): int{
        return $this->idValuta;
    }
}
