<?php

Class ValidadorRegistro{
    
    public function __construct(){
        
    }
    
    public function checkDireccion($direccion){
        $datos = explode(' ', $direccion);
        foreach ($datos as $item)
            if ((!is_numeric($item)) && (!ctype_alpha($item)) )
                return FALSE;
        return TRUE;    
    }
    
    public function ValidarRegistro($datos){
        
    if (!filter_var($datos["email"],FILTER_VALIDATE_EMAIL))
        return -1;
    if ( (!preg_match("/^[a-zA-Z ]+$/", $datos["nombre"])) || (!(strlen($datos["nombre"] <= 50))))
        return -2;
    if ( (!preg_match("/^[a-zA-Z ]+$/", $datos["apellido"])) || (!(strlen($datos["apellido"] <= 50))))
        return -3;
    if ( (!is_numeric($datos["fechaNacimiento"])) || (!(strlen($datos["fechaNacimiento"]) === 9)) )
        return -4;
    if (!preg_match("/^[a-zA-Z0-9]+$/", $datos["password"]))
        return -5;
    if (!is_numeric($datos["ciudad"]))
        return -6;
    if ( (!$this->checkDireccion($datos["direccion"])) || (!(strlen($datos["direccion"] <= 100))))
        return -7;
    if ( (!is_numeric($datos["tipodocumento"])))
        return -8;
    if ( (!is_numeric($datos["documento"])) || (!strlen($datos["documento"]) > 7 ))
        return -9;
            
    return 0;        
            
        
        
        
    }
    
    
}