<?php
class gestion_promos extends Model
	{
		public $tables = 'promotion';
		public $id_tables = 'id_promo';
		
		
		public $table_regle=array(
			'text' => '',
			'email' => '',
			'url' => '',
			'enum' => '',
			'alphanum' => '');

		var $validate = array(
			'code_promo' =>  array(
				'regle' =>'notEmpty',
				'message' =>"le pseudo n'est la salle."),
			
				
		);
	}
?>