<?php

Class Route{
    
    
    private $usuario = 'Usuario';
    private $cuentas = 'Cuentas';
    private $facturas = 'Facturas';
    
    
    public function __construct(){
        
    }
    
    public function getRoute($servicio){
        $return = '';
        
        switch ($servicio){
            case 'nuevascoordenadas': 
                $return = $this->vehiculo;
                break;
            case 'login':
                $return = $this->usuario;
                break;
            case 'altaUsuario':
                $return = $this->usuario;
                break;
            case 'datosCuenta':
                $return = $this->cuentas;
                break;
            case 'cuentas':
                $return = $this->cuentas;
                break;
            case 'consumos':
                $return = $this->cuentas;
                break;
            case 'facturas':
                $return = $this->facturas;
                break;
            case 'facturaDetalles':
                $return = $this->facturas;
                break;
            case 'datosUsuario':
                $return = $this->usuario;
                break;
            case 'modDatosUsuario':
                $return = $this->usuario;
                break;
            case 'modDatosCuenta':
                $return = $this->cuentas;
                break;
            case 'paises':
                $return = $this->usuario;
                break;
            case 'ciudades':
                $return = $this->usuario;
                break;
            case 'departamentos':
                $return = $this->usuario;
                break;
            case 'confirmacion':
                $return = $this->usuario;
                break;
            case 'reiniciopassword':
                $return = $this->usuario;
                break;
            case 'resetpassword':
                $return = $this->usuario;
                break;
                
            default :
                $return = '';
                break;
        }
        
       return $return;
    }
}
