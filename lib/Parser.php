<?php

require_once(getcwd()."/elements/Vehiculo.php");

Class Parser{
	
	public function __construct(){
		
	}

	public function parserNombre($nombre){
		return str_replace("'" , "''" , $nombre);
	}
	
	public function generaVehiculos($datos){
	    $listaObj = array();
	    foreach ($datos as $item){
	        if (!array_key_exists('empresa', $item)) $empresa = NULL; else $empresa = $item["empresa"];
	        if (!array_key_exists('codigo', $item)) $codigo = NULL; else $codigo = $item["codigo"];
	        if (!array_key_exists('coordX', $item)) $latitud = NULL; else $latitud = $item["coordX"];
	        if (!array_key_exists('coordY', $item)) $longitud = NULL; else $longitud = $item["coordY"];
	        if (!array_key_exists('fecha', $item)) $fecha = NULL; else $fecha = $item["fecha"];
	        if (!array_key_exists('desplazamiento', $item)) $desplazamiento = NULL; else $desplazamiento = $item["desplazamiento"];
	        if (!array_key_exists('nombre', $item)) $nombre = NULL; else $nombre = $item["nombre"];
	        if (!array_key_exists('velocidad', $item)) $velocidad = NULL; else $velocidad = $item["velocidad"];
	        if (!array_key_exists('contacto', $item)) $contacto = NULL; else $contacto = $item["contacto"];
	        if (!array_key_exists('voltaje', $item)) $voltaje = NULL; else $voltaje = $item["voltaje"];
	        if (!array_key_exists('sos', $item)) $sos = NULL; else $sos = $item["sos"];
	        if (!array_key_exists('puerta', $item)) $puerta = NULL; else $puerta = $item["puerta"];
	        if (!array_key_exists('sirena', $item)) $sirena = NULL; else $sirena = $item["sirena"];
	        $vehiculo = new Vehiculo($codigo,$nombre,$empresa,$latitud, $longitud, $fecha, $desplazamiento, $velocidad, $contacto, $voltaje, $sos, $puerta, $sirena);
	        array_push($listaObj, $vehiculo);
	     }
	     return $listaObj;
	}
	

}