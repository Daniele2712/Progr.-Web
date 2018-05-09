<?php
if(!defined("EXEC"))
	return;

class EUtenteRegistrato extends EUtente{
    private $pagamenti = array();
    private $indirizzi = array();
    private $carrelli = array();
    private $email;

    public function __construct($nome, $cognome, $telefono, $nascita, array $pagamenti=array(), array $indirizzi=array(), array $carrelli=array(), string $email=""){

        parent::__construct($nome, $cognome, $telefono, $nascita);
        foreach ($pagamenti as $p){
            $this->pagamenti[] = clone $p;
        }
        foreach ($indirizzi as $i){
            $this->indirizzi[] = clone $i;
        }
        foreach ($carrelli as $c){
            $this->carrelli[] = clone $c;
        }
        $this->email = $email;
    }
}
