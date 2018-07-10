<?php
namespace Models;
if(!defined("EXEC")){
    header("location: /index.php");
	return;
}

class Indirizzo extends Model{
    private $comune;
    private $via;
    private $civico;
    private $note;

    public function __construct(int $id, Comune $comune=null, string $via="", int $civico=0, string $note=""){
        $this->id = $id;
        if($comune === null)
            $this->comune = new Comune();
        else
            $this->comune = clone $comune;
        $this->via = $via;
        $this->civico = $civico;
        $this->note = $note;
    }

    public function __clone(){
        $this->comune = clone $this->comune;
    }

    public function getComune():\Models\Comune{
        return clone $this->comune;
    }

    public function getVia():string{
        return $this->via;
    }

    public function getCivico():int{
        return $this->civico;
    }

    public function getNote():string{
        return $this->note;
    }
}
