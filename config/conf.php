<?php

	/**
	* 
	*/
	class Conf 
	{
		static $debug =1;
		static $database = array(
		'default' => array(
			'host' => 'localhost',
			'database' => 'lokisalle',
			'login' => 'root',
			'password' => ''
		)
	);
	}

	

	Router::prefix('cockpit','admin');

	Router::connect('','visiteur/index');
	Router::connect('cockpit','cockpit/membre/index');	
	Router::connect('Membre/:pseudo-:id','membre/profil/id:([0-9]+)/pseudo:([a-z0-9\-]+)');
	Router::connect('Membre/*','membre/*');
	Router::connect('Visiteur/*','visiteur/*');

	
?>
