<?php
namespace Foundations;
if(!defined("EXEC")){
    header("location: /index.php");
	return;
}

/**
 * classe Foundation che gestisce la sessione
 */
class Log{

public function __construct(){
}


public static function logMessage($messageToLog,$request=NULL){
$log  = "[".date("d/m/Y H:i:s")."] ".$messageToLog.PHP_EOL;
file_put_contents('./Logs/log_'.date("j.n.Y").'.log', $log, FILE_APPEND);
/*  da implementare lo storage del indirizzo IP*/
}
public static function dbg($messageToLog,$request=NULL){
$log  = "[".date("d/m/Y H:i:s")."] ".$messageToLog.PHP_EOL;
file_put_contents('./Logs/dbg_'.date("j.n.Y").'.log', $log, FILE_APPEND);
}

}
