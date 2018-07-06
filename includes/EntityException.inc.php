<?php
if(!defined("EXEC")){
    header("location: /index.php");
	return;
}

class EntityException extends Exception{
    protected $entity;
    protected $params;

    public function __construct(string $message = null,string $entity = "Entity",array $params = array(),int $code = 0, Exception $previous = null){
        parent::__construct($message, $code, $previous);
        $this->entity = $entity;
        $this->params = $params;
    }

    public function getEntity(){
        return $this->entity;
    }

    public function getParams(){
        return $this->params;
    }

    public function __toString(){
        return "$this->message in $this->file:$this->line\nEntity: $this->entity\nParams: " . print_r($this->params, true). "\n" . $this->getTraceAsString();
    }
}
