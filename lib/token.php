<?php


use Firebase\JWT\JWT;
require_once ("vendor/autoload.php");
// require_once(getcwd()."/Model/TokenModel.php");
require_once(getcwd()."/config/config.php");

if (!defined('CLAVEINTERNA')) define('CLAVEINTERNA', '%1my2d*_$'); 

class Token {
	private $config;
	public function  __construct(){
		$this->config = new config();
	}
	
	private function getParametroToken($parametro,$token){
	   
	    $arreglo = explode('.',$token);
	    $payload = (array)(json_decode(base64_decode($arreglo[1])));
	    return $payload[$parametro];
	}
	
	public function checkTipo($tipo,$token){
	 
	    $arreglo = explode('.',$token);
	    $payload = (array)(json_decode(base64_decode($arreglo[1])));
	    $data = (array)$payload["data"];
	    if ($data["tipo"] == $tipo)
	        return TRUE;
	    return FALSE;
	}
	
	

	public function getNroDocumento($token){
		
		$arreglo = explode('.',$token);
		$payload = (array)(json_decode(base64_decode($arreglo[1])));
		$data = (array)$payload["data"];
		return $data["documento"];
	}
    
	
	public function getNick($token){
		
		$arreglo = explode('.',$token);
		$payload = (array)(json_decode(base64_decode($arreglo[1])));
		$data = (array)$payload["data"];
		return $data["nick"];
	}
	
	
	public function getIdUsuario($token){
	    
	    $arreglo = explode('.',$token);
	    $payload = (array)(json_decode(base64_decode($arreglo[1])));
	    $data = (array)$payload["data"];
	    return $data["idUsuario"];
	}


	
/*
============================================================================================================================
METODO ENCARGADO DE VALIDAR EL HASH GENERADO PARA USUARIO, CON EL TOKEN QUE SE LE ASIGNO
============================================================================================================================
*/	
	private function checkHash($token,$idSession,$sign){

		$arreglo = explode('.',$token);
		$payload = (array)(json_decode(base64_decode($arreglo[1])));
		$data = (array)$payload["data"];
		
		$idUniq = $data["UniqId"];
	    $IdS= hash('SHA512','PED'+$idUniq+$data["serialNumber"]+$data['A']);
		
		$cuit = rtrim(strtr(base64_encode($data["serialNumber"]), '+/', '-_'), '=');
		$empresa = rtrim(strtr(base64_encode($data["O"] ), '+/', '-_'), '=');
 		$localidad = rtrim(strtr(base64_encode($data["ST"]), '+/', '-_'), '=');
		$pais = rtrim(strtr(base64_encode($data["C"]), '+/', '-_'), '=');
		$agenteId = rtrim(strtr(base64_encode($data["A"]), '+/', '-_'), '=');
		$tokenId64 = rtrim(strtr(base64_encode($payload["jti"]), '+/', '-_'), '=');
		
		$I = $cuit.$empresa.$localidad.$pais.$tokenId64.$arreglo[2];
		

		$ID = hash_hmac('sha512',$I,$IdS);
		
		if ($ID === $idSession) 
			return TRUE;
		else
			return FALSE;
	
	}

/*
============================================================================================================================
METODO ENCARGADO DE VALIDAR LOS TIEMPOS DE GENERACION Y EXPIRACION DEL TOKEN Y QUE EL MISMO NO ESTE VENCIDO
============================================================================================================================
*/

	private function checkTime($token){
		$arreglo = explode('.',$token);
		$payload = (array)json_decode(base64_decode(rtrim(strtr($arreglo[1], '-_', '+/'))));
		

		if ( ($payload["exp"] > time())  )
			return TRUE;
		else
			return FALSE;
	}

/*
============================================================================================================================
METODO ENCARGADO DE VALIDAR LA FIRMA DEL TOKEN
============================================================================================================================
*/
	private function checkSign($token,$sign){
			
			$arreglo = explode('.',$token);
			$signatureIn = $arreglo[2];
			//$datos = rtrim(strtr(base64_decode($signatureIn), '+/', '-_'), '=');
			$sign = base64_decode($sign);
			$public_key = openssl_pkey_get_public("file:///opt/webservice/public.key");
			$result_firma = openssl_verify($signatureIn, $sign, $public_key,"sha512WithRSAEncryption");

		
			if ($result_firma) 
				return TRUE;
			else
				return FALSE;
	}
	
	

/*
============================================================================================================================
METODO ENCARGADO DE VALIDAR LAS PROPIEDADES DEL TOKEN
============================================================================================================================
*/

	public function validarToken($token){
		
	    $exp = $this->getParametroToken('exp',$token);
	  
	    if ( ($exp > date('U')) || ($exp == 0) )
		  return TRUE;
		return FALSE;
	}


/*
============================================================================================================================
METODO ENCARGADO DE DEVOLVER EL TOKEN QUE LE FUE ASIGNADO AL USUARIO
============================================================================================================================
*/	

