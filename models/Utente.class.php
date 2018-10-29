<?php
namespace Models;
if(!defined("EXEC")){
    header("location: /index.php");
	return;
}

abstract class Utente extends Model{
    //private $idUtente;    non penso seva idUtente in quanto c-e gia l'attributo id del modello, e useremo quello
    private $email;
    private $username;
    private $datiAnagrafici;
    private $idValuta;

    public function __construct(int $id, DatiAnagrafici $datiAnagrafici, string $email="", string $username="", int $idValuta = NULL){
        $this->datiAnagrafici = clone $datiAnagrafici;
        $this->id = $id;
        $this->email = $email;
        $this->username = $username;
        if($idValuta === NULL)
            $idValuta = Money::EUR();
        $this->idValuta = $idValuta;
    }


    public function getUsername(){
        return $this->username;
    }
    
    public function getDatiAnagrafici() : \Models\DatiAnagrafici{
        return $this->datiAnagrafici;
    }
    

    public function getIdValuta(): int{
        return $this->idValuta;
    }
}
