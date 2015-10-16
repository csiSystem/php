<?php
Class Controller{
	public $request;             //Object Request
	private $vars = array();     //Variableà passer à la vue
	public $layout = 'default';  //Layoute à utilser pour rendre la vue
	private $vueRendue = false;  //Si le rendu aèTè fait ou pas ?


	/*
	* Constructeur
	* @params $request Objet request de notre application
	**/
	function __construct($request = null){
		//initialisation de l'objet session 
		$this->Session = new Session();
		$this->Form = new Form($this);
		
		if($request){
			$this->request = $request;	//stocker la request dans l'instance.
			require ROOT.DS.'config'.DS.'hook.php';
		}
		/**
		* fichier hook .
		* Un hook permet à l'utilisateur d'un logiciel 
		* de personnaliser le fonctionnement de ce dernier, 
		* en lui faisant réaliser des actions supplémentaires à des moments déterminés.
		*/
		
		
	}


	/**
	* Permet de rendre une vue 
	* @params $view Fichier à rendre (chemin depuis view ou nom de la vue)
	**/
	public function render($view){
		if($this->vueRendue){ return false;}
		extract($this->vars);
		if(stripos($view, '/')===0){
			$view = ROOT.DS.'vue'.$view.'.php';
		}else{
			$view = ROOT.DS.'vue'.DS.$this->request->controller.DS.$view.'.php';
		}
		ob_start();
		require ($view);
		$content_for_layout = ob_get_clean();
		require ROOT.DS.'vue'.DS.'layout'.DS.$this->layout.'.php';
		//die($view);
		$this->vueRendue = true;

	}

	public function set($key,$value=null){
		if(is_array($key)){
			$this->vars += $key;
		}else{
			$this->vars[$key] = $value;	
		}
		
	}

	/*
	*Permet de charger un model
	**/
	function loadModel($name){
		//evite de reinclure plusieurs fois le meme fiche, si on charge plusieur fois i model.
		if (!isset($this->$name)){
			$file = ROOT.DS.'model'.DS.$name.'.php';
			require_once($file);
			$this->$name = new $name();
			if(isset($this->Form)){
				$this->$name->Form = $this->Form;
			}	
		}
		
		
	}
	//gestion des erreurs 404
	public function error404($message){
		header("HTTP/1.0 404 Not Found");

		$this->set('msg',$message);
		$this->render('/erreurs/404');
		die();
	}
	/**
	*permet d'appler un controller depuis un vue
	**/
	function request($controller,$action){
		$controller .= 'Controller';
		require_once ROOT.DS.'controleur'.DS.$controller.'.php';
		$act = new $controller;
		//j'appel mon action pour etre recuperé
		return $act->$action();
		//die($controller);
	}

	function redirect($url,$code=null){
		if ($code == 301){
			header("http/1.1 301 Moved Permanently");

		}
		header("Location: ".Router::url($url));
	}
	
}

?>