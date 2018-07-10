<?php
namespace Views;
if(!defined("EXEC")){
    header("location: /index.php");
	return;
}

class Home extends HTMLView{
    
    public function __construct($headIncludes, $loginOrUserIncludes, $contentIncludes){
        parent::__construct();
        $this->smarty->assign('templateHeadIncludes', $headIncludes);                   /* Deve essere formato <link rel="stylesheet" type="text/css" href="...>*/
        $this->smarty->assign('templateLoginOrUserIncludes', $loginOrUserIncludes);     /* Deve essere un template*/
        $this->smarty->assign('templateContentIncludes', $contentIncludes);             /* Deve essere un template*/
    }

    public function HTMLRender(){
    }

}
