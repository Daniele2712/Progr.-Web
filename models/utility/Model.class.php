<?php
namespace Models;
if(!defined("EXEC")){
    header("location: /index.php");
	return;
}

/**
 * classe astratta dei Modelli
 */
abstract class Model{
    /**
     * id del Model
     * @var    int
     */
    protected $id;

    /**
     * funzione che restituisce l'id del Model
     *
     * @return    int    id del Model
     */
    public function getId(): int{
        return $this->id;
    }

    /**
     * funzione che setta l'id del Model
     *
     * @param    int    $id     id del Model
     */
    public function setId(int $id){
        $this->id = $id;
    }
}
