<?php

include_once('Response.php');
Class ResponseLogin extends Response{
    private $token;
    private $nombre;
    private $apellido;
    
    public function __construct($servicio){
        parent::__construct($servicio);
        $this->token = '';
        
    }
    
    public function setToken($token)
    {
        $this->token = $token;
    }

    public function getToken(){
        return $this->token;
    }
    
    public function setNombre($nombre)
    {
        $this->nombre = $nombre;
    }
    
    public function getNombre(){
        return $this->nombre;
    }
    
    public function setApellido($apellido)
    {
        $this->apellido = $apellido;
    }
    
    public function getApellido(){
        return $this->apellido;
    }
    
    
    public function getResponse($code){
        $respuesta = array();
        parent::setStatus($code);
        parent::setCode($code,'02');
        $respuesta["status"] = parent::getStatus();
        $respuesta["code"] = parent::getCode();
        $respuesta["message"] = parent::getMessage();
        if ($code == 0){
        $respuesta["nombre"] = $this->nombre;
        $respuesta["apellido"] = $this->apellido;
        $respuesta["token"] = $this->token;
        }
        return $respuesta;
    }
}