<?php
namespace Foundations;
use \Models\Model as Model;
if(!defined("EXEC")){
    header("location: /index.php");
	return;
}

class Gestore extends Utente{
  protected static $table = "gestori";


}
?>
