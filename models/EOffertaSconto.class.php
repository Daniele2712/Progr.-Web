<?php
if(!defined("EXEC")){
    header("location: /index.php");
	return;
}

class EOffertaSconto extends EOfferta{
	//Attributi
    protected $id;
    protected $idProdotto;
    protected $prezzo;
    protected $valuta;

    //Costruttori
    public function __construct(int $idOfferta, string $tipo, DateTime $data_inizio, DateTime $data_fine, int $id, int $idProdotto, float $prezzo, string $valuta){
        parent::__construct($idOfferta, $tipo, $data_inizio, $data_fine);
        $this->id = $id;
        $this->idProdotto = $idProdotto;
        $this->prezzo = $prezzo;
        $this->valuta = $valuta;
    }
	//Metodi
	public function VerificaOfferte(array &$items){

	}
}
