<?php

require_once(getcwd().'/Models/ServicesModel.php');
include_once(getcwd().'/Models/DBConnect.php');

//require_once("/var/www/html/lib/DBConnect.php");


Class TokenModel extends DBConnect{
    private $servicios;
	public function __construct(){
        $this->servicios = new ServicesModel();
	}
	
	public function storeToken($autenticacion,$datosLog){
	    try {
	        
	    $conexion = parent::createConnection();
	    $options =  array( "Scrollable" => SQLSRV_CURSOR_KEYSET );
	    $fecha_actual = date('d-m-Y H:i:s');
	    $fecha_expire = date('d-m-Y H:i:s',$autenticacion["expire"]);
	    $params = array($autenticacion["tokenId"],$autenticacion["token"],$fecha_actual,1,$datosLog["idUsuario"]);
	    $sql = 'INSERT INTO 
                Token (TokenHash,jwt,estado,fechaGeneracion,fechaExpiracion,idUsuario)
                VALUES 
                ('."'".$autenticacion["tokenId"]."'".',
                '."'".$autenticacion["token"]."'".',
                1,
                '."'".$fecha_actual."'".',
                '."'".$fecha_expire."'".',
                '.$datosLog["idUsuario"].')';
       
	    
	    $query = $conexion->query($sql);
    
	    
	    if ( (!$conexion) || (!$query) )
	       throw new Exception('',-21);
	    
	    $mensaje = 'Token generado exitosamente';
	   // $logServicios = $this->servicios->StoreService($datosLog["ipCliente"], 'login', success, 200, $mensaje, $mensaje,$datosLog["nick"],$datosLog["password"],$datosLog["nroDocumento"],$datosLog["token"],$conexion);
	    
	   
	    
	    $conexion->close();
	        
	    return 0;
	                
	             
	    } catch (Exception $e) {
	        if (!(!$conexion))
	        {
	            sqlsrv_rollback($conexion);
	            sqlsrv_close($conexion);
	        }
	        return $e->getCode();
	    }
	        
	}

	

/*
================================================================================================================================
METODO ENCARGADO DE DEVOLVER EL TOKEN CORRESPONDIENTE AL USUARIO
================================================================================================================================
*/

	public function getToken($tokenId){

		$conexion = parent::createConnection();
		$params = array($tokenId,1);
		$options =  array( "Scrollable" => SQLSRV_CURSOR_KEYSET );	

		$sql = 'SELECT token FROM RE_Token where idToken = ? and valido = ?';

		
		try{
			$respuesta = '';
		    if ( (!$conexion) || (!($query=sqlsrv_query($conexion,$sql,$params,$options))) )
				throw new Exception('',-21);
			
		    if (sqlsrv_num_rows($query) < 1)
		          throw new Exception('',-3);
		      
    		$respuesta = sqlsrv_fetch_array($query)[0];
    		sqlsrv_close($conexion);
    		
    		return array('datos' => $respuesta,'codigo' => 0);
			
			
		}
		catch(Exception $e){
		    if (!(!$conexion))
		        sqlsrv_close($conexion);
		    return  array('datos' => $respuesta,'codigo' => $e->getCode() );
		}
	}

/*
================================================================================================================================
METODO ENCARGADO DE DAR DE BAJA UN DETERMINADO TOKEN
================================================================================================================================
*/

	public function setEstadoToken($usuario){

		
		//$conexion  = sqlsrv_connect(SERVERNAME, array("UID"=>USERNAME, "PWD"=>PASSWORD, "Database"=>DATABASE, "CharacterSet"=>"UTF-8"));
		$conexion = parent::createConnection();
		$sql = "spWS_setEstadoToken ".$usuario;

		$transaccion = sqlsrv_begin_transaction($conexion);
		$query = sqlsrv_query($conexion,$sql);
		
		try
		{
			if (!($query)){
				throw new Exception();
			}
			else
			{
				sqlsrv_commit($conexion);
				sqlsrv_close($conexion);
				return TRUE;
			}
		}
		catch(Exception $e){
			sqlsrv_rollback($conexion);
			sqlsrv_close($conexion);
			return FALSE;
		}
	}


/*
================================================================================================================================
METODO ENCARGADO DE DEVOLVER EL ID DEL AGENTE RECAUDADOR CORRESPONDIENTE AL NUMERO DE CUIT ENVIADO POR PARAMETRO
================================================================================================================================
*/
	public function getAgenteId($cuit){

		//$conexion  = sqlsrv_connect(SERVERNAME, array("UID"=>USERNAME, "PWD"=>PASSWORD, "Database"=>DATABASE, "CharacterSet"=>"UTF-8"));
		$conexion = parent::createConnection();
		$params = array($cuit);
		$options =  array( "Scrollable" => SQLSRV_CURSOR_KEYSET );

		$sql = 'SELECT AgenteRecaudadorId FROM WSIEAgentesRecaudadores WHERE CUIT=?';

		$query = sqlsrv_query($conexion,$sql,$params,$options);
		
		try
		{
			if (!($query) ) {
				throw new Exception(-30);
			}
			else{
				if ( (sqlsrv_num_rows($query)) == 0 ) {
					throw new Exception(-31);
				}
				else{
				$r = sqlsrv_fetch_array($query);
				sqlsrv_close($conexion);
				return $r[0];
				}
			}
		}
		catch(Exception $e){
			return $e->getMessage();
		}

	}


}