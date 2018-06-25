<?php
if(!defined("EXEC")){
    header("location: /index.php");
	return;
}

class Request{
    private $controller;
    private $action;
    private $params = array();
    private $rest = false;
    private $method;

    public function __construct(){
        global $config;
        $this->controller = $config['default']['controller'];
        $this->action = $config['default']['action'];
        $this->method = $_SERVER['REQUEST_METHOD'];
        $uri = $_SERVER['REQUEST_URI'];
        $pos = strpos($uri,'?');
        $params = explode("/",$pos===FALSE?$uri:substr($uri,0,$pos));
        array_shift($params);

        if(count($params)>0 && $params[0]=="api"){
            $this->rest = true;
            array_shift($params);
        }
        if(count($params)>0 && $params[0]!=="")
            $this->controller = "C".array_shift($params);
        if($this->rest)
            $this->action = strtolower($this->method);
        elseif(count($params)>0 && $params[0]!=="")
            $this->action = array_shift($params);
        $this->params = $params;
    }

    public function getMethod():string{
        return $this->method;
    }

    public function getController():string{
        return $this->controller;
    }

    public function getAction():string{
        return $this->action;
    }

    public function isRest():bool{
        return $this->rest;
    }
}
