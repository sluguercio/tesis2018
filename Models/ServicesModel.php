<?php 



include_once('DBConnect.php'); 

Class ServicesModel extends DBConnect{

	public function __construct(){

	}

/*
======================================================================================================================================
METODO ENCARGADO DE ALMACENAR EN EL LOG DE LA BASE DE DATOS TODA LA INFORMACION DEL SERVICIO QUE SE CONSUMIO
======================================================================================================================================
*/
	public function StoreService($ipCliente,$nombreServicio,$status,$codigo,$mensaje,$mensajeInterno,$usuario='',$password='',$nroDoc=0,$token='',$conexion='')
	{
	    if ($conexion == '')
		  $conexion = parent::createConnection();	
		
		$fecha = date("d-m-Y h:i:s");
		
		$options =  array( "Scrollable" => SQLSRV_CURSOR_KEYSET );
		$params = array($nombreServicio,$fecha,$status,$codigo,$mensaje,$mensajeInterno,$usuario,$password,$nroDoc,$token,$ipCliente);
		
		$sql = 'Insert Into RE_LogServicios 
		(nombreServicio,fechaEjecucion,status,codigo,mensaje,mensajeInterno,usuario,password,NroDocumento,token,ipCliente)
		 values 
		 (?,?,?,?,?,?,?,?,?,?,?)';

		$query = sqlsrv_query($conexion,$sql,$params,$options);
		
		try{

			if (!($query))
				throw new Exception();
			
				
				return TRUE;
			
		}
		catch(Exception $e){
			
			return FALSE;
		}

	}
}