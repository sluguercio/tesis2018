<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

include_once('DBConnect.php');
require_once(getcwd().'/Models/ServicesModel.php');



class UsuariosModel extends DBConnect{

    private $servicios;
    
	public function __construct(){
	 $this->servicios  = new ServicesModel();
	}
	
	public function Login($datos){
	   
	    try {
	        	       
	        $conexion = parent::createConnection();
	        
	       
	        $sql = 'SELECT 
            u.idUsuario,
            u.email,
            u.password,
            u.nombre,
            u.apellido,
            u.fechaNacimiento,
            p.nombrePais,
            d.nombreDepartamento,
            c.nombreCiudad,
            u.direccion,
            u.tipoDocumento,
            u.documento
            FROM Usuario u
            INNER JOIN Ciudad c ON c.idCiudad = u.idCiudad 
            INNER JOIN Departamento d  ON d.idDepartamento = c.idDepartamento
            INNER JOIN Pais p ON p.idPais = d.idPais
            WHERE u.email = '."'".$datos["email"]."'".' 
            AND u.password = '."'".$datos["password"]."'";
	        
	       
	        $query=$conexion->query($sql);
	        
	        if ( (!$conexion) || (!$query) )
	            throw new Exception('',-2);
	        
	        if ( $query->num_rows == 0 )
	            throw new Exception('',-3);
	        
	      
	        $respuesta = mysqli_fetch_array($query);
	        $conexion->close();
	        return array('datos' => $respuesta,'codigo' => 0);
	        
	       }catch (Exception $e) {
	           if ($conexion)
	               $conexion->close();
	           return array('datos'=>'','codigo'=>$e->getCode());
	      }
	    
	}
	
	public function validaEmail($email){
	    try {
	        
	        $conexion = parent::createConnection();
	        
	        $sql = 'SELECT 1 FROM Usuario 
            WHERE email = '."'".$email."'";
	        
	        
	        $query=$conexion->query($sql);
	        
	        if ( (!$conexion) || (!$query) )
	            throw new Exception('',-2);
	            
	        if ( $query->num_rows > 0 )
	            throw new Exception('',-3);
	            
	        $conexion->close();
	        
	        return 0;
	            
	    }catch (Exception $e) {
	        if ($conexion)
	            $conexion->close();
	        
	        return $e->getCode();
	    }
	    
	}
	
	public function validaEmailUsuario($email){
	    try {
	        
	        $conexion = parent::createConnection();
	        
	        $sql = 'SELECT 1 FROM Usuario
            WHERE email = '."'".$email."'";
	        
	        
	        $query=$conexion->query($sql);
	        
	        if ( (!$conexion) || (!$query) )
	            throw new Exception('',-2);
	            
            if ( $query->num_rows == 0 )
                throw new Exception('',-2);
	                
            return 0;
	                
	    }catch (Exception $e) {
	        return $e->getCode();
	    }
	}
	    
	
	public function altaUsuario($data){
	    try {
	        
	        $conexion = parent::createConnection();
	        $fechaNacimiento = date('Y-m-d',$data["fechaNacimiento"]);
	        $fechaAlta = date('Y-m-d H:i:s');
	        $data["confirmacion"] = hash('sha512',$data["email"].date('U').'tesis');
	        
	        $sql = 'INSERT INTO
            Usuario 
            (email,
            password,
            nombre,
            apellido,
            fechaNacimiento,
            idCiudad,
            idRol,
            direccion,
            fechaAlta,
            estado,
            tipoDocumento,
            confirmacion,
            documento)
            
            VALUES
            ('."'".$data["email"]."'".',
            '."'".$data["password"]."'".',
            '."'".$data["nombre"]."'".',
            '."'".$data["apellido"]."'".',
            '."'".$fechaNacimiento."'".',
            '.$data["ciudad"].',
            '.$data["rol"].',
            '."'".$data["direccion"]."'".',
            '."'".$fechaAlta."'".',
            1,
            '.$data["tipodocumento"].',
            '."'".$data["confirmacion"]."'".',
            '.$data["documento"].')';
	        
	        $transaction = $conexion->begin_transaction();
	        
	        $query=$conexion->query($sql);
	        
	        if ( (!$conexion) || (!$query) || (!$transaction) )
	            throw new Exception('',-1);
	         
	         $enviarConf = $this->enviarConfirmacion($data);
	         
	         if ($enviarConf < 0)
	            throw new Exception('',-3);
           
	         if (!$conexion->commit())
	            throw  new Exception('',-4);
            
            return 0;
	                
	    }catch (Exception $e) {
	        $conexion->rollback();
	        $conexion->close();
	        return $e->getCode();
	    }
	    
	    
	}
	
