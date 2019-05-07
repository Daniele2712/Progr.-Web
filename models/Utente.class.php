<?php
namespace Models;
if(!defined("EXEC")){
    header("location: /index.php");
	return;
}

abstract class Utente extends Model{
    private $email;
    private $username;
    private $datiAnagrafici;
    private $valuta;

    public function __construct(int $id, DatiAnagrafici $datiAnagrafici, string $email="", string $username="", int $valuta = NULL){
        $this->datiAnagrafici = clone $datiAnagrafici;
        $this->id = $id;
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

    public function getDatiAnagrafici() : \Models\DatiAnagrafici{
        return $this->datiAnagrafici;
    }

    public function getValuta(): Money{
        return clone $this->valuta;
    }

    public abstract function getRuolo();
}
