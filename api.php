<?php
    	
	require_once("servicios/Rest.inc.php");
	require_once("config/route.php");
	require_once("servicios/Usuario.php");
	require_once("servicios/cuentas.php");
	require_once("servicios/facturas.php");
	
class API extends REST {
	   
        private $route;
			
		public function __construct(){
		    parent::__construct();
			$this->route = new Route();
		}
		
		public function processApi(){
		    try {
		        
		        error_reporting(1);
		        //Obtiene el nombre del servicio
		       // $datos = strtolower(trim(str_replace("/","",$_REQUEST['rquest'])));
		        $datos = explode("/", $_REQUEST['rquest']);
		        $func = $datos[0];
		        
		        //Obtiene la clase a instanciar
		        $clase = $this->route->getRoute($func);
		        
		        if ( ($clase == '') || ($clase == NULL ) )
		            throw new Exception('',404);
		            
		            $servicio = new $clase();
		            $resp = $servicio->$func($datos);
		            $this->response($this->json($resp), 200);
		    
		            	
		    } catch (Exception $e) {
		        $this->response('',$e->getCode());
		    }
			
			
		}
		
			
	
		private function json($data){
			if(is_array($data)){
				return json_encode($data);
			}
		}

	}


	
	// Initiiate Library
    
	$api = new API;
	$api->processApi();
	
	

	//var_dump($api->validarCuit('1'));

?>