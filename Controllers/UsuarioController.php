<?php

use PHPMailer\PHPMailer\Exception;

include_once(getcwd()."/Models/UsuariosModel.php");
include_once(getcwd()."/Models/TokenModel.php");
require_once(getcwd()."/lib/Validador/Validador.php");
require_once(getcwd()."/lib/Validador/ValidadorRegistro.php");
require_once(getcwd()."/lib/Response/Response.php");
require_once(getcwd()."/lib/Response/ResponseRegistro.php");
require_once(getcwd()."/lib/Response/ResponseUsuario.php");
require_once(getcwd()."/lib/Response/ResponseLogin.php");
require_once(getcwd()."/lib/token.php");

Class UsuarioController{
    
    private $usuarioModel;
    private $validador;
    private $response;
    
    public function __construct(){
        $this->usuarioModel = new UsuariosModel();
        $this->validador = new Validador();
       
    }
    

    
    public function Login($datos='',$ipCliente=''){
        try {
            
            $this->response = new ResponseLogin("Login");
            $token = new Token();
            $datosLog = array(
              'idUsuario' => 0,
              'email' => $datos["usuario"],
              'password' => $datos["password"],
              'nombre' => '',
              'apellido' => '',
              'fechaNacimiento' => '',
              'direccion' => '',
              'nombreCiudad' => '',
              'nombreDepartamento'=>'',
              'nombrePais'=>'',
              'tipoDocumento'=> 0,
              'documento' => 0,
              'ipCliente' => $ipCliente,
              'token' => ''  
            );
            
            if ( (!$this->validador->checkLogin($datos["usuario"], $datos["password"])) )
                throw new Exception('',-1);
                                
            $login = $this->usuarioModel->Login($datosLog);
                
            if ($login["codigo"] < 0)
                throw new Exception('',$login["codigo"]);
            
           // $autenticacion = $token->generar_token($login["datos"]);
            $jwt = $token->generaJWT($login["datos"]);
            $tokenDAO = new TokenModel();
            
            $datosLog['idUsuario'] = $login["datos"]["idUsuario"];
            $datosLog['email'] = $login["datos"]["email"];
            $datosLog['nombre'] = $login["datos"]["nombre"];
            $datosLog['apellido'] = $login["datos"]["apellido"];
            $datosLog['direccion'] = $login["datos"]["direccion"];
            $datosLog['nombrePais'] = $login["datos"]["nombrePais"];
            $datosLog['nombreDepartamento'] = $login["datos"]["nombreDepartamento"];
            $datosLog['nombreCiudad'] = $login["datos"]["nombreCiudad"];
            $datosLog['fechaNacimiento'] = $login["datos"]["fechaNacimiento"];
            $datosLog['tipoDocumento'] = $login["datos"]["tipoDocumento"];
            $datosLog['documento'] = $login["datos"]["documento"];
            $datosLog['token'] = $autenticacion["tokenId"];
            $datosLog['ipCliente'] = $ipCliente;
            
         
            $this->response->setNombre($login["datos"]["nombre"]);
            $this->response->setApellido($login["datos"]["apellido"]);
            $this->response->setToken($jwt);        
            return $this->response->getResponse(0);          
    
        } catch (Exception $e) {
            return $this->response->getResponse($e->getCode());
        }
    }
    
    public function altaUsuario($parametros){
        try{
            $this->response = new ResponseRegistro("Registro");
            $this->validador = new ValidadorRegistro();
            $token = new Token();
            $validador = $this->validador->ValidarRegistro($parametros);
            if ($validador < 0)
                throw  new Exception('','-1'.$validador*(-1));
            
            if ($parametros["token"] != ""){
                $datos = $token->validaJWT($parametros["token"]);
                if (empty($datos))
                    throw  new Exception('',-1);
                if ($datos["data"]["idRol"] != 1)
                    throw  new Exception('',-1);
                if ($parametros["idRol"] == "")
                    throw new Exception('',-1);
            }
            else{
                $parametros["rol"] = 2;
            }
            
            $validaEmail = $this->usuarioModel->validaEmail($parametros["email"]);
            
            if ($validaEmail < 0)
                throw new Exception('','-2'.$validaEmail*(-1));
                
                
            $registro = $this->usuarioModel->altaUsuario($parametros);
                
            if ($registro < 0)
                throw new Exception('',$registro["codigo"]);
                    
          return $this->response->getResponse(0);
                
        } catch (Exception $e) {
            return $this->response->getResponse($e->getCode());
        }
    }
    
    public function getDatosUsuario($parametros){
        try{
            $token = new Token();
            $response = new ResponseUsuarios("datosUsuario");
            $response->setToken($parametros["token"]);
            // $datos = $token->validarToken($token);
            $datos = $token->validaJWT($parametros["token"]);
            
            if (empty($datos))
                throw new Exception('',-1);
            
            $parametros["idUsuario"] = $datos["data"]["idUsuario"];
            $usuario = $this->usuarioModel->getDatosUsuario($parametros["idUsuario"]);
        
            if ($usuario["codigo"] < 0)
                throw new Exception('',$usuario["codigo"]);
            
            return $response->getResponseDatosUsuarios(0, $usuario["datos"]);
            
        }
        catch (Exception $e){
            return $response->getResponseDatosUsuarios($e->getCode(),array());
        }
    }
    
    public function modDatosUsuario($parametros){
        try{
            $token = new Token();
            $response = new ResponseUsuarios("modDatosUsuario");
            $response->setToken($parametros["token"]);
            
            if (!$this->validador->checkModDatosUsuario($parametros))
                throw new Exception('',-1);
            // $datos = $token->validarToken($token);
            $datos = $token->validaJWT($parametros["token"]);
            $parametros["idUsuario"] = $datos["data"]["idUsuario"];
            
            if (empty($datos))
                throw new Exception('',-4);
                
            $usuario = $this->usuarioModel->modDatosUsuario($parametros);
                
            if ($usuario["codigo"] < 0)
                throw new Exception('',$usuario["codigo"]);
                    
            return $response->getResponseModDatosUsuarios($usuario["codigo"]);
                    
        }
        catch (Exception $e){
            return $response->getResponseModDatosUsuarios($e->getCode());
        }
    }
    
    
    public function confirmacion($parametros){
        try{

            $response = new ResponseUsuarios("confirmacion");
            $response->setToken($parametros["codigoConfirmacion"]);
        
            if (!ctype_alnum($parametros["codigoConfirmacion"]))
                throw  new Exception('',-1);
            

            $confirmacion = $this->usuarioModel->confirmation($parametros);
                
            if ($confirmacion < 0)
                throw new Exception('',$confirmacion);
                    
            return $response->getResponseConfirmacion(0);
                    
        }
        catch (Exception $e){
            return $response->getResponseConfirmacion($e->getCode());
        }
    }
    
    
    public function forgetpassword($parametros){
        try{
            
            $response = new ResponseUsuarios("recupacionPassword");
         
            
            if (! filter_var($parametros["email"],FILTER_VALIDATE_EMAIL))
                throw  new Exception('',-1);
                
            $email = $this->usuarioModel->validaEmailUsuario($parametros["email"]);
            
            if ($email < 0)
                throw  new Exception('',-2);
                
            $forgetpassword = $this->usuarioModel->forgetPassword($parametros);
                
            if ($forgetpassword < 0)
                throw new Exception('',$forgetpassword);
                    
            return $response->getResponseForgetPassword(0);
                    
        }
        catch (Exception $e){
            return $response->getResponseForgetPassword($e->getCode());
        }
    }
    
    
    public function resetPassword($parametros){
    try{
            
        $response = new ResponseUsuarios("reinicioPassword");
            
        if (!ctype_alnum($parametros["codigoReinicio"]))
            throw  new Exception('',-1);
            
        if (!ctype_alnum($parametros["password"]))
            throw  new Exception('',-1);
                
        $resetpassword = $this->usuarioModel->resetPassword($parametros);
                
        if ($resetpassword < 0)
            throw new Exception('',$resetpassword);
                    
        return $response->getResponseResetPassword(0);
                    
        }
        catch (Exception $e){
            return $response->getResponseResetPassword($e->getCode());
        }
    }
}

?>