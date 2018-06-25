<?php
if(!defined("EXEC")){
    header("location: /index.php");
	return;
}

class VError implements View{
    private $rest = false;
    private $message = array("errorn"=>0, "error"=>"");
    private $commonErrors = array(404 => "File Not Found", 405 => "Method Not Allowed");

    public function isRest(bool $rest){
        $this->rest = $rest;
    }

    public function error(int $n, $error=null){
        $this->message["errorn"] = $n;
        if($error === null && array_key_exists($this->commonErrors, $n))
            $this->message["error"] = $this->commonErrors($n);
        elseif($error != null)
            $this->message["error"] = $error;
        $this->render();
    }

    public function render(){
        header('HTTP/1.1 '.$this->message["errorn"].' '.$this->message["error"]);
        if($this->rest){
            echo json_encode($this->message);
        }else{
            $smarty = Singleton::Smarty();
            $smarty->assign("content","error/message.tpl");
            $smarty->assign("message",$this->message);
            $smarty->display("layout.tpl");
        }
    }
}
