<?php
namespace Foundations;
use \Models\Model as Model;
if(!defined("EXEC")){
    header("location: /index.php");
	return;
}

class F_DatiAnagrafici extends Foundation{
    protected static $table = "dati_anagrafici";

    public static function insert(Model $dati_anagrafici): int{
            $DB = \Singleton::DB();
            $nome = $dati_anagrafici->getNome();
            $cognome = $dati_anagrafici->getCognome();
            $telefono = $dati_anagrafici->getTelefono();
            $nascita = $dati_anagrafici->getDataNascita()->format('Y-m-d');

            $sql = "INSERT INTO ".self::$table." VALUES (NULL, ?, ?, ?, ?)";
            $p = $DB->prepare($sql);
            $p->bind_param("ssss", $nome, $cognome, $telefono, $nascita);
            if(!$p->execute())
                throw new \SQLException("Error Executing Statement", $sql, $p->error, 3);
            $p->close();
            return $DB->lastId();
    }

    public static function update(Model $dati_anagrafici){
            $DB = \Singleton::DB();
            $id = $dati_anagrafici->getId();
            $nome = $dati_anagrafici->getNome();
            $cognome = $dati_anagrafici->getCognome();
            $telefono = $dati_anagrafici->getTelefono();
            $nascita = $dati_anagrafici->getDataNascita()->format('Y-m-d');

            $sql = "UPDATE dati_anagrafici SET nome = ?, cognome = ?, telefono = ?, data_nascita = ? WHERE id = ?";
            $p = $DB->prepare($sql);
            $p->bind_param("ssssi", $nome, $cognome, $telefono, $nascita, $id);
            if(!$p->execute())
                throw new \SQLException("Error Executing Statement", $sql, $p->error, 3);
            $p->close();
    }

    public static function create(array $object): Model{
        return new \Models\M_DatiAnagrafici($object["id"], $object["nome"], $object["cognome"], $object["telefono"], new \DateTime($object["data_nascita"]));
    }
}
