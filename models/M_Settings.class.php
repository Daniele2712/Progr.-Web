<?php
namespace Models;
if(!defined("EXEC")){
    header("location: /index.php");
	return;
}

class M_Settings extends Model{
    private $settings = array();

    public function __construct(){
        $data = \Foundations\F_Settings::loadAll();
        foreach($data as $i => $v)  // i e' l'indice della riga, v e' il valore, che e' a sua volta un array, con v[k] e v[v]
            $this->settings[$v["k"]] = $v["v"];
    }

    public function getSiteName():string{
        return $this->settings["title"];
    }

    public function getBackground():int{
        return $this->settings["background"];
    }

    public function getArray():array{
        $r = array();
        foreach($this->settings as $k => $v)
            $r[$k] = $v;
        return $r;
    }

    public function save(){
        \Foundations\F_Settings::store($this->getArray());
    }
}
