<?php
Class Route{
	private $basepath;
	private $uri;
	private $base_url;
	private $routes;
	private $route;
	
	private function getCurrentUri(){
		$this->basepath = implode('/', array_slice(explode('/', $_SERVER['SCRIPT_NAME']), 0, -1)) . '/';
		$this->uri = substr($_SERVER['REQUEST_URI'], strlen($this->basepath));
		if (strstr($this->uri, '?')) $this->uri = substr($this->uri, 0, strpos($this->uri, '?'));
		$this->uri = '/' . trim($this->uri, '/');
		return $this->uri;
	}
	
	
	public function getRoutes()
	{
		$this->base_url = $this->getCurrentUri();
		$this->routes = explode('/', $this->base_url);
		return $this->routes;
	}
}