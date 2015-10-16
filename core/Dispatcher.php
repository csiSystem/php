<?php
/**
* Dispater
* Permet de charger les controller en fonction de la de l'utilsateur
*/
class Dispatcher
{
	var $request;//Objet toutes les information demande par l'utilisateur

	
	/*
	* Fonction principale du dispatcher
	* Charge le ocntroller en fonction du routing
	*/
	function __construct()
	{
		$this->request = new Request();
		Router::parse($this->request->url,$this->request);
		$controller = $this->loadController();
		$action = $this->request->action;
		if ($this->request->prefix) {
			$action = $this->request->prefix.'_'.$action; 
		}
		if(!in_array(
			$action, array_diff(get_class_methods($controller),get_class_methods('Controller'))
			)
			){
			$this->error('Le controlleur '.$this->request->controller.' n\'a pas de méthode '.$action);
		}
		call_user_func_array(array($controller,$action),$this->request->params);
	
		$controller->render($action);
	}

	/*
	* Permet de charger le controller en fonction de la requete de l'utilisateur
	**/
	function loadController(){
		$name = ucfirst($this->request->controller).'Controller';
		$file = ROOT.DS.'controleur'.DS.$name.'.php';
		if (!file_exists($file)) {
			$this->error('Le controller '.$this->request->controller.' n\'existe pas');
		}
		
		require $file;
		$controller =  new $name($this->request);
		//initialisation de l'objet session et le stoquer dans une variavle session
		//$controller->Session = new Session();
		//$controller->Form = new Form($controller);
		return $controller;
	}

	/*
	* Permet de générer une page d'erreur en cas de problem au niveau du routers 
	* pages non existante
	*/
	function error($message){
		$controller = new Controller($this->request);
		//$controller->Session = new Session();
		$controller->error404($message);
		//die();
	}
}

?>