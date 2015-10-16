<?php
class Request
{
	
	public $url; // URL appellé par l'utilisateur
	public $prefix = false;
	public $data = false; //permet de savoir si des données ont étOé ou pas envoyer

	function __construct(){
		$this->url = isset($_SERVER['PATH_INFO']) ? $_SERVER['PATH_INFO'] : '/';
		//si des données sont envoyé, on initialise une nouvelle objet vide
		if (!empty($_POST)) {
			$this->data = new stdClass();
			foreach ($_POST as $key => $value) {
				$this->data->$key=$value;
			}
			//debug($this->data);
		}
	}
}
?>