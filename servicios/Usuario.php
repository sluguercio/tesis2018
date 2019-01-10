<?php

require_once(getcwd()."/Controllers/UsuarioController.php");
require_once(getcwd()."/Controllers/ConsultasController.php");


Class Usuario extends Rest{
    
    private $usuario;
    private $consultas;
    public function __construct(){
        $this->usuario = new UsuarioController();
        $this->consultas = new ConsultasController();
    }

    
    
    
    public function login(){
        if ($_SERVER['REQUEST_METHOD'] != 'POST')
            $this->response('', 404);
        
        $ipCliente = '';
        $datos = array();
        $json = file_get_contents('php://input');
        $informacion = json_decode($json);
        $datos = json_decode(json_encode($informacion),true);
        $ipCliente = $_SERVER['REMOTE_ADDR'];
        return $this->usuario->Login($datos,$ipCliente);
        
    }
    
    public function altaUsuario(){
        if ($_SERVER['REQUEST_METHOD'] != 'POST')
            $this->response('', 404);
            
            $ipCliente = '';
            $datos = array();
            $json = file_get_contents('php://input');
            $informacion = json_decode($json);
            $datos = json_decode(json_encode($informacion),true);
            $headers = apache_request_headers();
            $datos["token"] = explode(" ", $headers['Authorization'])[1];
            $datos["ipCliente"] = $_SERVER['REMOTE_ADDR'];
            return $this->usuario->altaUsuario($datos);
    }
    
    public function datosUsuario($parametros){
        if ($_SERVER['REQUEST_METHOD'] != 'GET')
            $this->response('', 404);
            
            $ipCliente = '';
            $datos = array();
            $datos["token"] = $parametros[1];
            $datos["ipCliente"] = $_SERVER['REMOTE_ADDR'];
            return $this->usuario->getDatosUsuario($datos);
    }
    
    public function modDatosUsuario(){
        if ($_SERVER['REQUEST_METHOD'] != 'POST')
            $this->response('', 404);
            
            $ipCliente = '';
            $datos = array();
            
            $json = file_get_contents('php://input');
            $informacion = json_decode($json);
            $datos = json_decode(json_encode($informacion),true);
            
            $datos["ipCliente"] = $_SERVER['REMOTE_ADDR'];
            return $this->usuario->modDatosUsuario($datos);
    }
    
    public function ciudades($parametros){
        if ($_SERVER['REQUEST_METHOD'] != 'GET')
            $this->response('', 404);
            
            $ipCliente = '';
            $datos = array();
        
            $datos["token"] = $parametros[1];
            $datos["idDepartamento"] = $parametros[2];
            $datos["ipCliente"] = $_SERVER['REMOTE_ADDR'];
            return $this->consultas->getCiudades($datos);
    }
    
    public function departamentos($parametros){
        if ($_SERVER['REQUEST_METHOD'] != 'GET')
            $this->response('', 404);
            
            $ipCliente = '';
            $datos = array();
            $datos["idPais"] = $parametros[2];
            $datos["token"] = $parametros[1];
            $datos["ipCliente"] = $_SERVER['REMOTE_ADDR'];
            return $this->consultas->getDepartamentos($datos);
    }
    
    public function paises($parametros){
        if ($_SERVER['REQUEST_METHOD'] != 'GET')
            $this->response('', 404);
            
            $ipCliente = '';
            $datos = array();
            $datos["token"] = $parametros[1];
            $datos["ipCliente"] = $_SERVER['REMOTE_ADDR'];
            return $this->consultas->getPaises($datos);
    }
    
    public function confirmacion($parametros){
        if ($_SERVER['REQUEST_METHOD'] != 'GET')
            $this->response('', 404);
            
        $ipCliente = '';
        $datos = array();
        $headers = apache_request_headers();
        $datos["codigoConfirmacion"] =$parametros[1];
        $datos["ipCliente"] = $_SERVER['REMOTE_ADDR'];
        return $this->usuario->confirmacion($datos);
        
    }
    
    public function reiniciopassword($parametros){
        if ($_SERVER['REQUEST_METHOD'] != 'POST')
            $this->response('', 404);
            
            $ipCliente = '';
            $datos = array();
            $headers = apache_request_headers(); 
            $json = file_get_contents('php://input');
            $informacion = json_decode($json);
            $datos = json_decode(json_encode($informacion),true);
            $datos["ipCliente"] = $_SERVER['REMOTE_ADDR'];
            return $this->usuario->forgetpassword($datos);
            
    }
    
    public function resetpassword($parametros){
        if ($_SERVER['REQUEST_METHOD'] != 'POST')
            $this->response('', 404);
            
            $ipCliente = '';
            $datos = array();
            $headers = apache_request_headers();
            $json = file_get_contents('php://input');
            $informacion = json_decode($json);
            $datos = json_decode(json_encode($informacion),true);
            $datos["ipCliente"] = $_SERVER['REMOTE_ADDR'];
            return $this->usuario->resetPassword($datos);
            
    }
}

?>