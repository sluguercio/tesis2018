<?php

include_once(getcwd()."/Models/CuentasModel.php");
include_once(getcwd()."/Models/FacturasModel.php");
require_once(getcwd()."/lib/Validador/Validador.php");
require_once(getcwd()."/lib/Response/ResponseCuentas.php");
require_once(getcwd()."/lib/Response/ResponseFacturas.php");
require_once(getcwd()."/lib/token.php");

Class FacturasController{
    
    private $facturasDAO;
    public function __construct(){
        $this->facturasDAO = new FacturasModel();
    }
    
 
    
    public function getFacturas($parametros){
        try{
            $token = new Token();
            $response = new ResponseFacturas("facturas");
            // $datos = $token->validarToken($datos["token"]);
            $response->setToken($parametros["token"]);
            $datos = $token->validaJWT($parametros["token"]);
            if (empty($datos))
                throw new Exception('',-1);
                
                
            $facturas = $this->facturasDAO->getFacturas($parametros["idCuenta"],$parametros["limit"],$parametros["offset"]);
            if ($facturas["codigo"] < 0)
                throw new Exception('',$facturas["codigo"]);
                    
            return $response->getResponseFacturas($facturas["codigo"],$facturas["datos"]);
                    
        }
        catch (Exception $e){
            return $response->getResponseFacturas($e->getCode(),'');
        }
    }
    
    public function getFacturaDetalles($parametros){
        try{
            $token = new Token();
            $response = new ResponseFacturas("facturaDetalles");
            // $datos = $token->validarToken($datos["token"]);
            $response->setToken($parametros["token"]);
            $datos = $token->validaJWT($parametros["token"]);
            if (empty($datos))
                throw new Exception('',-1);
                
                
            $facturas = $this->facturasDAO->getFacturaDetalles($parametros["idFactura"]);
            if ($facturas["codigo"] < 0)
                throw new Exception('',$facturas["codigo"]);
                    
            return $response->getResponseFacturasDetalles($facturas["codigo"],$facturas["datos"]);
                    
        }
        catch (Exception $e){
            return $response->getResponseFacturasDetalles($e->getCode(),'');
        }
    }
}
