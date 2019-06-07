<?php
namespace Models;
if(!defined("EXEC")){
    header("location: /index.php");
	return;
}

abstract class M_Utente extends Model{
    private $datiAnagrafici;
    private $username;
    private $email;
    private $idValuta;

    public function __construct(int $idUtente, M_DatiAnagrafici $datiAnagrafici, string $email="", string $username="", $idValuta = NULL){
        $this->datiAnagrafici = clone $datiAnagrafici;
        $this->id = $idUtente;
        $this->email = $email;
        $this->username = $username;
        if($idValuta==NULL) $this->idValuta=\Foundations\F_Valuta::getDefaultId();
        else $this->idValuta = $idValuta;
    }

    public function getUtenteId(){return $this->id;}  /*  fa la stessa cosa di getId, che viene ereditata, ma e' piu chiaro il significato, contrapposto a getDipendenteId*/
    public function getDatiAnagrafici() : M_DatiAnagrafici{return clone $this->datiAnagrafici;}
    public function getUsername(){ return $this->username; }
    public function getEmail(){return $this->email;}
    public function getIdValuta(): int{return $this->idValuta;}
    public abstract function getRuolo();

    public function setUtenteId($idUtente){$this->id=$idUtente;} /*  fa la stessa cosa di setId */
    public function setDatiAnagrafici($datiAna){$this->datiAnagrafici=$datiAna;}
    public function setUsername($username){ $this->username=$username;}
    public function setEmail($email){$this->email=$email;}
    public function setIdValuta($idVal){ $this->idValuta=$idVal;}


}
