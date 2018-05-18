<?php
if(!defined("EXEC")){
    header("location: /index.php");
	return;
}

class EComune{
    private $comune;
    private $CAP;
    private $provincia;

    public function __construct(string $comune="", int $CAP=0, string $provincia=""){
        $this->comune = $comune;
        $this->CAP = $CAP;
        $this->provincia = $provincia;
    }
}
