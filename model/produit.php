<?php
class produit extends Model
	{
		public $tables = 'produit';
		public $table_regle=array(
			'text' => '',
			'email' => '',
			'url' => '',
			'enum' => '',
			'alphanum' => '');

		var $validate = array(
			'id_salle' =>  array(
				'regle' =>'notEmpty',
				'message' =>"le pseudo n'est la salle."),
			
				
		);
	}
?>