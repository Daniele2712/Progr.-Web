<?php
namespace Models;
if(!defined("EXEC")){
    header("location: /index.php");
	return;
}

class UtenteRegistrato extends Utente{
    private $idRegistrato;
    private $punti;
    private $pagamenti = array();
    private $indirizzi = array();
    private $carrello;

    public function __construct($idUtente, $datiAnagrafici, $email, $username, int $idRegistrato=0, int $punti = 0, array $pagamenti=array(), array $indirizzi=array(), Carrello $carrello){
        parent::__construct($idUtente, $datiAnagrafici, $email, $username);
        $this->idRegistrato = $idRegistrato;
        $this->punti = $punti;
        foreach($pagamenti as $p){
            $this->pagamenti[] = clone $p;
        }
        foreach($indirizzi as $i){
            $this->indirizzi[] = clone $i;
        }
        $this->carrello = clone $carrello;
        $this->email = $email;
    }

    public function getIndirizzi(): array{
        $r = array();
        foreach($this->indirizzi as $i){
            $r[] = clone $i;
        }
        return $r;
    }
}
