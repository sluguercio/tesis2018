<?php
include_once(getcwd().'/lib/Message.php');

Class Response{

    private $message;
    private $servicio;
    private $code;
    private $status;
    private $token;
    
    public function __construct($servicio){
        $this->message = new Message();
        $this->servicio = $servicio;
        $this->token = "";
    }
    
    public function setToken($token){
        $this->token = $token;
    }
    
    
    public function getToken(){
        return $this->token;
    }
    
    public function setStatus($code){
        if ($code < 0)
            $this->status = "error";
        else
            $this->status = "success";
    }
    
    public function setCode($code,$servicio){
        if ($code < 0)
            $this->code = $servicio.$code*(-1);
        else
            $this->code = $servicio.$code;
    }
    
    public function getCode(){
        return $this->code;
    }
    
    public function getStatus(){
        return $this->status;
    }
    
    public function getMessage(){
        return $this->message->getMessage($this->code);
    }
}