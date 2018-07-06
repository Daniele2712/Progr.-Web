<?php
namespace Foundations;
use \Models\Model as Model;
if(!defined("EXEC")){
    header("location: /index.php");
	return;
}

class Ordine extends Foundation{
    protected static $table = "ordini";


}
?>
