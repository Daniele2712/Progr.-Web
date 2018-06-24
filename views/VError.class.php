<?php
if(!defined("EXEC")){
    header("location: /index.php");
	return;
}

class VError implements View{
    private $rest = false;
    private $errorn = 0;
    private $error = "";
    private $commonErrors = array(404 => "File Not Found", 405 => "Method Not Allowed");

    public function isRest(bool $rest){
        $this->rest = $rest;
    }

    public function error(int $n, $error=null){
        $this->errorn = $n;
        if($error === null && array_key_exists($this->commonErrors, $n))
            $this->error = $this->commonErrors($n);
        elseif($error != null)
            $this->error = $error;
        $this->render();
    }

    public function render(){
        header('HTTP/1.1 '.$this->errorn.' '.$this->error);
        if($this->rest){
            json_encode(array("r"=>$this->errorn, "error"=>$this->error));
        }else{
            $smarty = Singleton::Smarty();
            //$smarty->display("error.tpl");
            echo $this->errorn.'<br/>'.$this->error;
        }
    }
}
