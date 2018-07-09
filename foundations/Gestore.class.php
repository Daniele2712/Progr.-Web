<?php
namespace Foundations;
use \Models\Model as Model;
if(!defined("EXEC")){
    header("location: /index.php");
	return;
}

class Gestore extends Utente{
  protected static $table = "gestori";
  protected static function create_user(int $id, \Models\DatiAnagrafici $dati_anagrafici, string $email, string $username){}
  public static function insert(Model $obj): int{}
  public static function update(Model $obj){}
  public static function create(array $obj): Model{}
}