	public function enviarConfirmacion($datos){
	try {
// 	    $code = hash("sha512", $datos["email"].date('U'),false);
// 	    $para      = $datos["email"];
// 	    $titulo    = 'Confirmacion de Registro';
// 	    $mensaje   = 'Confirme su cuenta con el siguiente enlace

//          http://tesis/confirmacion/'.$code;
// 	    $cabeceras = 'From: sluguercio@gmail.com' . "\r\n" .
	   	    
// 	   	    'X-Mailer: PHP/' . phpversion();
	    
// 	    $send = mail($para, $titulo, $mensaje, $cabeceras);
// 	   if (!$send)
// 	       throw new Exception();
	   
	   $mail = new PHPMailer(true);
	   $mail->SMTPDebug = 2;                                 // Enable verbose debug output
	   $mail->isSMTP();                                      // Set mailer to use SMTP
	   $mail->Host = 'smtp.gmail.com';  // Specify main and backup SMTP servers
	   $mail->SMTPAuth = true;                               // Enable SMTP authentication
	   $mail->Username = 'sebastian.ezequiel.luguercio@gmail.com';                 // SMTP username
	   $mail->Password = 'anccmaa1838';                           // SMTP password
	   $mail->SMTPSecure = 'ssl';                            // Enable TLS encryption, `ssl` also accepted
	   $mail->Port = 465;                                    // TCP port to connect to
	   
	   //Recipients
	   $mail->setFrom('sebastian.ezequiel.luguercio@gmail.com', 'Tesis Registracion');
	   $mail->addAddress($datos["email"],$datos["nombre"]);     // Add a recipient
	   
	   
	   //Content
	   $mail->isHTML(true);                                  // Set email format to HTML
	   $mail->Subject = 'Sistemas de Registracion';
	   $mail->Body    = 'Por favor, para confirmar su registro haga click sobre el siguiente link : <br>
                        <b><a href="http://localhost/tesis/confirmacion/'.$datos["confirmacion"].'">Confirmar Registro </a></b>';
	   
	  
	   $mail->send();
	   echo 'Message has been sent';
	   }
	   catch (Exception $e){
	       return -1;
	   }
	}
	
	public function getDatosUsuario($idUsuario){
	    try {
	        
	        $conexion = parent::createConnection();
	        
	        
	        $sql = 'SELECT
            u.email,
            u.nombre,
            u.apellido,
            u.fechaNacimiento,
            u.idCiudad,
            c.nombreCiudad,
            d.idDepartamento,
            d.nombreDepartamento,
            p.idPais,
            p.nombrePais,
            u.direccion,
            u.tipoDocumento,
            u.documento
            FROM Usuario u 
            INNER JOIN Ciudad c ON c.idCiudad = u.idCiudad
            INNER JOIN Departamento d ON d.idDepartamento = c.idDepartamento
            INNER JOIN Pais p ON p.idPais = d.idPais
	        WHERE u.idUsuario = '.$idUsuario.'
            AND u.estado = 1';
	        
	        
	        $query=$conexion->query($sql);
	        
	        if ( (!$conexion) || (!$query=$conexion->query($sql)) )
	            throw new Exception('',-2);
	            
            if ( $query->num_rows == 0 )
                throw new Exception('',-3);
	                
           
            $respuesta = mysqli_fetch_array($query,MYSQLI_ASSOC);
            $respuesta["fechaNacimiento"] =  date("U",strtotime($respuesta["fechaNacimiento"]));
            return array('datos' => $respuesta,'codigo' => 0);
	                
	    }catch (Exception $e) {
	        return array('datos'=>'','codigo'=>$e->getCode());
	    }
	    
	}
	
	
	
