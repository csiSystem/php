<?php
/**
* 
*/
class Dispather{
	
	var $request;
	function __construct()
	{
		//echo "Je suis ready";
		$this->request = new Request();
		Router::parse($this->request->url,$this->request);
		//creation de mon instance de controller
		$controller = $this->loadController();
		//$controller->view(); ou 
		//function qui appel un autre function
		//Le deuxieme parametre me permetra d'ajouter un paramettre dans pageControlle -> view
		call_user_func_array(array($controller,$this->request->action),$this->request->params);
	}

	function loadController(){
		//stroker le nom du controller
		$name = ucfirst($this->request->controller).'Controller';
		//inclure le controller
		$file = ROOT.DS.'controller'.DS.$name.'.php';
		require $file;
		return new $name($this->request);
	}
}

?>