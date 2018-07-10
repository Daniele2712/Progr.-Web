<?php
namespace Models;
if(!defined("EXEC")){
    header("location: /index.php");
	return;
}

//  chi e' che crea l-ordine, e chi se se lo ricorda??? il cestino?? il cliente??


interface MetodoPagamento extends Model{

    private $valuta = "euro";


    public function paga();
    public function sceglivaluta();

}
