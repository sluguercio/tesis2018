
<?php
include_once('Response.php');
Class ResponseUsuarios extends Response{
    
    
    
    
    public function __construct($servicio){
        parent::__construct($servicio);
    }
    
    public function getResponseModDatosUsuarios($code){
        $respuesta = array();
        parent::setStatus($code);
        parent::setCode($code,'09');
        $respuesta["status"] = parent::getStatus();
        $respuesta["code"] = parent::getCode();
        $respuesta["message"] = parent::getMessage();
       
        return $respuesta;
    }
    
    
    public function getResponseDatosUsuarios($code,$datos){
        $respuesta = array();
        parent::setStatus($code);
        parent::setCode($code,'08');
        $respuesta["status"] = parent::getStatus();
        $respuesta["code"] = parent::getCode();
        $respuesta["message"] = parent::getMessage();
        if ($code == 0){
        $respuesta["email"] = $datos["email"];
        $respuesta["nombre"] = $datos["nombre"];
        $respuesta["apellido"] = $datos["apellido"];
        $respuesta["fechaNacimiento"] = $datos["fechaNacimiento"];
        $respuesta["idCiudad"] = $datos["idCiudad"];
        $respuesta["nombreCiudad"] = $datos["nombreCiudad"];
        $respuesta["idDepartamento"] = $datos["idDepartamento"];
        $respuesta["nombreDepartamento"] = $datos["nombreDepartamento"];
        $respuesta["idPais"] = $datos["idPais"];
        $respuesta["nombrePais"] = $datos["nombrePais"];
        $respuesta["direccion"] = $datos["direccion"];
        $respuesta["tipoDocumento"] = $datos["tipoDocumento"];
        $respuesta["documento"] = $datos["documento"];
        }
        return $respuesta;
    }
    
    public function getResponseConfirmacion($code){
        $respuesta = array();
        parent::setStatus($code);
        parent::setCode($code,'14');
        $respuesta["status"] = parent::getStatus();
        $respuesta["code"] = parent::getCode();
        $respuesta["message"] = parent::getMessage();
        return $respuesta;
    }
    
    public function getResponseForgetPassword($code){
        $respuesta = array();
        parent::setStatus($code);
        parent::setCode($code,'15');
        $respuesta["status"] = parent::getStatus();
        $respuesta["code"] = parent::getCode();
        $respuesta["message"] = parent::getMessage();
        return $respuesta;
    }
    
    
    public function getResponseResetPassword($code){
        $respuesta = array();
        parent::setStatus($code);
        parent::setCode($code,'16');
        $respuesta["status"] = parent::getStatus();
        $respuesta["code"] = parent::getCode();
        $respuesta["message"] = parent::getMessage();
        return $respuesta;
    }
    
   
    
   
}