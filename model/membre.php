<?php
	/**
	* 
	*/
	class membre extends Model
	{
		public $tables = 'membre';
		public $table_regle=array(
			'text' => '',
			'email' => '',
			'url' => '',
			'enum' => '',
			'alphanum' => '');
		var $validate = array(
			'pseudo' =>  array(
				'regle' =>'([a-zA-z]+)',
				'message' =>"le pseudo n'est valide."),
			'nom' =>  array(
				'regle' =>'([a-zA-z]+)',
				'message' =>'Vous devez préciser un nom'),
			'ville' => array(
				'regle' =>'notEmpty',
				'message' =>'Vous devez préciser une ville')
		);
	}
?>