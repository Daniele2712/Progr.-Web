<?php
namespace Views\Api;
use \Views\JSONView as JSONView;
if(!defined("EXEC")){
    header("location: /index.php");
	return;
}

class V_OrdinePaypal extends JSONView{

    public function setOrder(\Models\M_Ordine $order){
        $this->data["order"]=$order->getLink();
    }
}
