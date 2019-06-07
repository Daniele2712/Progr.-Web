<?php
namespace Models;
if(!defined("EXEC")){
    header("location: /index.php");
	return;
}

class M_Money extends Model{
	//Attributi
	private $prezzo = 0.0;
	private $idValuta = 1;
    private static $valute = array();
	//Costruttore
	public function __construct(float $pre, int $idVal){
		$this->prezzo = $pre;
		$this->idValuta = $idVal;
        self::loadValute();
	}
	//Metodi
	public function setPrezzo(float $pre){
		$this->prezzo = $pre;
	}

	public function setValuta(int $val){
		$this->idValuta = $val;
	}

	public function getPrezzo(\Models\M_Money $valuta = NULL):float{
        if($valuta === NULL || $this->idValuta === $valuta->idValuta)
		    return $this->prezzo;
        else
            return round($this->prezzo * \Foundations\F_Valuta::exchangeRate(self::findValutaCode($this->idValuta), $valuta->getValutaCode()), 2);
	}

	public function getValuta():int{                //nome improprio, si dovrebbe chiamare getIdValuta, ma ormai abbiamo scritto tanto codice con questa funzione, sa le vambiamo nome dovremmo cambiare il codice dapertutto
		return $this->idValuta;
	}

    public function getValutaCode():string{
        return self::findValutaCode($this->idValuta);
    }

    public function getValutaName():string{
        return self::findValutaName($this->idValuta);
    }

    public function getValutaSymbol():string{
        return self::findValutaSymbol($this->idValuta);
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
            new \ModelException("Valuta Code Not Found", __CLASS__, array("id_valuta"=>$id),1);
        return $valuta[1];
    }

    public static function findValutaName(int $id): string{
        $valuta = self::findValuta($id);
        if(empty($valuta))
            new \ModelException("Valuta Name Not Found", __CLASS__, array("id_valuta"=>$id),1);
        return $valuta[2];
    }

    public static function findValutaSymbol(int $id): string{
        $valuta = self::findValuta($id);
        if(empty($valuta))
            new \ModelException("Valuta Symbol Found", __CLASS__, array("id_valuta"=>$id),1);
        return $valuta[3];
    }

    public static function EUR(): M_Money{
        self::loadValute();
        foreach(self::$valute as $valuta){
            if($valuta[1]==="EUR")
                return new M_Money(0, $valuta[0]);
        }
        throw new \ModelException("Data Not Found", __CLASS__, array("valuta_name"=>"EUR"),1);

    }

    private static function loadValute(){
        if(empty(self::$valute))
            self::$valute = \Foundations\F_Valuta::all();
    }

    public static function add(\Models\M_Money $a, \Models\M_Money $b, $idValuta){
       $prezzo=$a->getPrezzo($idValuta)+$b->getPrezzo($idValuta);
       return new \Models\M_Money($prezzo, $idValuta);
    }

}
