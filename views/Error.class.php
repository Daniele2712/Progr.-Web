<?php
namespace Views;
if(!defined("EXEC")){
    header("location: /index.php");
	return;
}

/**
 * View che mostra gli errori
 */
class Error implements View{
    /**
     * flag: TRUE se è una risposta Restfull, FALSE altrimenti
     * @var    bool
     */
    private $rest = false;
    /**
     * numero e messaggio d'errore
     * @var    array
     */
    private $message = array("errorn"=>0, "error"=>"");
    /**
     * lista di messaggi d'errore comuni
     * @var    array
     */
    private $commonErrors = array(
        404 => "File Not Found",
        405 => "Method Not Allowed"
    );

    public function isRest(bool $rest){
        $this->rest = $rest;
    }

    /**
     * metodo per mostrare un errore in output
     *
     * @param     int           $n        numero dell'errore
     * @param     string|null   $error    messaggio d'errore
     */
    public function error(int $n, string $error = NULL){
        $this->message["errorn"] = $n;
        if($error === null && array_key_exists($this->commonErrors, $n))
            $this->message["error"] = $this->commonErrors($n);
        elseif($error != null)
            $this->message["error"] = $error;
        $this->render();
    }

    /**
     * metodo per inviare in output il messaggio d'errore sia per richieste Restfull che in HTML
     */
    private function render(){
        header('HTTP/1.1 '.$this->message["errorn"].' '.$this->message["error"]);
        if($this->rest){
            echo json_encode($this->message);
        }else{
            $smarty = \Singleton::Smarty();
            $smarty->assign("content","error/message.tpl");
            $smarty->assign("message",$this->message);
            $smarty->display("layout.tpl");
        }
    }
}
