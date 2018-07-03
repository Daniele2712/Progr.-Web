<?php
if(!defined("EXEC")){
    header("location: /index.php");
	return;
}

abstract class Foundation{
    protected static $table;

    public abstract static function find(int $id);
    public abstract static function store($object);
    public abstract static function create($object);
    public abstract static function all();
    public static function delete(int $id){
        if($this->table)
            Singleton::DB()->query("DELETE FROM ".$this->table." WHERE id='$id'");
    }
    public static function save($obj):int{
        $p = self::find($obj->getId());
        if($p)
            return self::store($obj);
        else
            return self::create($obj);
    }

}
