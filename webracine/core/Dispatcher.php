<?php
/**
* 
*/
class Dispatcher
{
	var $request;//toute les information demande par l'utilisateur

	function __construct()
	{
		$this->request = new Request();
		Router::parse($this->request->url,$this->request);
		print_r($this->request);
	}
}

?>