	public function modDatosUsuario($datos){
	    try {
	        
	        $conexion = parent::createConnection();
	        
	        $datos["fechaNacimiento"] = date("Y-m-d H:i:s",$datos["fechaNacimiento"]);
	        $sql = 'UPDATE Usuario u
            SET 
            u.email = '."'".$datos["email"]."'".',
            u.nombre = '."'".$datos["nombre"]."'".',
            u.apellido = '."'".$datos["apellido"]."'".',
            u.fechaNacimiento = '."'".$datos["fechaNacimiento"]."'".',
            u.idCiudad = '.$datos["idCiudad"].',
            u.direccion = '."'".$datos["direccion"]."'".',
            u.tipoDocumento = '.$datos["tipoDocumento"].',
            u.documento = '.$datos["documento"].'
	        WHERE u.idUsuario = '.$datos["idUsuario"].'
            AND u.estado = 1';
	        
	        
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
	
/*
 * METODO QUE ALMACEN EL NUEVO PASSWORD DEL USUARIO
 * */
	
	public function resetPassword($datos){
	    try{
	        $conexion = parent::createConnection();
	        $code = hash("sha512", $datos["email"].date("U"));
	        $fechaActual = date("Y-m-d H:i:s");
	        
	        $sql = 'UPDATE Usuario u
            SET u.password = '."'".$datos["password"]."'".',
            u.reinicioPassword = NULL,
            u.fechaReinicioPassword = NULL
            WHERE u.reinicioPassword = '."'".$datos["codigoReinicio"]."'".'
            AND DATE_ADD(u.fechaReinicioPassword, INTERVAL 1 DAY ) > '."'".$fechaActual."'";
	        
	        
	        $query=$conexion->query($sql);
	        
	        if ( (!$conexion) || (!$query) )
	            throw new Exception('',-2);
	            
            if ( $conexion->affected_rows == 0 )
                throw new Exception('',-3);
	                
	                
            return 0;
	                
	    }catch (Exception $e) {
	        return $e->getCode();
	    }
	}

/*
 * METODO QUE EJECUTA LA GENERACION DE UN PEDIDO DE REINICIO DEL PASSWORD
 * */
	
	public function forgetPassword($datos){
	    try{
	        $conexion = parent::createConnection();
	        $code = hash("sha512", $datos["email"].date("U"));
	       
	        $fechaActual = date("Y-m-d H:i:s");
	        
	        $sql = 'UPDATE Usuario u
            SET u.reinicioPassword = '."'".$code."'".',
            u.fechaReinicioPassword = '."'".$fechaActual."'".'
            WHERE 
            (DATE_ADD(u.fechaReinicioPassword, INTERVAL 1 DAY) < '."'".$fechaActual."'".' 
            OR u.fechaReinicioPassword IS NULL) 
            AND u.email ='."'".$datos["email"]."'";
          
	        
	        $query=$conexion->query($sql);
	        
	        if ( (!$conexion) || (!$query) )
	            throw new Exception('',-3);
	            
            if ( $conexion->affected_rows == 0 )
                throw new Exception('',-4);
	                
            $datos["codigoReinicio"] = $code;    
            $send = $this->enviarReinicio($datos);
            
            if ($send < 0)
                throw new Exception('',-3);
   
            return 0;
	                
	    }catch (Exception $e) {
	        return $e->getCode();
	    }
	}

/*
 * METODO QUE EJECUTA LA CONFIRMACION DEL REGISTRO DEL USUARIO
 * */
	public function confirmation($datos){
    try{
	    $conexion = parent::createConnection();
	    
	    $fechaActual = date("Y-m-d H:i:s");
	    
	    $sql = 'UPDATE Usuario u
            SET u.fechaConfirmacion = '."'".$fechaActual."'".',
            u.reinicioPassword = NULL
            WHERE u.confirmacion = '."'".$datos["codigoConfirmacion"]."'".'
            AND u.fechaConfirmacion IS NULL
            AND DATE_ADD(u.fechaAlta, INTERVAL 1 DAY) > '."'".$fechaActual."'";
            
	    
	    
	    $query=$conexion->query($sql);
	    
	    if ( (!$conexion) || (!$query) )
	        throw new Exception('',-2);
	        
        if ( $conexion->affected_rows == 0 )
            throw new Exception('',-1);
	            
	            
        return 0;
	            
	}catch (Exception $e) {
	    return $e->getCode();
	   }
	}

	public function enviarReinicio($datos){
	    try {
	       
	        
	        $mail = new PHPMailer(true);
	        $mail->SMTPDebug = 2;                                 // Enable verbose debug output
	        $mail->isSMTP();                                      // Set mailer to use SMTP
	        $mail->Host = 'smtp.gmail.com';  // Specify main and backup SMTP servers
	        $mail->SMTPAuth = true;                               // Enable SMTP authentication
	        $mail->Username = 'sebastian.ezequiel.luguercio@gmail.com';                 // SMTP username
	        $mail->Password = 'anccmaa1838';                           // SMTP password
	        $mail->SMTPSecure = 'ssl';                            // Enable TLS encryption, `ssl` also accepted
	        $mail->Port = 465;                                    // TCP port to connect to
	        
	        //Recipients
	        $mail->setFrom('sluguercio@gmail.com', 'Tesis Recuperacion de contraseña');
	        $mail->addAddress($datos["email"],$datos["nombre"]);     // Add a recipient
	        
	        
	        //Content
	        $mail->isHTML(true);                                  // Set email format to HTML
	        $mail->Subject = 'Sistemas de Recuperacion de contraseña';
	        $mail->Body    = 'Por favor, para recuperar su contraseña haga click sobre el siguiente link : <br>
                        <b><a href="http://localhost/tesis/confirmacion/'.$datos["codigoReinicio"].'">Recuperar Contraseña </a></b>';
	        
	        
	        $mail->send();
	       return 0;
	    }
	    catch (Exception $e){
	        return -1;
	    }
	}




}

?>