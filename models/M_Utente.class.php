<?php
namespace Models;
if(!defined("EXEC")){
    header("location: /index.php");
	return;
}

abstract class M_Utente extends Model{
    private $email;
    private $username;
    private $datiAnagrafici;
    private $valuta;

    public function __construct(int $id, M_DatiAnagrafici $datiAnagrafici, string $email="", string $username="", int $valuta = NULL){
        $this->datiAnagrafici = clone $datiAnagrafici;
        $this->id = $id;
        $this->email = $email;
        $this->username = $username;
        if($valuta === NULL)
            $valuta = M_Money::EUR();
        else
            $valuta = new M_Money(0, $valuta);
        $this->valuta = $valuta;
    }


    public function getUsername(){
        return $this->username;
    }

    public function getDatiAnagrafici() : M_DatiAnagrafici{
        return $this->datiAnagrafici;
    }

    public function getValuta(): M_Money{
        return clone $this->valuta;
    }

    public abstract function getRuolo();
}
