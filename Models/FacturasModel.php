<?php

Class FacturasModel extends DBConnect{
    
    public function __construct(){
        
    }
    
    public  function getFacturas($idCuenta,$offset=0,$limit=12){
        try {
            if ($offset == "") $offset = 0;
            if ($limit == "") $limit = 12;
            
            
            $conexion = parent::createConnection();
            
            
            $sql = 'SELECT
            f.fechaEmision,
            f.fechaVencimiento,
            f.cuit,
            f.paga,
            f.idCuenta
            FROM Factura f
            WHERE f.idCuenta = '.$idCuenta.'
            ORDER BY f.fechaEmision
            LIMIT '.$limit.'
            OFFSET '.$offset;
            
            
            $query=$conexion->query($sql);
            
            if ( (!$conexion) || (!$query=$conexion->query($sql)) )
                throw new Exception('',-2);
                
            if ( $query->num_rows == 0 )
                throw new Exception('',3);
                    
            $respuesta = array();
            $item = mysqli_fetch_array($query,MYSQLI_ASSOC);
            while ($item != FALSE){
                $item["fechaEmision"] = date("U",strtotime($item["fechaEmision"]));
                $item["fechaVencimiento"] = date("U",strtotime($item["fechaVencimiento"]));
                array_push($respuesta, $item);
                $item = mysqli_fetch_array($query,MYSQLI_ASSOC);
            }
                 
          
            return array('datos' => $respuesta,'codigo' => 0);
                    
        }catch (Exception $e) {
            return array('datos'=>'','codigo'=>$e->getCode());
        }
        
    }
    
    public  function getFacturaDetalles($idFactura){
        try {
            
            $conexion = parent::createConnection();
            
            
            $sql = 'SELECT
            r.idRenglonFactura as NroDetalle,
            r.descripcion,
            r.cantidad,
            r.monto
            FROM RenglonFactura r
            WHERE r.idFactura ='.$idFactura;
            
            
            $query=$conexion->query($sql);
            
            if ( (!$conexion) || (!$query=$conexion->query($sql)) )
                throw new Exception('',-2);
                
            if ( $query->num_rows == 0 )
                throw new Exception('',-3);
                 
            $respuesta = array();
            $item = mysqli_fetch_array($query,MYSQLI_ASSOC);
            while ($item != FALSE){
                array_push($respuesta, $item);
                $item = mysqli_fetch_array($query,MYSQLI_ASSOC);
            }
                    
           
            return array('datos' => $respuesta,'codigo' => 0);
            
        }catch (Exception $e) {
            return array('datos'=>'','codigo'=>$e->getCode());
        }
        
    }
    
}