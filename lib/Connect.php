<?php


Class Connect {

	

	public function __construct(){
		
	}

	

	public function StoreToken($usuario,$token,$expirationTime,$idToken){
		$serverName = "UPE522.Usina00.Local";
		$userName = "sa";
		$password = "usinatandilnigro575";
		$database = "ClientesGino";
		$con = array("UID"=>$userName, "PWD"=>$password, "Database"=>$database, "CharacterSet"=>"UTF-8");
		$conexion  = sqlsrv_connect($serverName,$con);
		//var_dump($expirationTime);
		$fecha_alta = date("d-m-Y H:i:s");
		$expirationTime = date("d-m-Y H:i:s",$expirationTime);
		//var_dump($fecha_alta);
		$sql = 'Insert Into Token (IdToken,Usuario,fecha_alta,fecha_baja,token,estado)
		 values ('."'".$idToken."'".','.$usuario.','."'".$fecha_alta."'".','."'".$expirationTime."'".','."'".$token."'".',1)';
		
		$check = 'Select * from Token where  Usuario ='.$usuario;
		//	var_dump(sqlsrv_query($conexion,'Select * from Plantillas'));
		$queryCheck = sqlsrv_query($conexion,$check);

		

		

		try{
			if ( (!($queryCheck)) or (sizeof((sqlsrv_fetch_array($queryCheck))) >= 1 ) ){
				throw new Exception();
			}
			else
				if (!($query  = sqlsrv_query($conexion,$sql))){
					throw new Exception();
				}else{
					sqlsrv_close($conexion);
					return TRUE;
				}
		}
		catch(Exception $e){
			sqlsrv_close($conexion);
			return FALSE;
		}
			
	}


	public function getToken(){
		$serverName = "UPE522.Usina00.Local";
		$username = "sa";
		$password = "usinatandilnigro575";
		$database = "ClientesGino";
		$conexion  = sqlsrv_connect($serverName, array("UID"=>$username, "PWD"=>$password, "Database"=>$database, "CharacterSet"=>"UTF-8"));
		
		$sql = 'EXEC spWS_getToken '.$usuario;

		try{
			if (!($query=sqlsrv_query($conexion,$sql))){
				
				throw new Exception();
			}else{
				if (sizeof(sqlsrv_fetch_array($query)) > 1){
					throw new Exception();
				}
				else{
					sqlsrv_close($conexion);
					return "S-T01";
				}
					
				
			}
		}
		catch(Exception $e){
			sqlsrv_close($conexion);
			return "E-T01";
		}
	}
}