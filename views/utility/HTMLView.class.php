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
<<<<<<< HEAD
    protected $layout = "defaultt";
=======
    protected $layout = "default";
>>>>>>> bdb7c65b1cb79b0a810bcd14e613228cb35ce8b3
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
<<<<<<< HEAD
        $this->smarty->display("layout.tpl");
=======
        $this->smarty->assign("content",$this->content.".tpl");
        $this->HTMLRender();
        $this->smarty->display($this->layout.".tpl");
>>>>>>> bdb7c65b1cb79b0a810bcd14e613228cb35ce8b3
    }
    

    /**
     * metodo per effettuare modifiche prima del render effettivo
     */
    public function HTMLRender(){}
}
