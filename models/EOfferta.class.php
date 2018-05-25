<?php
if(!defined("EXEC")){
    header("location: /index.php");
	return;
}

class EOfferta{
	//Attributi
	//Costruttori
	//Metodi
	public static function VerificaOfferte(array $items){
		VerificaSconti($items);
	}
	private static function VerificaSconti(array $items){
		//for ($i=0;$i<$this->$items.size();$i++){
			//$t=$items[i];
    //}
	}
}
