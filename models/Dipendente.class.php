<?php
namespace Models;
if(!defined("EXEC")){
    header("location: /index.php");
	return;
}

class Dipendente extends Utente{
    private $ruolo;
    private $tipoContratto;
    private $dataAssunzione;
    private $oreSettimanali;
    private $stipendioOrario;
    private $turni;

    public function __construct($idUtente, $datiAnagrafici, $email, $username, int $id = 0, string $ruolo = '', string $tipoContratto = '', \DateTime $dataAssunzione = NULL, int $oreSettimanali = 0, Money $stipendioOrario = NULL, array $turni = array()){
        if($dataAssunzione === NULL)
            $dataAssunzione = new \DateTime();
        if($stipendioOrario === NULL)
            $stipendioOrario = new Money(0,'EUR');
        parent::__construct($idUtente, $datiAnagrafici, $email, $username);
        $this->id = $id;
        $this->ruolo = $ruolo;
        $this->tipoContratto = $tipoContratto;
        $this->dataAssunzione = $dataAssunzione;
        $this->oreSettimanali = $oreSettimanali;
        $this->stipendioOrario = $stipendioOrario;
        foreach($turni as $t){
            $this->turni[] = clone $t;
        }
    }

    //TODO: completare la classe

    public function removeFromMagazzino(){}

    public function removeTurni(){}

    public function addToMagazzino(int $idMagazzino){}

    public function addTurno(Turno $turno){}

    public function editTurno(int $idTurno, Turno $turno):int{
        $bool=true;
        foreach($this->turni as $t){
            if($t->getId() == $idTurno){
                $t = clone $turno;
                $bool=false;
            }
        }
        if(TRUE){
            return 1;
        }
        else {
            return 0;
        }
    }

    public function removeTurno(int $idTurno){}
}
