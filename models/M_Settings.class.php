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
        if(!isset($this->settings["background"]) || !is_numeric($this->settings["background"]))
            throw new \ModelException("Background Not Found", __CLASS__, array("v"=>$this->settings["background"]),2);
        return $this->settings["background"];
    }

    public function getFavicon():int{
        if(!isset($this->settings["favicon"]) || !is_numeric($this->settings["favicon"]))
            throw new \ModelException("Favicon Not Found", __CLASS__, array("v"=>$this->settings["favicon"]),3);
        return $this->settings["favicon"];
    }

    public function getPaypalEmail():string{
        if(!isset($this->settings["paypal_email"]) || !is_string($this->settings["paypal_email"]) || $this->settings["paypal_email"] == '')
            throw new \ModelException("PayPal Email Not Found", __CLASS__, array("v"=>$this->settings["paypal_email"]),4);
        return $this->settings["paypal_email"];
    }

    public function getPaypalSandbox():bool{
        if(!isset($this->settings["paypal_sandbox"]))
            return false;
        return $this->settings["paypal_sandbox"];
    }

    public function getMaxShippingDistance():float{
        if(!isset($this->settings["max_shipping_distance"]))
            return 5;
        return $this->settings["max_shipping_distance"];
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