	public function getToken($usuario){
		
		$serverName = "UPE523.Usina00.Local";
		$username = "sa";
		$password = "usinatandilnigro575";
		$database = "Clientes";
		$conexion  = sqlsrv_connect($serverName, array("UID"=>$username, "PWD"=>$password, "Database"=>$database, "CharacterSet"=>"UTF-8"));
		
		$sql = 'EXEC spWS_getToken '.$usuario;
		

		try{
			if (!($query=sqlsrv_query($conexion,$sql))){
				throw new Exception();
			}else{
				return sqlsrv_fetch_array($query)[0];
				
			}
		}
		catch(Exception $e){
			return "E-T01";
		}
	
	}

	

	
/*
============================================================================================================================
METODO ENCARGADO DE LA GENERACION DEL TOKEN
============================================================================================================================
*/	
	public function generar_token($data){

		//-------------------------------------------------------------------
		// secretKey
		//-------------------------------------------------------------------
		$idUniq = uniqid($data[documento],TRUE);
		$secretKey = hash('SHA512','tesis', 'tesis2018');
		$IdSession = hash('SHA512',$idUniq+$data["email"]+$data["password"]+date());

		//-------------------------------------------------------------------
		// header
		//-------------------------------------------------------------------
		$header = array(
				'alg' => 'HS512',
				'typ' => 'JWT'
		);


		//-------------------------------------------------------------------
		// payload
		//-------------------------------------------------------------------
		$tokenId   =  random_bytes (32);
		$tokenId   =  base64_encode($tokenId);
		
		
		$issuedAt   =  date('U'); //FECHA DE GENERACION 
		$notBefore =  $issuedAt + 1; //Agregando medio segundo
		
		
		// Agregando tiempo
		$expire = $issuedAt + 1000; //TIEMPO EN EL QUE EXPIRA EL TOKEN
		
		$serverName = 'tesis2018.com.ar';// nombre del servidor
		
		$payload = array(
				//'aud' => $aud,
				//'sub' => $sub,
				'iat'   => $issuedAt,  // Tiempo en el que fue generado el token
				'jti'   => $tokenId,   //Identificacion unica del token
				'iss'   => $serverName,// Nombre del servidor
				'nbf'  => $notBefore,  // Tiempo en el que el token tiene validez
				'exp'  => $expire,     // Tiempo en que el token expira
				'data' => array(       // Informacion del usuario
				        'idUsuario' => $data["idUsuario"],
						'tipoDocumento' => $data["tipoDocumento"],
				        'documento'     => $data["documento"],  // Nombre de usuario
						'email'    => $data["email"],
				        'password'   => $data["password"],
				        'nombre'   => $data["nombre"],
				        'apellido'   => $data["apellido"],
				        'direccion'   => $data["direccion"],
				        'fechaNacimiento'   => $data["fechaNacimiento"],
				        'idUniq'   => $idUniq,
				        'idSession' => $idSession
				        
				)
		);

		//-------------------------------------------------------------------

		$jheader  = json_encode($header);
		$jpayload = json_encode($payload);
		$b64header  = base64_encode($jheader);
		$b64payload = rtrim(strtr(base64_encode($jpayload), '+/', '-_'), '=');
	

		$token = $b64header . '.' . $b64payload ;
				
		$ID = hash_hmac('sha512',$token,$IdSession);
		
		
		$resp = array("token"=>base64_encode($token),"tokenId"=>$ID,"expire"=>$expire);
		return $resp;
	}
	
	public function generaJWT($datos){
	    $config = new config();
	    
	    $tokenId   =  random_bytes (32);
	    $tokenId   =  base64_encode($tokenId);
	    
	    
	    $issuedAt   =  date('U'); //FECHA DE GENERACION
	    $notBefore =  $issuedAt + 1; //Agregando medio segundo
	    
	    
	    // Agregando tiempo
	    $expire = $issuedAt + 100000; //TIEMPO EN EL QUE EXPIRA EL TOKEN
	    
	    $serverName = 'tesis2018.com.ar';// nombre del servidor
	    
	    $payload = array(
	        //'aud' => $aud,
	        //'sub' => $sub,
	        'iat'   => $issuedAt,  // Tiempo en el que fue generado el token
	        'jti'   => $tokenId,   //Identificacion unica del token
	        'iss'   => $serverName,// Nombre del servidor
	        'nbf'  => $notBefore,  // Tiempo en el que el token tiene validez
	        'exp'  => $expire,     // Tiempo en que el token expira
	        'data' => array(       // Informacion del usuario
	            'idUsuario' => $datos["idUsuario"],
	            'tipoDocumento' => $datos["tipoDocumento"],
	            'documento'     => $datos["documento"],  // Nombre de usuario
	            'idRol' => $datos["idRol"]
	        )
	    );
	    $token = JWT::encode($payload, $config->getKey());
	   return $token;
	}
	
	public function validaJWT($jwt){
	    try{
	   $config = new config();
	    $datos = array();
	    $datos = JWT::decode($jwt, $config->getKey(),array('HS256'));
	    $datos = json_decode(json_encode($datos),true);
	    return $datos;
	    }
	    catch (Exception $e){
	        return $datos;
	    }
	    
	}
	

}

?>