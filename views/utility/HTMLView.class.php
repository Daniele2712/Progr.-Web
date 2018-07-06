<?php
namespace Views;
if(!defined("EXEC")){
    header("location: /index.php");
	return;
}

/**
 * classe astratta delle Views HTML
 */
abstract class HTMLView implements View{
    /**
     * riferimento all'istanza di Smarty
     * @var    Smarty
     */
    protected $smarty;
    /**
     * nome del layout da usare
     * @var    string
     */
    protected $layout = "default";
    /**
     * contenuto da mostrare nel layout
     * @var    string
     */
    protected $content = "empty";

    /**
     * acquisisce un riferimento all'istanza di Smarty
     */
    public function __construct(){
        $this->smarty = \Singleton::Smarty();
    }

    /**
     * invia in output la pagina HTML
     */
    public function render(){
        $this->smarty->assign("content",$this->content.".tpl");
        $this->HTMLRender();
        $this->smarty->display($this->layout.".tpl");
    }

    /**
     * metodo per effettuare modifiche prima del render effettivo
     */
    public function HTMLRender(){}
}
