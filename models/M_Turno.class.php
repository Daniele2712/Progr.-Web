<?php
namespace Models;
if(!defined("EXEC")){
    header("location: /index.php");
	return;
}

class M_Turno extends Model{
    private $inizio;
    private $fine;
    private $giornoinizio;
    private $giornofine;

    public function __construct(int $id = 0, int $giornoinizio = 0, DateTime $inizio = new \DateTime(), int $giornofine = 0, M_DateTime $fine = new \DateTime()){
        $this->id = $id;
        $this->inizio = $inizio;
        $this->fine = $fine;
        $this->giornoinizio = $giornoinizio;
        $this->giornofine = $giornofine;
    }

    public function getId(){
        return $this->$id;
    }
}
