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

	public function getPrezzo(\Models\Money $valuta = NULL):float{
        if($valuta === NULL || $this->idValuta === $valuta->idValuta)
		    return $this->prezzo;
        else
            return round($this->prezzo * \Foundations\Valuta::exchangeRate(self::findValutaCode($this->idValuta), $valuta->getValutaCode()), 2);
	}

	public function getValuta():int{
		return $this->idValuta;
	}

    public function getValutaCode():string{
        $valuta = self::findValuta($this->idValuta);
        if(empty($valuta))
            new \ModelException("Data Not Found", __CLASS__, array("id_valuta"=>$this->idValuta),1);
        return self::$valute[$this->idValuta][1];
    }

    public function getValutaName():string{
        $valuta = self::findValuta($this->idValuta);
        if(empty($valuta))
            new \ModelException("Data Not Found", __CLASS__, array("id_valuta"=>$this->idValuta),1);
        return self::$valute[$this->idValuta][2];
    }

    public function getValutaSymbol():string{
        $valuta = self::findValuta($this->idValuta);
        if(empty($valuta))
            new \ModelException("Data Not Found", __CLASS__, array("id_valuta"=>$this->idValuta),1);
        return $valuta[3];
    }

    public static function findValuta(int $id):array{
        foreach(self::$valute as $valuta){
            if($valuta[0] == $id)
                return $valuta;
        }
        return array();
    }

    public static function findValutaCode(int $id): string{
        $valuta = self::findValuta($id);
        if(empty($valuta))
            new \ModelException("Data Not Found", __CLASS__, array("id_valuta"=>$id),1);
        return $valuta[1];
    }

    public static function findValutaName(int $id): string{
        $valuta = self::findValuta($id);
        if(empty($valuta))
            new \ModelException("Data Not Found", __CLASS__, array("id_valuta"=>$id),1);
        return $valuta[2];
    }

    public static function findValutaSymbol(int $id): string{
        $valuta = self::findValuta($id);
            var_dump($valuta);
        if(empty($valuta))
            new \ModelException("Data Not Found", __CLASS__, array("id_valuta"=>$id),1);
        return $valuta[3];
    }

    public static function EUR(): Money{
        self::loadValute();
        foreach(self::$valute as $valuta){
            if($valuta[1]==="EUR")
                return new Money(0, $valuta[0]);
        }
        throw new \ModelException("Data Not Found", __CLASS__, array("valuta_name"=>"EUR"),1);

    }

    private static function loadValute(){
        if(empty(self::$valute))
            self::$valute = \Foundations\Valuta::all();
    }
}
