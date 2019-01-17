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
    private $valuta;

    public function __construct(int $idUtente, DatiAnagrafici $datiAnagrafici, string $email="", string $username="", int $valuta = NULL){
        $this->datiAnagrafici = clone $datiAnagrafici;
        $this->idUtente = $idUtente;
        $this->email = $email;
        $this->username = $username;
        if($valuta === NULL)
            $valuta = Money::EUR();
        else
            $valuta = new Money(0, $valuta);
        $this->valuta = $valuta;
    }


    public function getUsername(){
        return $this->username;
    }

    public function getId(): int{
        return $this->idUtente;
    }

    public function getValuta(): Money{
        return clone $this->valuta;
    }
}
