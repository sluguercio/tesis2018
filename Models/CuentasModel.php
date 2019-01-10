<?php
Class CuentasModel extends DBConnect{
    
    public function __construct(){
        
    }
    
    public function getConsumos($idCuenta,$limit=12,$offset=0){
        try {
            if ($limit == "") $limit = 12;
            if ($offset == "") $offset = 0;
            
            $conexion = parent::createConnection();
            
            $sql = 'SELECT
            c.idConsumo,
            c.mes,
            c.anio,
            c.cantidad
            FROM Consumo c
	        WHERE c.idCuenta = '.$idCuenta.'
            ORDER BY c.anio,c.mes
            LIMIT '.$limit.'
            OFFSET '.$offset;
            
            
        $query=$conexion->query($sql);
            
        if ( (!$conexion) || (!$query) )
            throw new Exception('',-2);
                
        if ( $query->num_rows == 0 )
            throw new Exception('',-3);
                    
       $response = array();
       while ($respuesta = mysqli_fetch_array($query,MYSQLI_ASSOC)){
           array_push($response, $respuesta);
       }
        return array('datos' => $response,'codigo' => 0);
                    
        }catch (Exception $e) {
            return array('datos'=>'','codigo'=>$e->getCode());
        }
        
    }
    
    
    
    public function getDatosCuentas($idCuenta){
        try {
            
            $conexion = parent::createConnection();
            
            $sql = 'SELECT
            c.calle,
            c.puerta,
            c.piso,
            c.departamento,
            c.fechaAlta,
            c.facturaElectronica,
            c.avisoCorte
            FROM Cuenta c
	        WHERE  c.idCuenta = '.$idCuenta.'
            AND c.fechaBaja IS NULL';
            
            
            $query=$conexion->query($sql);
            
            if ( (!$conexion) || (!$query) )
                throw new Exception('',-2);
                
            if ( $query->num_rows == 0 )
                throw new Exception('',-3);
                    
                    
            $respuesta = mysqli_fetch_array($query,MYSQLI_ASSOC);
            $respuesta["fechaAlta"] =  date("U",strtotime($respuesta["fechaAlta"]));
            return array('datos' => $respuesta,'codigo' => 0);
                    
        }catch (Exception $e) {
            return array('datos'=>'','codigo'=>$e->getCode());
        }
        
    }
    
    public function getCuentas($idUsuario){
    try {
        
        $conexion = parent::createConnection();
        
        $sql = 'SELECT
            c.idCuenta,
            c.calle,
            c.puerta,
            c.piso,
            c.departamento,
            c.fechaAlta,
            c.facturaElectronica,
            c.avisoCorte
            FROM Cuenta c
	        WHERE c.idUsuario = '.$idUsuario.'
            AND c.fechaBaja IS NULL';
        
        
        $query=$conexion->query($sql);
        
        if ( (!$conexion) || (!$query) )
            throw new Exception('',-2);
            
        if ( $query->num_rows == 0 )
            throw new Exception('',-3);
                
        $respuesta = array();
        $item = mysqli_fetch_array($query,MYSQLI_ASSOC); 
        while ($item != FALSE){
            $item["fechaAlta"] = date("U",strtotime($item["fechaAlta"]));
            array_push($respuesta, $item);
            $item = mysqli_fetch_array($query,MYSQLI_ASSOC);
        }
        return array('datos' => $respuesta,'codigo' => 0);
                
    }catch (Exception $e) {
        return array('datos'=>'','codigo'=>$e->getCode());
    }
    }
    
    public function modDatosCuenta($datos){
        try {
            
            $conexion = parent::createConnection();
            
            $sql = 'UPDATE Cuenta c
            SET
            c.facturaElectronica = '."'".$datos["facturaElectronica"]."'".',
            c.avisoCorte = '.$datos["avisoCorte"].'
	        WHERE c.idCuenta = '.$datos["idCuenta"].'
            AND c.estado = 1';
            
            
            $query=$conexion->query($sql);
            
            if ( (!$conexion) || (!$query))
                throw new Exception('',-2);
                
            if ($conexion->affected_rows == -1)
                throw new Exception('',-3);
                    
                    
            return array('datos' => '','codigo' => 0);
                    
        }catch (Exception $e) {
            return array('datos'=>'','codigo'=>$e->getCode());
        }
        
    }
    
    public function bajaCuenta($idCuenta,$idUsuario){
        
    }
    
}