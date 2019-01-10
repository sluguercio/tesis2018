
<?php
include_once('Response.php');
Class ResponseCuentas extends Response{
    
    
    
    
    public function __construct($servicio){
        parent::__construct($servicio);
    }
    
    
    
    public function getResponseCuentas($code,$datos){
        $respuesta = array();
        parent::setStatus($code);
        parent::setCode($code,'04');
        $respuesta["status"] = parent::getStatus();
        $respuesta["code"] = parent::getCode();
        $respuesta["message"] = parent::getMessage();
        if ($code == 0)
            $respuesta["cuentas"] = $datos;
        return $respuesta;
    }
    
    
    public function getResponseDatosCuenta($code,$datos){
        $respuesta = array();
        parent::setStatus($code);
        parent::setCode($code,'03');
        $respuesta["status"] = parent::getStatus();
        $respuesta["code"] = parent::getCode();
        $respuesta["message"] = parent::getMessage();
        if ($code == 0)
            $respuesta["cuenta"] = $datos;
        return $respuesta;
    }
    
    public function getResponseModCuenta($code){
        $respuesta = array();
        parent::setStatus($code);
        parent::setCode($code,'10');
        $respuesta["status"] = parent::getStatus();
        $respuesta["code"] = parent::getCode();
        $respuesta["message"] = parent::getMessage();
        return $respuesta;
    }
    
    public function getResponseConsumos($code,$datos){
        $respuesta = array();
        parent::setStatus($code);
        parent::setCode($code,'05');
        $respuesta["status"] = parent::getStatus();
        $respuesta["code"] = parent::getCode();
        $respuesta["message"] = parent::getMessage();
        $respuesta["consumos"] = $datos;
        return $respuesta;
    }
}