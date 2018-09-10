<?php
namespace Models;
if(!defined("EXEC")){
    header("location: /index.php");
	return;
}
class Consegna extends Model{
    //Attributi
    private $id;
    private $ordine;
    private $stato;
    private $coda;
    //Costruttori
    public function __construct(int $id = 0, Ordine $ordine, string $stato = '', int $coda = 0){
        $this->$id = $id;
        $this->$ordine = clone $ordine;
        $this->stato = $stato;
        $this->coda = $coda;
    }
    //Metodi
    public function getId(){return $this->id;}

    public function getOrdine(){return $this->ordine;}

    public function getStato(){return $this->stato;}

    public function getCoda(){return $this->coda;}

    public function setStato(string $sta){$this->stato = $sta;}

    public function nextCoda(){$this->coda = $this->coda-1;}
}
?>
