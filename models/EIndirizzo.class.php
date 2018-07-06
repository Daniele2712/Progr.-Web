<?php
if(!defined("EXEC")){
    header("location: /index.php");
	return;
}

class EIndirizzo extends Entity{
    private $id;
    private $comune;
    private $via;
    private $civico;
    private $note;

    public function __construct(int $id, EComune $comune=null, string $via="", int $civico=0, string $note=""){
        $this->id = $id;
        if($comune === null)
            $this->comune = new EComune();
        else
            $this->comune = clone $comune;
        $this->via = $via;
        $this->civico = $civico;
        $this->note = $note;
    }

    public function __clone(){
        $this->comune = clone $this->comune;
    }
}
