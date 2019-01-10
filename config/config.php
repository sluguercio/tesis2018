<?php
Class config{
    
    private $UrlCrt = 'c:/wsCRT/ws/';
    private $database = 'WSClientesHomo';
    private $username = 'ws_admin';
    private $password = 'usinatandilwebservice2018';
    private $servername ='UPE523.Usina00.Local';
    private $key = "tesis2018";
    
   
    public function __construct(){
        
    }
    
    public function getDatabase(){
        return $this->database;
    }
    
    public function getUsername(){
        return $this->username;
    }
    
    public function getPassword(){
        return $this->password;
    }
    
    public function getServername(){
        return $this->servername;
    }
    
    public function getKey(){
        return  $this->key;
    }
}