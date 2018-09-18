<?php
namespace Foundations;
if(!defined("EXEC")){
    header("location: /index.php");
    return;
}

class Valuta{
    public static function update(int $id, string $sigla, string $nome, string $simbolo){

    }

    public static function insert(string $sigla, string $nome, string $simbolo):int{
        return 0;
    }

    public static function all(): array{
        $DB = \Singleton::DB();
        $sql = "SELECT * FROM valute";
        $res = $DB->query($sql);
        $r = array();
        while($row = $res->fetch_row())
            $r[] = $row;
        return $r;
    }

    public static function find(int $id): array{
        $DB = \Singleton::DB();
        $sql = "SELECT sigla, nome, simbolo FROM valute WHERE id = ?";
        $p = $DB->prepare($sql);
        $p->bind_param("i",$id);
        if(!$p->execute())
            throw new \SQLException("Error Executing Statement", $sql, $p->error, 3);
        $p->bind_result($sigla, $nome, $simbolo);
        $r = $p->fetch();
        if($r === FALSE)
            throw new \SQLException("Error Fetching Statement", $sql, $p->error, 4);
        elseif($r === NULL)
            throw new \ModelException("Model Not Found", __CLASS__, array("id"=>$id_utente), 0);
        $p->close();
        return array($sigla, $nome, $simbolo);
    }
}
