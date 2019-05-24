<?php
namespace Models;
if(!defined("EXEC")){
    header("location: /index.php");
	return;
}

class M_DatiAnagrafici extends Model{
    //  private $idDatiAnagrafici;      A:penso non serva ilDatiAnagrafici xke c'e gia l'id ereditato dal Model
    private $nome;
    private $cognome;
    private $telefono;
    private $dataNascita;

    public function __construct(int $id=0, string $nome="", string $cognome="", string $telefono="", \DateTime $nascita = null){
        $this->setId($id);
        $this->nome = $nome;
        $this->cognome = $cognome;
        $this->telefono = $telefono;
        if($nascita === null)
            $this->dataNascita = new \DateTime();
        else
            $this->dataNascita = clone $nascita;
    }

    public function getNome(){return $this->nome;}
    public function getCognome(){return $this->cognome;}
    public function getTelefono(){return $this->telefono;}
    public function getDataNascita(){return clone $this->dataNascita;}

    public function setNome($n){$this->nome=$n;}
    public function setCognome($c){$this->cognome=$c;}
    public function setTelefono($t){$this->telefono=$t;}
    public function setDataNascita($d){$this->dataNascita = clone $d;}
}
