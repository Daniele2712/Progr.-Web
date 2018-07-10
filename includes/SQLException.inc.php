<?php
if(!defined("EXEC")){
    header("location: /index.php");
	return;
}

/**
 * eccezione relativa a SQL
 */
class SQLException extends Exception{
    protected $sql;
    protected $sql_error;

    public function __construct($message = null, $sql = "", $sql_error = "", $code = 0, Exception $previous = null){
        parent::__construct($message, $code, $previous);
        $this->sql = $sql;
        $this->sql_error = $sql_error;
    }

    public function getSQL(){
        return $this->sql;
    }

    public function getError(){
        return $this->sql_error;
    }

    public function __toString(){
        return "$this->message in $this->file:$this->line\nSQL: $this->sql\n$this->sql_error\n".$this->getTraceAsString();
    }
}
