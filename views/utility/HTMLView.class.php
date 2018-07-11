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
     * risorse da aggiungere nell'head HTML, come script javascript e file css
     * @var    array
     */
    private $resources = array("js"=>array(),"css"=>array());

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
        $this->HTMLRender();

        $this->smarty->assign("templateContentIncludes",$this->content.".tpl");

        $resources_str = "";
        foreach ($this->resources["js"] as $file)
            $resources_str .= "<script type='text/javascript' src='$file'></script>";
        foreach ($this->resources["css"] as $file)
            $resources_str .= "<link rel='stylesheet' type='text/css' href='$file'/>";
        $this->smarty->assign("templateHeadIncludes",$resources_str);

        $this->smarty->display($this->layout.".tpl");
    }

    /**
     * metodo per aggiungere un file javascript nell'head HTML
     *
     * @param    string    $filename    percorso al file, meglio se assoluto
     */
    public function addJS(string $filename){
        if(array_search($filename, $this->resources["js"]) !== FALSE)
            $this->resources["js"][] = $filename;
    }

    /**
     * metodo per aggiungere un file css nell'head HTML
     *
     * @param    string    $filename    percorso al file, meglio se assoluto
     */
    public function addCSS(string $filename){
        if(array_search($filename, $this->resources["css"]) !== FALSE)
            $this->resources["css"][] = $filename;
    }

    /**
     * metodo per effettuare modifiche prima del render effettivo
     */
    public function HTMLRender(){}
}
