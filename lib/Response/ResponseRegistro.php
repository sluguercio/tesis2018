<?php
include_once('Response.php');
Class ResponseRegistro extends Response{
    
    public function __construct($servicio){
        parent::__construct($servicio);
    }
    
    
    
    public function getResponse($code){
        $respuesta = array();
        parent::setStatus($code);
        parent::setCode($code,'01');
        $respuesta["status"] = parent::getStatus();
        $respuesta["code"] = parent::getCode();
        $respuesta["message"] = parent::getMessage();
        return $respuesta;       
    }
}