<?php
if(!defined("EXEC")){
    header("location: /index.php");
	return;
}

abstract class Foundation{
    protected static $table;

    protected static function delete(int $id){
        if($this->table)
            Singleton::DB()->query("DELETE FROM ".$this->table." WHERE id='$id'");
    }

    public abstract static function find(int $id);
}
