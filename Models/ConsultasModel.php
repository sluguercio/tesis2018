<?php

require_once('DBConnect.php');


Class ConsultasModel extends DBConnect{
    
    
    
    public function __construct(){
           
    }
    
    public function getPaises(){
        try {
            
            $conexion = parent::createConnection();
            
            
            $sql = 'SELECT
            p.idPais,
            p.nombrePais,
            p.codPais
            FROM Pais p';
            
            
            $query=$conexion->query($sql);
            
            if ( (!$conexion) || (!$query) )
                throw new Exception('',-2);
                
            if ( $query->num_rows == 0 )
                throw new Exception('',-3);
                  
            $respuesta = array();
            $item = mysqli_fetch_assoc($query);
            while ($item != FALSE){
                array_push($respuesta, $item);
                $item = preg_replace("/[^a-zA-Z0-9\_\-]+/", "",mysqli_fetch_assoc($query));
            }
            
            return array('datos' => $respuesta,'codigo' => 0);
                    
        }catch (Exception $e) {
            return array('datos'=>'','codigo'=>$e->getCode());
        }
              
    }
    
    public function getDepartamentos($idPais){
        try {
            
            $conexion = parent::createConnection();
            
            
            $sql = 'SELECT
            d.idDepartamento,
            d.nombreDepartamento
            FROM Departamento d 
            WHERE d.idPais = '.$idPais;
            
            
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
    
    
    public function getCiudades($idDepartamento){
    try {
            
            $conexion = parent::createConnection();
            
            
            $sql = 'SELECT
            c.idCiudad,
            c.nombreCiudad
            FROM Ciudad c
            WHERE c.idDepartamento = '.$idDepartamento;
            
            
            $query=$conexion->query($sql);
            
            if ( (!$conexion) || (!$query=$conexion->query($sql)) )
                throw new Exception('',-2);
                
            if ( $query->num_rows == 0 )
                 throw new Exception('',-3);
              
             $respuesta = array();
             $item = mysqli_fetch_array($query,MYSQLI_ASSOC);
             while ($item != FALSE){
                 array_push($respuesta, $item);
                 $item = preg_replace("/[^a-zA-Z0-9\_\-]+/", "",mysqli_fetch_assoc($query));
             }
            
            return array('datos' => $respuesta,'codigo' => 0);
                    
        }catch (Exception $e) {
            return array('datos'=>'','codigo'=>$e->getCode());
        }
        
    }
    
}

?>