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
      if(!isset($this->settings["background"]) && !is_numeric($this->settings["background"]))
        throw new \ModelException("Background not found", __CLASS__ , array("v"=>$this->settings["background"]),2);
        return $this->settings["background"];
    }

    public function getFavicon():int {
      if(!isset($this->settings["favicon"]))
        throw new \ModelException("Favicon not found", __CLASS__ , array(),3);
      elseif(!is_numeric($this->settings["favicon"]))
        throw new \ModelException("Favicon not valid", __CLASS__ , array("v"=>$this->settings["favicon"]),3);
      return $this->settings["favicon"];
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
