<?php
if(!defined("EXEC")){
    header("location: /index.php");
	return;
}

/**
 * eccezione relativa ai Models
 */
class ModelException extends Exception{
    protected $model;
    protected $params;

    public function __construct(string $message = null,string $model = "Model",array $params = array(),int $code = 0, Exception $previous = null){
        parent::__construct($message, $code, $previous);
        $this->model = $model;
        $this->params = $params;
    }

    public function getModel(){
        return $this->model;
    }

    public function getParams(){
        return $this->params;
    }

    public function __toString(){
        return "$this->message in $this->file:$this->line\nModel: $this->model\nParams: " . print_r($this->params, true). "\n" . $this->getTraceAsString();
    }
}
