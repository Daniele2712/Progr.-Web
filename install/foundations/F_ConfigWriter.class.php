<?php
namespace Install\Foundations;
use \Models\Model as Model;
use \Foundation\Foundation as Foundation;
if(!defined("EXEC")){
    header("location: /index.php");
	return;
}

class F_ConfigWriter extends Foundation{
    //TODO: questo deve creare il nuovo file di config
    //oltre a questa foundation ce ne vuole un altra che carica il Database


    //questo codice è di un mio progetto, può esserti utile a scrivere le variabili su file, adattalo

    /*

    function Save_Config($CONFIGS){
    	$str="<?php\nreturn ";
    	$str.=Write_Var($CONFIGS,"\t");
    	$str=rtrim($str,",\n")."\n";
    	$str.="?>";
    	file_put_contents("../included/config.php",$str);
    }

    function Write_Var($value,$add=""){
    	$str="";
    	$add2=$add;
    	if(is_array($value)||is_object($value)){
    		$str.="array(\n";
    		$add2.="\t";
    	}
    	foreach ($value as $name => $val){
    		if(is_array($val)||is_object($val))
    			$str.=$add."'".$name."' => ".Write_Var($val,$add2);
    		else if(is_string($val))
    			$str.=$add."'".$name."' => '".str_replace('\\','\\\\',$val)."',\n";
    		else
    			$str.=$add."'".$name."' => ".$val.",\n";
    	}
    	$str=rtrim($str,",\n")."\n";
    	if(is_array($value)||is_object($value)){
    		//if($add[strlen($add)-1]=='\t')
    			$add=substr($add,0,-1);
    		$str.=$add."),\n";
    	}
    	return $str;
    }
    */
}
