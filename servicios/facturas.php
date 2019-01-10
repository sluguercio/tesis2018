<?php


require_once(getcwd()."/Controllers/FacturasController.php");

Class Facturas extends Rest{
    
    private $facturasController;
    public function __construct(){
        $this->facturasController = new facturasController();
    }
    
    public function facturas($parametros){
        if ($_SERVER['REQUEST_METHOD'] != 'GET')
            $this->response('', 404);
            
        $ipCliente = '';
        $datos = array();
        $datos["token"] = $parametros[1];
        $datos["idCuenta"] = $parametros[2];
        $datos["offset"] = $parametros[3];
        $datos["limit"] = $parametros[4];
        $datos["ipCliente"] = $_SERVER['REMOTE_ADDR'];
       
        return $this->facturasController->getFacturas($datos);
    }
    
    public function facturaDetalles($parametros){
        if ($_SERVER['REQUEST_METHOD'] != 'GET')
            $this->response('', 404);
            
            $ipCliente = '';
            $datos = array();
            $datos["token"] = $parametros[1];
            $datos["idFactura"] = $parametros[2];
            $datos["offset"] = $parametros[3];
            $datos["limit"] = $parametros[4];
            $datos["ipCliente"] = $_SERVER['REMOTE_ADDR'];
            
            return $this->facturasController->getFacturaDetalles($datos);
    }
    
   
    
}