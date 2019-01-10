<?php


require_once(getcwd()."/Controllers/CuentasController.php");

Class Cuentas extends Rest{

    private $cuentasController;    
    public function __construct(){
        $this->cuentasController = new CuentasController();
    }
    
    public function consumos($parametros){
        if ($_SERVER['REQUEST_METHOD'] != 'GET')
            $this->response('', 404);
            
        $ipCliente = '';
        $datos = array();
        $datos["token"] = $parametros[1];
        $datos["idCuenta"] = $parametros[2];
        $datos["offset"] = $parametros[3];
        $datos["limit"] = $parametros[4];
        $datos["ipCliente"] = $_SERVER['REMOTE_ADDR'];
       
        return $this->cuentasController->getConsumos($datos);
    }
    
    public function getCuentas($datos){
        
    }
    
    public function cuentas($parametros){
        if ($_SERVER['REQUEST_METHOD'] != 'GET')
            $this->response('', 404);
            
            $ipCliente = '';
      
            $ipCliente = $_SERVER['REMOTE_ADDR'];
            $datos = array();
           
            $datos["token"] = $parametros[1];
            $datos["ipCliente"] = $ipCliente;
            return $this->cuentasController->getCuentas($datos);
    }
    
    public function datosCuenta($parametros){
        if ($_SERVER['REQUEST_METHOD'] != 'GET')
            $this->response('', 404);
            
        $ipCliente = '';
        
        $datos = array();
       
        $datos = json_decode(json_encode($informacion),true);
        $ipCliente = $_SERVER['REMOTE_ADDR'];
        
       
        $datos["token"] = $parametros[1];
        $datos["idCuenta"] = $parametros[2];
        return $this->cuentasController->getDatosCuenta($datos);
    }
    
    public function modDatosCuenta($parametros){
        if ($_SERVER['REQUEST_METHOD'] != 'POST')
            $this->response('', 404);
            
        $ipCliente = '';
        
        $datos = array();
        $json = file_get_contents('php://input');
        $informacion = json_decode($json);
        $datos = json_decode(json_encode($informacion),true);
  
        $datos["ipCliente"] = $_SERVER['REMOTE_ADDR'];
        return $this->cuentasController->modDatosCuenta($datos);
    }
    
    public function bajaCuenta($datos){
        
    }
    
}