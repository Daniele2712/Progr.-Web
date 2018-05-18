<?php
if(!defined("EXEC")){
    header("location: /index.php");
	return;
}
//  chi e che crea l-ordine, e chi se se lo ricorda??? il cestino?? il cliente??


class EOrdine{
    private $prodotti= array();
    private $metodoPagamento;
    private $indirizzo;

    public function __construct(array $prodotti,string $metodoPagamento, string $indirizzo){
    	$this->prodotti =  $prodotti;
        $this->metodoPagamento = $metodoPagamento;
        $this->indirizzo = $indirizzo;
    }
}
