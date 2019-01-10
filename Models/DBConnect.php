<?php


Class DBConnect {

	private $database = 'tesis';
	private $username = 'root';
	private $password = 'tesis';
	private $servername ='localhost';

	

	public function __construct(){
		
	}

	public function createConnection(){

	    $conn = new mysqli($this->servername, $this->username, $this->password,$this->database);
		return $conn;

	}

	

	
}