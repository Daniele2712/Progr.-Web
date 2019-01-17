<?php
namespace Foundations;
use \Models\Model as Model;
if(!defined("EXEC")){
    header("location: /index.php");
	return;
}

class DatiAnagrafici extends Foundation{
    protected static $table = "dati_anagrafici";

    public static function insert(Model $dati_anagrafici): int{
            $DB = \Singleton::DB();
            $sql = "INSERTO INTO ".self::$table." VALUES(NULL, ?, ?,?,?)";
            $p = $DB->prepare($sql);
            $nome=$dati_anagrafici->getNome();
            $cognome=$dati_anagrafici->getCognome();
            $telefono=$dati_anagrafici->getTelefono();
            $nasita=$dati_anagrafici->getDataNascita()->format('Y-m-d H:i:s');
            $p->bind_param("ssss", $nome, $cognome, $telefono, $nasita );
            if(!$p->execute())
                throw new \SQLException("Error Executing Statement", $sql, $p->error, 3);
            $p->close();
            $idUltimoOrdine=$DB->lastId();
    }

    public static function update(Model $object){
            $DB = \Singleton::DB();
            $sql = "UPDATE dati_anagrafici SET nome = ?, cognome = ?, telefono = ?, data_nascita = ? WHERE id = ?";
            $p = $DB->prepare($sql);
            $p->bind_param("ssss", $dati_anagrafici->getNome(), $dati_anagrafici->getCognome(), $dati_anagrafici->getTelefono(), $dati_anagrafici->getDataNascita());
            if(!$p->execute())
                throw new \SQLException("Error Executing Statement", $sql, $p->error, 3);
            $p->close();
    }

    public static function create(array $object): Model{
        return new \Models\DatiAnagrafici($object["id"], $object["nome"], $object["cognome"], $object["telefono"], new \DateTime($object["data_nascita"]));
    }
}
