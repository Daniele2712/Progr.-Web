<?php
if(!defined("EXEC"))
	return;

class EIndirizzo{
    private $comune;
    private $via;
    private $civico;
    private $note;

    public function __construct(EComune $comune=null, string $via="", int $civico=0, string $note=""){
        $this->comune = clone $comune;
        $this->via = $via;
        $this->civico = $civico;
        $this->note = $note;
    }

    public function __clone(){
        $this->comune = clone $this->comune;
    }
}
