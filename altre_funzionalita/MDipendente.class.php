<?php
namespace Models;
if(!defined("EXEC")){
    header("location: /index.php");
	return;
}

class Dipendente extends Utente{
    private $id;
    private $ruolo;
    private $tipoContratto;
    private $dataAssunzioni;
    private $oreSettimanali;
    private $stipendioOrario;
    private $turni;

    public function __construct($idUtente, $datiAnagrafici, $email, $username, int $id = 0, string $ruolo = '', string $tipoContratto = '', DateTime $dataAssunzioni = new DateTime(), int $oreSettimanali = 0, Money $stipendioOrario = new Money(0,'EUR'), array $turni = array()){
        parent::__construct($idUtente, $datiAnagrafici, $email, $username);
        $this->id = $id;
        $this->ruolo = $ruolo;
        $this->tipoContratto = $tipoContratto;
        $this->dataAssunzioni = $dataAssunzioni;
        $this->oreSettimanali = $oreSettimanali;
        $this->stipendioOrario = $stipendioOrario;
        foreach($turni as $t){
            $this->turni[] = clone $t;
        }
    }

    public function removeFromMagazzino(){}

    public function removeTurni()

    public function addToMagazzino(int $idMagazzino)

    public function addTurno(Turno $turno)

    public function editTurno(int $idTurno, Turno $turno):int{
        $bool=true;
        foreach($this->turni as $t){
            if($t->getId() == $idTurno){
                $t = clone $turno;
                $bool=false;
            }
        }
        if(bool){
            return 1;
        }
        else {
            return 0;
        }
    }

    public function removeTurno(int $idTurno)
}
