<?php
Class Certificado{

	public function __contruct(){

	}

	public function firmaCSR($datos){
		$privateKey = openssl_pkey_get_private('file:///tmp/private.pem','contraseña'); // Levanta la clave privada

		if ($privateKey != false){

			$configargs = array('digest_alg' => 'sha512WithRSAEncryption');  // Configuracion que especifica el algoritmo de encriptacion
			$csr_firmado = openssl_csr_sign($datos, "file:///tmp/mycertificate.crt", $privateKey,365,$configargs); // Firma el CSR con la clave privada
			if ($csr_firmado != false)
			 	return $csr_firmado;
			 else
			 	return false;
		
		}	
		return false;
	
	}
		


	

		/*public function firmaCSR($csr){
		$privateKey = openssl_pkey_get_private('file:///tmp/private.pem','contraseña');

		if ($privateKey != false){
			 $firma = "";
			//$datos = rtrim(strtr(base64_encode($datos), '+/', '-_'), '=');
			 //if (openssl_sign($datos, $firma, $privateKey, OPENSSL_ALGO_SHA256)){
			$csr = openssl_csr_sign($csr, NULL, $privateKey,365,array('digest_alg' => 'sha256'));
			 if ($csr != false){
			 	//file_put_contents('/tmp/signature.dat', $firma);
			 	openssl_x509_export($csr, $certout);
			 	
				//echo $certout;
			 	return $certout;
			 	//return rtrim(strtr(base64_encode($csr), '+/', '-_'), '=');
			 }
		}
		return false;


	}



	public function validaCSR($firma,$datos){
		//$datos = rtrim(strtr(base64_encode($datos), '+/', '-_'), '=');
		$clavePublica = openssl_pkey_get_public('file:///tmp/public.pem');
		if ($clavePublica != false){
			/*if (openssl_verify($datos,base64_decode(rtrim(strtr($firma, '-_', '+/'))), $clavePublica,'sha256WithRSAEncryption')){
				openssl_free_key($clavePublica);
				return true;
			}
			if (openssl_verify($datos,$firma,$clavePublica))
			return true;
		}
		return false;
	}	*/
}


?>