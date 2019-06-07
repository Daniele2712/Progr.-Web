<?php
namespace Views;
if(!defined("EXEC")){
    header("location: /index.php");
	return;
}

/**
 * View che mostra un immagine
 */
class Image implements View{

    private $mime = "text/html";
    private $size = 0;
    private $data = "";

    public function setImage(\Models\M_Immagine $immagine){
        $this->mime = $immagine->getMIMEType();
        $this->size = $immagine->getSize();
        $this->data = $immagine->getImage();
    }

    public function render(){
        header('Content-Type: ' . $this->mime);
        header('Content-Length: ' . $this->size);
        //header('Content-Length: ' . strlen($this->data));
        echo $this->data;
    }
}
