<?php
namespace Foundations;
use \Models\Model as Model;
if(!defined("EXEC")){
    header("location: /index.php");
	return;
}

class Carta extends Foundation{
    protected static $table = "carte";

    public static function create(array $data): Model{
        $sql = "SELECT id, numero, cvv, nome, cognome, data_scadenza FROM ".self::$table." WHERE id_pagamento = ?";
        $p = \Singleton::DB()->prepare($sql);
        $p->bind_param("i", $data["id_pagamento"]);
        if(!$p->execute())
            throw new \SQLException("Error Executing Statement", $sql, $p->error, 3);
        $p->bind_result($idCarta, $num, $cvv, $nome, $cognome, $data_scadenza);
        $r = $p->fetch();
        if($r === FALSE)
            throw new \SQLException("Error Fetching Statement", $sql, $p->error, 4);
        elseif($r === NULL)
            throw new \ModelException("Model Not Found", __CLASS__, array("id"=>$id_pagamento), 0);
        $p->close();
        return new \Models\Carta($id_pagamento, $idCarta, $num, $cvv, $nome, $cognome, $dataScadenza);
    }

    public static function insert(Model $carta): int{
        $DB = \Singleton::DB();
        $idPagamento = $carta->getId();
        $numero = $carta->getNumero();
        $cvv = $carta->getCvv();
        $nome = $carta->getNome();
        $cognome = $carta->getCognome();
        $scadenza = $carta->getScadenza()->format("Y-m-d");

        $sql = "INSERT INTO ".self::$table." VALUES(NULL, ?, ?, ?, ?, ?, ?);";
        $p = $DB->prepare($sql);
        $p->bind_param("isisss", $idPagamento, $numero, $cvv, $nome, $cognome, $scadenza);
        if(!$p->execute())
            throw new \SQLException("Error Executing Statement", $sql, $p->error, 3);
        $p->close();
        return $DB->lastId();
    }

    public static function update(Model $carta){
        $DB = \Singleton::DB();
        $idCarta = $carta->getIdCarta();
        $idPagamento = $carta->getId();
        $numero = $carta->getNumero();
        $cvv = $carta->getCvv();
        $nome = $carta->getNome();
        $cognome = $carta->getCognome();
        $scadenza = $carta->getScadenza()->format("Y-m-d");
        $sql = "UPDATE ".self::$table." SET id_pagamento = ?, numero = ?, cvv = ?, nome = ?, cognome = ?, data_scadenza = ? WHERE id = ?;";
        $p = $DB->prepare($sql);
        $p->bind_param("isisssi", $idPagamento, $numero, $cvv, $nome, $cognome, $scadenza, $idCarta);
        if(!$p->execute())
            throw new \SQLException("Error Executing Statement", $sql, $p->error, 3);
        $p->close();
    }
}
