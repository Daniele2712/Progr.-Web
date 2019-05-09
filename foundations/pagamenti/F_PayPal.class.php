<?php
namespace Foundations\Pagamenti;
use \Foundations\Foundation as Foundation;
use \Models\Model as Model;
use \Models\Pagamenti\M_PayPal as M_PayPal;
if(!defined("EXEC")){
    header("location: /index.php");
	return;
}

class F_PayPal extends Foundation{
    protected static $table = "paypal";
}
