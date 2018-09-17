<?php
namespace Views;
if(!defined("EXEC")){
    header("location: /index.php");
	return;
}

/**
 * View che stampa dei dati in JSON
 */
class JSONView implements View{

    /**
     * variabile contenente i dati da stampare
     *
     * @var    mixed
     */
    protected $data;

    /**
     * costruttore che setta la variabile data con i dati passati, se presenti
     *
     * @param    mixed    $data    dati in input
     */
    public function __construct($data = NULL){
        if($data !== NULL)
            $this->data = $data;
    }

    /**
     * metodo per stampare i dati con codifica JSON
     */
    public function render(){
        echo json_encode($this->data);
    }
}
