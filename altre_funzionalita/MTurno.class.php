<?php
namespace Models;
if(!defined("EXEC")){
    header("location: /index.php");
	return;
}

class Turno extends Models{
    private $inizio;
    private $fine;

    public function __construct(DateTime $inizio = new DateTime(), DateTime $fine = new DateTime()){
        $this->inizio = $inizio;
        $this->fine = $fine;
    }
}
