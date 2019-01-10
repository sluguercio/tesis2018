<?php
Class Validador{

	public function __construct(){
		
	}
	
	public function checkLong($var,$long){
	    if (strlen($var) <= $long)
	        return TRUE;
	    return FALSE;
	}
	
	public function caracteresEspeciales($variable=''){
	    if ( (!preg_match("/\*/", $variable)) && (!preg_match("/\;/", $variable)) && (!preg_match("/\#/", $variable))
	        && (!preg_match('/\$/', $variable)) && (!preg_match('/=/', $variable)) && (!preg_match('/</', $variable))
	        && (!preg_match('/>/', $variable)) && (!preg_match('/\?/', $variable)) && (!preg_match('/!/', $variable))
	        && (!preg_match('/%/', $variable)) &&  (!preg_match('/@/', $variable))
	        && (!preg_match('/(delete)/i', $variable)) && (!preg_match('/(truncate)/i', $variable)) && (!preg_match('/(drop)/i', $variable))
	        && (!preg_match('/(remove)/i', $variable)) && (!preg_match('/(update)/i', $variable))
	        && ($variable != '') and ($variable != NULL) )
	        return true;
	        return false;
	}
	
	
/*
 ===================================================================================================
 METODO PRIVADO ENCARGADO DE VALIDAR LOS DATOS LOS CARACTERES ESPECIALES SOBRE EL NOMBRE
 ===================================================================================================
 */
	public function caracteresEspecialesNombre($variable=''){
	    if ( (preg_match("/^[aA-zZ0-9]+$/", $variable))
	        && (!preg_match('/(delete)/i', $variable)) && (!preg_match('/(truncate)/i', $variable)) && (!preg_match('/(drop)/i', $variable))
	        && (!preg_match('/(remove)/i', $variable)) && (!preg_match('/(update)/i', $variable))
	        && ($variable != '') && ($variable != NULL) )
	        return true;
	   return false;
	}
	
/*
 ===================================================================================================
 METODO PRIVADO ENCARGADO DE VALIDAR LOS DATOS LOS CARACTERES ESPECIALES SOBRE EL PASSWORD
 ===================================================================================================
 */
	public function caracteresEspecialesPassword($variable=''){
	    if ( (!preg_match("/\*/", $variable)) && (!preg_match("/\;/", $variable)) && (!preg_match("/\#/", $variable))
	        && (!preg_match('/\$/', $variable)) && (!preg_match('/=/', $variable)) && (!preg_match('/</', $variable))
	        && (!preg_match('/>/', $variable)) && (!preg_match('/\?/', $variable)) && (!preg_match('/!/', $variable))
	        && (!preg_match('/%/', $variable)) &&  (!preg_match('/@/', $variable))
	        && (!preg_match('/(delete)/i', $variable)) && (!preg_match('/(truncate)/i', $variable)) && (!preg_match('/(drop)/i', $variable))
	        && (!preg_match('/(remove)/i', $variable)) && (!preg_match('/(update)/i', $variable))
	        && ($variable != '') and ($variable != NULL) )
	        return true;
	  return false;
	}
	
	public function checkFormatoToken($variable=''){
	    if ( (!preg_match("/\*/", $variable)) and (!preg_match("/\;/", $variable)) && (!preg_match("/\#/", $variable))
	        && (!preg_match('/\$/', $variable)) && (!preg_match('/=/', $variable)) && (!preg_match('/</', $variable))
	        && (!preg_match('/>/', $variable)) && (!preg_match('/\?/', $variable)) && (!preg_match('/!/', $variable))
	        && (!preg_match('/%/', $variable)) &&  (!preg_match('/@/', $variable))
	        && (!preg_match('/(delete)/i', $variable)) && (!preg_match('/(truncate)/i', $variable)) && (!preg_match('/(drop)/i', $variable))
	        && (!preg_match('/(remove)/i', $variable)) && (!preg_match('/(update)/i', $variable)) && (!preg_match('/(delay)/i', $variable))
	        && (!$variable == '' || $variable == NULL)  )
	        return true;
	     return false;
	}

	



	
	

	
	
	
	
	
	
	
/*
 ===================================================================================================
 METODO ENCARGADO DE VALIDAR LOS DATOS ENVIADOS PARA EL LOGIN
 ===================================================================================================
 */	
	public function checkLogin($email,$password){
	    if (!filter_var($email,FILTER_VALIDATE_EMAIL))
	        return false;
	    
	    if (!$this->caracteresEspecialesPassword($password))
	        return false;
	    
	   return true;
	}

	
	


/*
===================================================================================================
CHEQUEA QUE EL VALOR PASADO POR PARAMETRO SEA SOLO NUMERICO
===================================================================================================
*/	
	public function checkNumber($number){
		if (is_numeric($number))
			return true;
		return false;
	}
	




/*
===================================================================================================
CHEQUEA QUE LA CADENA NO CONTENGA CARACTERES ESPECIALES
===================================================================================================
*/
	public function checkCaracteresEspeciales($variable){
		if ( (!preg_match("/\*/", $variable)) and (!preg_match("/\;/", $variable)) and (!preg_match("/\#/", $variable)) 
		and (!preg_match('/\$/', $variable)) and (!preg_match('/=/', $variable)) and (!preg_match('/</', $variable))
		and (!preg_match('/>/', $variable)) and (!preg_match('/\?/', $variable)) and (!preg_match('/!/', $variable)) 
		and (!preg_match('/%/', $variable)) and  (!preg_match('/@/', $variable))
		and (!preg_match('/(delete )/', $variable)) and (!preg_match('/(truncate )/', $variable)) and (!preg_match('/(drop )/', $variable)) 
		and (!preg_match('/(remove )/', $variable)) and (!preg_match('/(update )/', $variable)) )
			return TRUE;
		else
			return FALSE;
	}

/*
===================================================================================================
CHEQUEA QUE EL CERTIFICADO NO CONTENGA CARACTERES ESPECIALES
===================================================================================================
*/
	public function checkCaracteresCRT($variable){
		if ( (!preg_match("/\*/", $variable)) and (!preg_match("/\;/", $variable)) and (!preg_match("/\#/", $variable)) 
		and (!preg_match('/\$/', $variable))  and (!preg_match('/\?/', $variable)) and (!preg_match('/!/', $variable)) 
		and (!preg_match('/%/', $variable)) and  (!preg_match('/@/', $variable))
		and (!preg_match('/(delete )/', $variable)) and (!preg_match('/(truncate )/', $variable)) and (!preg_match('/(drop )/', $variable)) 
		and (!preg_match('/(remove )/', $variable)) and (!preg_match('/(update )/', $variable)) )
			return TRUE;
		else
			return FALSE;

	}


/*
===================================================================================================
CHEQUEA QUE EL Token NO CONTENGA CARACTERES ESPECIALES
===================================================================================================
*/
	public function checkCaracteresToken($variable){
		if ( (!preg_match("/\*/", $variable)) and (!preg_match("/\;/", $variable)) and (!preg_match("/\#/", $variable)) 
		and (!preg_match('/\$/', $variable))  and (!preg_match('/\?/', $variable)) and (!preg_match('/!/', $variable)) 
		and (!preg_match('/%/', $variable)) and  (!preg_match('/@/', $variable))
		and (!preg_match('/(delete)/', $variable)) and (!preg_match('/(truncate)/', $variable)) and (!preg_match('/(drop)/', $variable)) 
		and (!preg_match('/(remove)/', $variable)) and (!preg_match('/(update)/', $variable)) and (strlen($variable) === 128) )
			return TRUE;
		else
			return FALSE;

	}


/*
===================================================================================================
CHEQUEA QUE EL PARAMETRO CALLE PARA EL FILTRADO CONTENGA UN VALOR VALIDO
===================================================================================================
*/	
	public function checkCalle($calle){
		if ( ($calle != NULL) ){
			if ($this->checkCaracteresEspeciales($calle))
				return TRUE;
			else
				return FALSE;
		}
		else
			return FALSE;
	}



/*
===================================================================================================
CHEQUEA QUE EL PARAMETRO NOMBRE PARA EL FILTRADO CONTENGA UN VALOR VALIDO
===================================================================================================
*/	
	public function checkNombre($nombre){
		if ( ($nombre != NULL) ){
		
			if ( $this->checkCaracteresEspeciales($nombre) )
				return TRUE;
			else
				return FALSE;
		}
		else
			return FALSE;
	}


	
	
	
/*
===================================================================================================
CHEQUEA QUE CADA UNOS DE LOS ATRIBUTOS DE LA CONSULTA
===================================================================================================
*/	
	public function checkParametrosConsultaFactura($tipoFiltro,$cuenta,$codigo){
		if ( ($tipoFiltro == 'NC') and (is_numeric($cuenta)) and ((strlen((string)$cuenta)) == 9 ) )
			return TRUE;
		else
			if ( ($tipoFiltro == 'CB') and (is_numeric($codigo)) and ((strlen((string)$codigo)) == 32 ) )
				return TRUE;
			else
				return FALSE;
	}

/*
===================================================================================================
CHEQUEA QUE CADA UNOS DE LOS ATRIBUTOS DE LA CONSULTA
===================================================================================================
*/	
	public function checkParametrosConsultaUsuario($tipoFiltro,$nombre,$calle,$puerta){
		if ( ($tipoFiltro == 'N') and ($this->checkNombre($nombre)) )
			return TRUE;
		else
			if ( ($tipoFiltro == 'D') and ($this->checkCalle($calle)) and ($this->checkPuerta($puerta) ) )
				return TRUE;
			else
				return FALSE;

	}

/*
===================================================================================================
CHEQUEA QUE EL NUMERO DE COMPROBANTE TENGA EL FORMATO CORRECTO
===================================================================================================
*/	
public function checkNumeroComprobante($numeroComprobante){
		if ( ($numeroComprobante != NULL) ){
			$arrayNum = explode('-', $numeroComprobante);
			foreach ($arrayNum as $key) {
				if ( (!ctype_alpha($key)) and (!is_numeric($key)))
					return FALSE;
			}
			return TRUE;
		}
		else
			return FALSE;
}	

/*
===================================================================================================
CHEQUEA EL IMPORTE
===================================================================================================
*/	
public function checkImporte($importe){
		if ( ($importe != NULL) ){
			$decimales= explode('.', $importe);
			if ( ((strlen($decimales[1])) == 2) and (is_numeric($importe)) )
			return TRUE;
		}
		else
			return FALSE;
		
}	
	
/*
===================================================================================================
CHEQUEA QUE CADA UNOS DE LOS ATRIBUTOS DEL COMPROBANTE CUMPLAN CON LAS RESTRICCION DE CADA UNO 
===================================================================================================
*/	

	public function checkComprobante($arreglo){
		
		foreach ($arreglo as $datos) 
			if (  (!$this->checkNumber($datos["CobId"]))
				or ( (!$this->checkNumber($datos["ClienteCuenta"]))  )
		 		or ( (!$this->checkImporte($datos["Importe"])) )
		 		or ( (!$this->checkImporte($datos["ImportePagado"])) )
		 		or ( (!$this->checkNumber($datos["ComprobanteId"])) )
		 		or ( (!$this->checkNumeroComprobante($datos["NumeroComprobante"]))  ) 
		 	)
				return FALSE;
			return TRUE;	
	}

/*
===================================================================================================
CHEQUEA QUE EL NUMERO DE TRANSACCION CONTENGA UN VALOR VALIDO
===================================================================================================
*/	

	public function checkNumTransaccion($transaccion){
		
		if (is_numeric($transaccion))
				return TRUE;
			return FALSE;	
	}
	
	
	public function checkModDatosUsuario($datos){
	   if (!filter_var($datos["email"],FILTER_VALIDATE_EMAIL))
	        return false;
	   $nombres = explode(' ',$datos["nombre"]);
	   foreach ($nombres as $item){
	       if (!ctype_alpha($item))
	           return false;
	   }
	       
        $apellidos = explode(' ',$datos["apellido"]);
        foreach ($apellidos as $item ){
           if (!ctype_alpha($item))
               return false;
        }
           
       if (!is_numeric($datos["fechaNacimiento"]))     
           return false;
       if (!is_numeric($datos["idCiudad"]))
           return false;
       $direccion = explode(' ',$datos["direccion"]);
       foreach ($direccion as $item ){
           if (!ctype_alnum($item))
               return false;
       }
       
       if (!is_numeric($datos["tipoDocumento"]))
           return false;
       if (!is_numeric($datos["documento"]))
           return false;
       
      return true;
               
	}
	
}

?>
