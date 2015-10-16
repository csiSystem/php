<?php
class Request
{
	
	public $url; // URL appellé pa r l'utilisateur
	function __construct(){
		$this->url = $_SERVER['PATH_INFO'];
	}
}
?>