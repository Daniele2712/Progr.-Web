<?php
namespace Foundations;
use \Models\Model as Model;
if(!defined("EXEC")){
    header("location: /index.php");
	return;
}

/**
 * classe astratta da cui tutte le classi foundation che operano con il DBMS ereditano
 */
abstract class Foundation{
    /**
     * @var string $table variabile contenente il nome della tabella su cui effettuare le operazioni
     */
    protected static $table;
    protected static $ID = array("name"=>"id","type"=>"i");


    /**
     * metodo per inserire un Model nel DB
     *
     * @param   \Models\Model   $object     il Model da inserire
     * @return  int                         l'id del Model inserito
     */
    public abstract static function insert(Model $object): int;


    /**
     * metodo pre aggiornare un Model nel DB
     *
     * @param   \Models\Model  $object     il Model da aggiornare
     */
    public abstract static function update(Model $object);


    /**
     * metodo che genera il Model a partire da un array associativo
     *
     * @param   array   $object     array associativo, le chiavi sono i nomi delle colonne della tabella
     * @return  \Models\Model       il Model creato
     */
    public abstract static function create(array $object): Model;

    /**
     * metodo che ritorna tutte i Model dal DB
     *
     * @throws  Exception se il nome della tabella non è stato impostato
     * @throws  SQLException in caso di errore di esecuzione della query
     * @return  array   array di Model
     */
    public static function all(): array{
        if(!static::$table)
            throw new \Exception("Error Table Name not set in".get_called_class(), 1);
        $DB = \Singleton::DB();
        $sql = "SELECT * FROM ".static::$table;
        $res = $DB->query($sql);
        $r = array();
        while($row = $res->fetch_assoc())
            $r[] = static::create($row);
        return $r;
    }

    /**
     * metodo che ritorna tutte le tuple dalla tabella
     *
     * @throws  Exception se il nome della tabella non è stato impostato
     * @throws  SQLException in caso di errore di esecuzione della query
     * @return  array   array di tuple
     */
    public static function loadAll(): array{
        if(!static::$table)
            throw new \Exception("Error Table Name not set in".get_called_class(), 1);
        $DB = \Singleton::DB();
        $sql = "SELECT * FROM ".static::$table;
        $res = $DB->query($sql);
        $r = array();
        while($row = $res->fetch_assoc())
            $r[] = $row;
        return $r;
    }

    /**
     * metodo per cercare un Model nel DB a partire dal suo id
     *
     * @param   int    $id      id del Model da cercare
     * @throws  Exception       se il nome della tabella non è stato impostato
     * @throws  SQLException    in caso di errore di esecuzione dello statement
     * @return  \Models\Model   Model cercato
     */
    public static function find(int $id): Model{
        if(!static::$table)
            throw new \Exception("Error Table Name not set in".get_called_class(), 1);
        $DB = \Singleton::DB();
        $sql = "SELECT * FROM ".static::$table." WHERE ".static::$ID["name"]." = ?";
        $p = $DB->prepare($sql);
        $p->bind_param(static::$ID["type"],$id);
        if(!$p->execute())
            throw new \SQLException("Error Executing Statement", $sql, $p->error, 3);
        $res = $p->get_result();
        $p->close();
        $r = null;
        if($res){
            if($res->num_rows)
                $r = static::create($res->fetch_assoc());
            else
                throw new \SQLException("Empty Result", $sql, 0, 8);
        }
        return $r;
    }


    /**
     * metodo per testare l'esistenza di un Model nel DB a partire dal suo id
     *
     * @param   int    $id      id del Model da cercare
     * @throws  Exception       se il nome della tabella non è stato impostato
     * @throws  SQLException    in caso di errore di esecuzione dello statement
     * @return  bool            TRUE se il model esiste, FALSE se non è stato trovato
     */
    public static function seek(int $id): bool{
        if(!static::$table)
            throw new \Exception("Error Table Name not set in".get_called_class(), 1);
        $DB = \Singleton::DB();
        $sql = "SELECT * FROM ".static::$table." WHERE ".static::$ID["name"]." = ?";
        $p = $DB->prepare($sql);
        $p->bind_param(static::$ID["type"],$id);
        if(!$p->execute())
            throw new \SQLException("Error Executing Statement", $sql, $p->error, 3);
        $res = $p->get_result();
        $p->close();
        return $res && $res->num_rows===1;
    }

    /**
     * metodo per cercare una tupla nel DB a partire dal suo id
     *
     * @param   int    $id      id del Model da cercare
     * @throws  Exception       se il nome della tabella non è stato impostato
     * @throws  SQLException    in caso di errore di esecuzione dello statement
     * @return  array           tupla cercata
     */
    public static function load(int $id): Model{
        if(!static::$table)
            throw new \Exception("Error Table Name not set in".get_called_class(), 1);
        $DB = \Singleton::DB();
        $sql = "SELECT * FROM ".static::$table." WHERE ".static::$ID["name"]." = ?";
        $p = $DB->prepare($sql);
        $p->bind_param(static::$ID["type"],$id);
        if(!$p->execute())
            throw new \SQLException("Error Executing Statement", $sql, $p->error, 3);
        $res = $p->get_result();
        $p->close();
        $r = null;
        if($res){
            if($res->num_rows)
                $r = $res->fetch_assoc();
            else
                throw new \SQLException("Empty Result", $sql, 0, 8);
        }
        return $r;
    }

    /**
     * metodo per cercare un insieme di Model nel DB a partire dai loro id
     *
     * @param   array    $id    array di id dei Model da cercare
     * @throws  Exception       se il nome della tabella non è stato impostato
     * @throws  SQLException    in caso di errore di esecuzione dello statement
     * @return  array           array di Model cercati
     */
    public static function findMany(array $ids): array{
        if(!static::$table)
            throw new \Exception("Error Table Name not set in".get_called_class(), 1);
        $DB = \Singleton::DB();
        $sql = "SELECT * FROM ".static::$table." WHERE ".static::$ID["name"]." IN (?)";
        $p = $DB->prepare($sql);
        $ids_str = implode(", ",$ids);
        $p->bind_param("s", $ids_str);
        if(!$p->execute())
            throw new \SQLException("Error Executing Statement", $sql, $p->error, 3);
        $res = $p->get_result();
        $p->close();
        $r = array();
        while($row = $res->fetch_assoc())
            $r[] = static::create($row);
        return $r;
    }

    /**
     * metodo per cancellare un Model dal DB in base al suo id
     *
     * @param   int    $id      id del Model da cancellare
     * @throws  Exception       se il nome della tabella non è stato impostato
     * @throws  SQLException    in caso di errore di esecuzione dello statement
     */
    public static function delete(int $id){
        if(!static::$table)
            throw new \Exception("Error Table Name not set in".get_called_class(), 1);
        $DB = \Singleton::DB();
        $sql = "DELETE FROM ".static::$table." WHERE ".static::$ID["name"]." = ?";
        $p = $DB->prepare($sql);
        $p->bind_param(static::$ID["type"],$id);
        if(!$p->execute())
            throw new \SQLException("Error Executing Statement", $sql, $p->error, 3);
        $p->close();
    }

    /**
     * metodo per modificare o inserire un Model sul DB
     *
     * @param    \Models\Model   $obj  il Model da salvare
     * @return   int|null              l'eventuale id del nuovo Model
     */
    public static function save(Model $obj){
        if($obj->getId()<=0 || !static::seek($obj->getId())){
            $id = static::insert($obj);
            $obj->setId($id);
            return $id;
        }else
            return static::update($obj);
    }

}
