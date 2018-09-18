<?php
namespace Models;
if(!defined("EXEC")){
    header("location: /index.php");
	return;
}

class Money extends Model{
	//Attributi
	private $prezzo = 0.0;
	private $idValuta = 1;
    private static $valute = array();
	//Costruttori
	public function __construct(float $pre, int $val){
		$this->prezzo = $pre;
		$this->idValuta = $val;
        if(empty(self::$valute))
            self::$valute = \Foundations\Valuta::all();
	}
	//Metodi
	public function setPrezzo(float $pre){
		$this->prezzo = $pre;
	}

	public function setValuta(int $val){
		$this->idValuta = $val;
	}

	public function getPrezzo():float{
		return $this->prezzo;
	}

	public function getValuta():int{
		return $this->idValuta;
	}

    public function getValutaName():string{
        if(!isset(self::$valute[$this->idValuta]))
            new \ModelException("Data Not Found", __CLASS__, array("id_valuta"=>$this->idValuta),1);
        return self::$valute[$this->idValuta][0];
    }
}
