<?php
if(!defined("EXEC")){
    header("location: /index.php");
	return;
}

abstract class Foundation{
    protected static $table;
    public abstract static function insert(Entity $object): int;
    public abstract static function update(Entity $object);
    public abstract static function create(array $object): Entity;

    public static function all(): array{
        if(!static::$table)
            throw new \Exception("Error Table Name not set in".get_called_class(), 1);
        $DB = Singleton::DB();
        $sql = "SELECT * FROM ".static::$table;
        $res = $DB->query($sql);
        if(!$res)
            throw new \SQLException("Error Executing Query", $sql, $p->error, 4);
        $r = array();
        while($row = $res->fetch_assoc())
            $r[] = static::create($row);
        return $r;
    }

    public static function find(int $id){
        if(!static::$table)
            throw new \Exception("Error Table Name not set in".get_called_class(), 1);
        $DB = Singleton::DB();
        $sql = "SELECT * FROM ".static::$table." WHERE id = ?";
        $p = $DB->prepare($sql);
        $p->bind_param("i",$id);
        if(!$p->execute())
            throw new \SQLException("Error Executing Statement", $sql, $p->error, 3);
        $res = $p->get_result();
        $p->close();
        $r = null;
        if($res)
            $r = static::create($res->fetch_assoc());
        return $r;
    }

    public static function delete(int $id){
        if(!static::$table)
            throw new \Exception("Error Table Name not set in".get_called_class(), 1);
        $DB = Singleton::DB();
        $sql = "DELETE FROM ".static::$table." WHERE id = ?";
        $p = $DB->prepare($sql);
        $p->bind_param("i",$id);
        if(!$p->execute())
            throw new \SQLException("Error Executing Statement", $sql, $p->error, 3);
        $p->close();
    }

    public static function save($obj):int{
        $p = self::find($obj->getId());
        if($p)
            return static::update($obj);
        else
            return static::insert($obj);
    }

}
