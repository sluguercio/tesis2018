
<?php
include_once('Response.php');
Class ResponseFacturas extends Response{
    
    
    
    
    public function __construct($servicio){
        parent::__construct($servicio);
    }
    
    
    
    public function getResponseFacturas($code,$datos){
        $respuesta = array();
        parent::setStatus($code);
        parent::setCode($code,'06');
        $respuesta["status"] = parent::getStatus();
        $respuesta["code"] = parent::getCode();
        $respuesta["message"] = parent::getMessage();
        if ($code == 0)
            $respuesta["facturas"] = $datos;
        return $respuesta;
    }
    
    public function getResponseFacturasDetalles($code,$datos){
        $respuesta = array();
        parent::setStatus($code);
        parent::setCode($code,'07');
        $respuesta["status"] = parent::getStatus();
        $respuesta["code"] = parent::getCode();
        $respuesta["message"] = parent::getMessage();
        if ($code == 0)
            $respuesta["detalles"] = $datos;
        return $respuesta;
    }
    
    public function getResponseConsumos($code,$datos){
        $respuesta = array();
        parent::setStatus($code);
        parent::setCode($code,'05');
        $respuesta["status"] = parent::getStatus();
        $respuesta["code"] = parent::getCode();
        $respuesta["message"] = parent::getMessage();
        if ($code == 0)
            $respuesta["consumos"] = $datos;
        return $respuesta;
    }
    
    
    
    
}