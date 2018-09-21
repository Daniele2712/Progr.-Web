<?php
namespace Models;
if(!defined("EXEC")){
    header("location: /index.php");
	return;
}

class Indirizzo extends Model{
    private static $earthRadius = 6371000;
    private $comune;
    private $via;
    private $civico;
    private $note;
    private $lat;
    private $lng;

    public function __construct(int $id, Comune $comune=null, string $via="", int $civico=0, string $note="", float $lat=NULL, float $lng=NULL){
        $this->id = $id;
        if($comune === null)
            $this->comune = new Comune();
        else
            $this->comune = clone $comune;
        $this->via = $via;
        $this->civico = $civico;
        $this->note = $note;
        $this->lat = $lat;
        $this->lng = $lng;
    }

    public function __clone(){
        $this->comune = clone $this->comune;
    }

    public function getComune():\Models\Comune{
        return clone $this->comune;
    }

    public function getVia():string{
        return $this->via;
    }

    public function getCivico():int{
        return $this->civico;
    }

    public function getNote():string{
        return $this->note;
    }

    public function getLat():string{
        if($this->lat === NULL)
            $this->findLatLng();
        return $this->lat;
    }

    public function getLng():string{
        if($this->lng === NULL)
            $this->findLatLng();
        return $this->lng;
    }

    public function distance(Indirizzo $addr): float{
        $latFrom = deg2rad($this->lat);
        $lngFrom = deg2rad($this->lng);
        $latTo = deg2rad($addr->lat);
        $lngTo = deg2rad($addr->lng);

        $latDelta = $latTo - $latFrom;
        $lngDelta = $lngTo - $lngFrom;

        $angle = 2 * asin(sqrt(pow(sin($latDelta / 2), 2) +
        cos($latFrom) * cos($latTo) * pow(sin($lngDelta / 2), 2)));
        return $angle * Indirizzo::$earthRadius;
    }

    private function findLatLng(){
        $url = "https://api.opencagedata.com/geocode/v1/json?q=".
            urlencode($this->getVia().", ".$this->getComune()->getCAP()." ".$this->getComune()->getNome()." ".$this->getComune()->getProvincia()).
            "&key=121976f451424d918af3287438ae26e5&language=it&pretty=1";
        $data = file_get_contents($url);
        $arr = json_decode($data, true);
        $f = FALSE;
        foreach($arr["results"] as $v){
            if(array_key_exists("geometry",$v)){
                $this->lat = $v["geometry"]["lat"];
                $this->lng = $v["geometry"]["lng"];
                $f = TRUE;
                break;
            }
        }
        if(!$f)
            throw new \ModelException("Address not found", __CLASS__, array("url"=>$url), 2);
    }
}
