<?php
namespace Models;
if(!defined("EXEC")){
    header("location: /index.php");
	return;
}

class Comune extends Model{
    private $comune;
    private $CAP;
    private $provincia;

    public function __construct(int $id, string $comune="", int $CAP=0, string $provincia=""){
        $this->id = $id;
        $this->comune = $comune;
        $this->CAP = $CAP;
        $this->provincia = $provincia;
    }
}
