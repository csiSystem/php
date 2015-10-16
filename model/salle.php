<?php
class salle extends Model
	{
		public $tables = 'salle';
		public $table_regle=array(
			'text' => '',
			'email' => '',
			'url' => '',
			'enum' => '',
			'alphanum' => '');
		var $validate = array(
			'titre' =>  array(
				'regle' =>'notEmpty',
				'message' =>"le titre n'est valide."),
			'adresse' =>  array(
				'regle' =>'notEmpty',
				'message' =>'Vous devez préciser un nom'),
			'ville' => array(
				'regle' =>'notEmpty',
				'message' =>'Vous devez préciser une ville')
				
		);
	}
?>