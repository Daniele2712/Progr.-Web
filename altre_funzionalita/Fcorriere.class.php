<?php
namespace Foundations;
use \Models\Model as Model;
if(!defined("EXEC")){
    header("location: /index.php");
	return;
}

class Corriere extends Foundation{
    protected static $table = "corrieri";
}
?>
