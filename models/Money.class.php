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
	//Costruttore
	public function __construct(float $pre, int $val){
		$this->prezzo = $pre;
		$this->idValuta = $val;
        self::loadValute();
	}
	//Metodi
	public function setPrezzo(float $pre){
		$this->prezzo = $pre;
	}

	public function setValuta(int $val){
		$this->idValuta = $val;
	}

	public function getPrezzo(int $idValuta = NULL):float{
        if($idValuta === NULL || $this->idValuta === $idValuta)
		    return $this->prezzo;
        else
            return round($this->prezzo * \Foundations\Valuta::exchangeRate(self::findValutaCode($this->idValuta), self::findValutaCode($idValuta)),2);
	}

	public function getValuta():int{
		return $this->idValuta;
	}

    public function getValutaCode():string{
        if(!isset(self::$valute[$this->idValuta]))
            new \ModelException("Data Not Found", __CLASS__, array("id_valuta"=>$this->idValuta),1);
        return self::$valute[$this->idValuta][1];
    }

    public function getValutaName():string{
        if(!isset(self::$valute[$this->idValuta]))
            new \ModelException("Data Not Found", __CLASS__, array("id_valuta"=>$this->idValuta),1);
        return self::$valute[$this->idValuta][2];
    }

    public function getValutaSymbol():string{
        if(!isset(self::$valute[$this->idValuta]))
            new \ModelException("Data Not Found", __CLASS__, array("id_valuta"=>$this->idValuta),1);
        return self::$valute[$this->idValuta][3];
    }

    public static function findValutaCode(int $id): string{
        if(!isset(self::$valute[$id]))
            new \ModelException("Data Not Found", __CLASS__, array("id_valuta"=>$id),1);
        return self::$valute[$id][1];
    }

    public static function findValutaName(int $id): string{
        if(!isset(self::$valute[$id]))
            new \ModelException("Data Not Found", __CLASS__, array("id_valuta"=>$id),1);
        return self::$valute[$id][2];
    }

    public static function findValutaSymbol(int $id): string{
        if(!isset(self::$valute[$id]))
            new \ModelException("Data Not Found", __CLASS__, array("id_valuta"=>$id),1);
        return self::$valute[$id][3];
    }

    public static function EUR():int{
        self::loadValute();
        foreach(self::$valute as $valuta){
            if($valuta[1]==="EUR")
                return $valuta[0];
        }
        throw new \ModelException("Data Not Found", __CLASS__, array("valuta_name"=>"EUR"),1);

    }

    private static function loadValute(){
        if(empty(self::$valute))
            self::$valute = \Foundations\Valuta::all();
    }
}
