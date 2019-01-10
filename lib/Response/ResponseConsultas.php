
<?php
include_once('Response.php');
Class ResponseConsultas extends Response{
    
    
    
    
    public function __construct($servicio){
        parent::__construct($servicio);
    }
    
    
    
    public function getResponsePaises($code,$datos){
        $respuesta = array();
        parent::setStatus($code);
        parent::setCode($code,'13');
        $respuesta["status"] = parent::getStatus();
        $respuesta["code"] = parent::getCode();
        $respuesta["message"] = parent::getMessage();
        if ($code == 0)
            $respuesta["paises"] = $datos;
        return $respuesta;
    }
    
    
    public function getResponseDepartamentos($code,$datos){
        $respuesta = array();
        parent::setStatus($code);
        parent::setCode($code,'12');
        $respuesta["status"] = parent::getStatus();
        $respuesta["code"] = parent::getCode();
        $respuesta["message"] = parent::getMessage();
        if ($code == 0)
            $respuesta["departamentos"] = $datos;
        
        return $respuesta;
    }
    
    public function getResponseCiudades($code,$datos){
        $respuesta = array();
        parent::setStatus($code);
        parent::setCode($code,'11');
        $respuesta["status"] = parent::getStatus();
        $respuesta["code"] = parent::getCode();
        $respuesta["message"] = parent::getMessage();
        if ($code == 0)
            $respuesta["ciudades"] = $datos;
        
        return $respuesta;
    }
    
    
    
    
}