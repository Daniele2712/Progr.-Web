<?php
if(!defined("EXEC")){
    header("location: /index.php");
	return;
}

class FIndirizzo extends Foundation{
    protected static $table = "indirizzi";

    public static function create(array $obj): Entity{
        $comune = FComune::find($obj["id_comune"]);
        return new EIndirizzo($obj["id"], $comune, $obj["via"], $obj["civico"], $obj["note"]);
    }

    public static function insert(Entity $obj): int{

    }

    public static function update(Entity $obj){

    }

    public static function getIndirizziByUserId(int $id){
        $p = Singleton::DB()->prepare("
            SELECT indirizzi.id, id_comune, via, civico, note
            FROM indirizzi
            LEFT JOIN indirizzi_preferiti ON indirizzi.id=indirizzi_preferiti.id_indirizzo
            WHERE id_utente_r = ?");
        $p->bind_param("i",$id);
        if(!$p->execute())
            throw new \SQLException("Error Executing Statement", $sql, $p->error, 1);
        $res = $p->get_result();
        $p->close();
        $r = array();
        while($row = $res->fetch_assoc())
            $r[] = self::create($row);
        return $r;
    }
}
?>
