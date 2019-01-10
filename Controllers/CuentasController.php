<?php

include_once(getcwd()."/Models/CuentasModel.php");
require_once(getcwd()."/lib/Validador/Validador.php");
require_once(getcwd()."/lib/Response/ResponseCuentas.php");
require_once(getcwd()."/lib/token.php");

Class CuentasController{
    
    private $cuentaDAO;
    public function __construct(){
        $this->cuentaDAO = new CuentasModel();
    }
    
    public function getCuentas($parametros){
        try{
        $token = new Token();
        $response = new ResponseCuentas("getCuentas");
        //$datos = $token->validarToken($token);
        $datos = $token->validaJWT($parametros["token"]);
        if (empty($datos))
            throw new Exception('',-1);
        
        $datos = json_decode(json_encode($datos),true);
        $cuentas = $this->cuentaDAO->getCuentas($datos["data"]["idUsuario"]);
        
        if ($cuentas["codigo"] < 0)
           throw new Exception('',$cuentas["codigo"]);
        
        return $response->getResponseCuentas(0, $cuentas["datos"]);    
        
        }        
        catch (Exception $e){
        return  $response->getResponseCuentas($e->getCode(),array());
        }
        
    }
    
    public function getDatosCuenta($parametros){
        try{
            $token = new Token();
            $response = new ResponseCuentas("getDatosCuenta");
            $response->setToken($parametros["token"]);
           // $datos = $token->validarToken($token);
            $datos = $token->validaJWT($parametros["token"]);
            
            if (empty($datos))
                throw new Exception('',-1);
                
            $cuenta = $this->cuentaDAO->getDatosCuentas($parametros["idCuenta"]);
            
            if ($cuenta["codigo"] < 0)
                throw new Exception('',$cuenta["codigo"]);
                    
            return $response->getResponseDatosCuenta(0, $cuenta["datos"]);
                    
        }
        catch (Exception $e){
            return $response->getResponseDatosCuenta($e->getCode(),array());
        }
    }
    
    public function modDatosCuenta($parametros){
        try{
            $token = new Token();
            $response = new ResponseCuentas("modDatosCuenta");
            if ((!is_numeric($parametros["idCuenta"])) || (!is_numeric($parametros["facturaElectronica"])) || (!is_numeric($parametros["avisoCorte"])))
                throw new Exception('',-1);
            
            $datos = $token->validarToken($token);
            
            $datos = $token->validaJWT($parametros["token"]);
            
            if (empty($datos))
                throw new Exception('',-4);
                
            $cuenta = $this->cuentaDAO->modDatosCuenta($parametros);
            if ($cuenta < 0)
                throw new Exception('',$cuenta["codigo"]);
                
            return $response->getResponseModCuenta($cuenta["codigo"]);
                    
        }
        catch (Exception $e){
            return $response->getResponseModCuenta($e->getCode());
        }
    }
    
    
    public function getConsumos($parametros){
        try{
            $token = new Token();
            $response = new ResponseFacturas("consumos");
           // $datos = $token->validarToken($datos["token"]);
            $response->setToken($parametros["token"]);
            $datos = $token->validaJWT($parametros["token"]);
            if (empty($datos))
                throw new Exception('',-1);
                
                
            $consumos = $this->cuentaDAO->getConsumos($parametros["idCuenta"],$parametros["limit"],$parametros["offset"]);
            if ($consumos["codigo"] < 0)
                throw new Exception('',$consumos["codigo"]);
                    
            return $response->getResponseConsumos($consumos["codigo"],$consumos["datos"]);
                    
        }
        catch (Exception $e){
            return $response->getResponseConsumos($e->getCode(),'');
        }
    }
}
    