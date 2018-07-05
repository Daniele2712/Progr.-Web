<?php
if(!defined("EXEC")){
    header("location: /index.php");
	return;
}

class EUtenteRegistrato extends EUtente{
    private $idRegistrato;
    private $punti;
    private $pagamenti = array();
    private $indirizzi = array();
    private $carrello;

    public function __construct($idUtente, $datiAnagrafici, $email, $username, int $idRegistrato=0, int $punti = 0, array $pagamenti=array(), array $indirizzi=array(), ECarrello $carrello){
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
}
