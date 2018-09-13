<?php
namespace Models;
if(!defined("EXEC")){
    header("location: /index.php");
	return;
}

class Immagine extends Model{
    private $name;
    private $size;
    private $type;
    private $image;

    public function __construct(int $id, string $name="", int $size=0, string $type="", $image=NULL){
        $this->id = $id;
        $this->name = $name;
        $this->size = $size;
        $this->type = $type;
        $this->image = $image;
    }

    public function getName():string{
        return $this->name;
    }

    public function getSize():int{
        return $this->size;
    }

    public function getMIMEType():string{
        return $this->type;
    }

    public function getImage(){
        return $this->image;
    }
}
