<?php

require_once(getcwd()."/lib/Validador/Validador.php");
require_once(getcwd()."/Models/ConsultasModel.php");
require_once(getcwd()."/lib/Response/Response.php");
require_once(getcwd()."/lib/Response/ResponseConsultas.php");
require_once(getcwd()."/lib/Parser.php");

define("SERVICE_A",'A');


Class ConsultasController{
	
    const SERVICIO_A = 'A';
	private $respuesta = array('codigo'=>'','json'=>'');
	private $validador;
	private $response;
	private $servicios;
	
	public function __construct(){
		$this->validador = new Validador();
		
	}

	
	
	public function getPaises($parametros){
	    try {
	        $consultasDAO = new ConsultasModel();
	        $validador = new Validador();
	        $token = '';
	        $token = new Token();
	        $response = new ResponseConsultas("paises");
	        
	        
	        
	        $datos = $token->validaJWT($parametros["token"]);
	        
	        if (empty($datos))
	            throw new Exception('',-1);
	        
            $paises = $consultasDAO->getPaises();
	                
            if ($paises["codigo"] < 0)
                throw new Exception('',$paises["codigo"]);
                
	                    
            return $response->getResponsePaises($paises["codigo"],$paises["datos"]);
	                                
	                                
	    } catch (Exception $e) {
	        return $response->getResponsePaises($e->getCode(),'');
	    }
	}
	
	
	public function getDepartamentos($parametros){
	    try {
	        $consultasDAO = new ConsultasModel();
	        $validador = new Validador();
	        $token = '';
	        $token = new Token();
	        $response = new ResponseConsultas("departamentos");
	        	            
            $datos = $token->validaJWT($parametros["token"]);
	            
            if (empty($datos))
                throw new Exception('',-1);
	                
            if (!$validador->checkNumber($parametros["idPais"]))
                throw new Exception('',-4);
                
	                    
            $departamentos = $consultasDAO->getDepartamentos($parametros["idPais"]);
	                    
            if ($departamentos["codigo"] < 0)
                throw new Exception('',$departamentos["codigo"]);
                
	                        
            return $response->getResponseDepartamentos($departamentos["codigo"],$departamentos["datos"]);
	                        
	                        
	    } catch (Exception $e) {
	        return $response->getResponseDepartamentos($e->getCode(),'');
	    }finally {
	        unset($token);
	        unset($consultasDAO);
	        unset($validador);
	        unset($response);
	    }
	}
	
	public function getCiudades($parametros){
	    try {
	        $consultasDAO = new ConsultasModel();
	        $validador = new Validador();
	        $token = '';
	        $token = new Token();
	        $response = new ResponseConsultas("ciudades");
	        
	       
	            
            $datos = $token->validaJWT($parametros["token"]);
	            
            if (empty($datos))
                throw new Exception('',-1);
	                
            if (!$validador->checkNumber($parametros["idDepartamento"]))
                throw new Exception('',-4);
	                    
	                    
            $ciudades = $consultasDAO->getCiudades($parametros["idDepartamento"]);
	                    
            if ($ciudades["codigo"] < 0)
                throw new Exception('',$ciudades["codigo"]);
                
	                        
            return $response->getResponseCiudades($ciudades["codigo"],$ciudades["datos"]);
	                        
	                        
	    } catch (Exception $e) {
	        return $response->getResponseCiudades($e->getCode(),'');
	    }finally {
	        unset($token);
	        unset($consultasDAO);
	        unset($validador);
	        unset($response);
	    }
	}
}

?>