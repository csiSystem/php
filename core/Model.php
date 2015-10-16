<?php
class Model 
{
	public $db;
	public $conf = 'default';
	public $table = false;
	static $connextion = array();
	public $primarykey = 'id';
	public $id;
	public $errors = array();
	public $form ;


	public function __construct(){
		$conf = Conf::$database[$this->conf];
		//j'initialise qlq variables
		$this->table=$this->tables;
		
		//controlle si je suis deja connecté
		if (isset(Model::$connextion[$this->conf])){
			echo "connextion deja établie";
			$this->db = Model::$connextion[$this->conf];
			return true;
		}
		//ma connnection PDO
		try{
			$mypdoConnect =  new PDO('mysql:host='.$conf['host'].';dbname='.$conf['database'].';',
				$conf['login'],
				$conf['password'],
				array(PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8')
			);
			$mypdoConnect->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_WARNING);
			Model::$connextion[$this->conf] = $mypdoConnect;
			$this->db = $mypdoConnect;
			//echo "Connexion OK <br>";

		}catch(PDOException $e){
			if (Conf::$debug >= 1) {
				die(print_r($e->getMessage()));
			}else{
				die('Impossible de se connecter. <br>');
			}
			
		}
		
	}
	

	//initialisation de variable pour les requette
	/*if($this->table === false){
		$this->table = get_class($this);
	}*/

	

	public function find($reqt){
		$sql = 'SELECT ';
		if (isset($reqt['fields'])) {
			if(is_array($reqt['fields'])){
				$sql .= implode(', ', $reqt['fields']);
			}else{
				$sql .= $reqt['fields'];
			}
		}else{
			$sql .='*';
		}
		if(isset($reqt['other_table'])){
			if (is_array($reqt['other_table'])) {
				$sql .=' FROM '. implode(',', $reqt['other_table']).' ';
			}else{
				$sql .= ' FROM '.$reqt['other_table'].' ';
			}
				
		}else{
			//$sql .= ' FROM '.$this->table.' as '.get_class($this).' ';
			$sql .= ' FROM '.$this->table.' ';	
		}
		//construction de la condition 
		if (isset($reqt['conditions'])) {
			$sql .='WHERE ';
			if (!is_array($reqt['conditions'])) {
				$sql .= $reqt['conditions'];
			}else{
				$table_de_condtion = array();
				if (isset($reqt['other_table'])){
					if(is_array($reqt['other_table'])) {
					foreach ($reqt['conditions'] as $key => $value) {
						$table_de_condtion[] = "$key=$value";
					}}
				}else{
					foreach ($reqt['conditions'] as $key => $value) {
						if (!is_numeric($value)) {
							$value = '"'.mysql_escape_string($value).'"';
						}
						$table_de_condtion[] = "$key=$value";
					}
					
				} 
				$sql .= implode(' AND ', $table_de_condtion);
			}

		}
		if(isset($reqt['limit'])){
			$sql .='LIMIT '.$reqt['limit'];
		}
		//debug($sql);
		//die($sql);
		
		try {
			$pre = $this->db->prepare($sql);
			$pre->execute();
			return $pre->fetchAll(PDO::FETCH_OBJ);
		} catch (Exception $e) {
		    $e->getMessage();
		}
		//die($this->table);
	}

	public function findFirst($reqt){
		return current($this->find($reqt));
	}
	public function findCount($condition){
		$tb_condition = array();
		if (isset($condition['id'])) {
			$tb_condition['fields'] = 'COUNT('.$condition['id'].') as count'; 
		}
		if (isset($condition['conditions'])) {
			$tb_condition['conditions'] = $condition['conditions']; 
		}

		//die($this->primarykey);
		$rest = $this->findFirst($tb_condition);
		//debug($rest);
		return $rest->count;
	}
	public function delete($id){
		$this->primarykey .= '_'.$this->table ;
		$sql = "DELETE FROM {$this->table} WHERE {$this->primarykey}=$id";
		//debug($sql);die();
		$this->db->query($sql);
	}
	// INSERT ou UPDATE
	public function save($data, $table=null){
		//$cle_table = $this->primarykey.'_'.$this->table ;
		if ($table) {
			$cle_table = $table['id_table'];
			$table = $table['table'];

		}else{
			$cle_table = $this->primarykey.'_'.$this->tables ;
			$table = $this->table;
			if(isset($this->id_tables)){
				$cle_table = $this->id_tables;
			}
		}
		
		
		$les_champs = array();

		
		//tableau de valeurs (paramètres de nom)
		$tableau_de_valeurs = array();

		

		foreach ($data as $key => $value) {
			if ($key != $cle_table) {
				$les_champs[] = "$key=:$key";
				//tableau (paramètres de nom)
				$tableau_de_valeurs[":$key"] = $value;
			}elseif (!empty($value)) {
				//tableau (paramètres de nom)
				$tableau_de_valeurs[":$key"] = $value;
			}
		}
		
		if (isset($data->$cle_table) && !empty($data->$cle_table)) {
			$sql  = 'UPDATE '.$table.' SET '.implode(',',$les_champs).' WHERE '.$cle_table.'=:'.$cle_table;
			$this->id = $data->$cle_table;

			$action_save='update';
		}else{
			//if(isset($data->$cle_table)) unset($data->$cle_table);
			$sql = $sql  = 'INSERT INTO '.$table.' SET '.implode(',',$les_champs);
			$action_save='insert';
		}
		
		// On exécute la requête préparée avec un tableau de valeurs (paramètres de nom)
		
		if ($action_save == 'insert') {
			//on recuper la clé apres execution de la requete
			$this->id = $this->db->lastInsertId();
			//debug($this->db->lastInsertId());
			//debug($_SESSION['User']);
		}
		try {
			$pre = $this->db->prepare($sql);
			$pre->execute($tableau_de_valeurs);
			return true;
		} catch (Exception $e) {
		    $e->getMessage();
		}
		/*
		$pre = $this->db->prepare($sql);
		$pre->execute($tableau_de_valeurs);
		return true;*/

		
		
	}
	function validates($data){
		$errors = array();
		foreach ($this->validate as $key => $value) {
			//debug($data->$key);die();
			if (!isset($data->$key)) {
				$errors[$key] = $value['message'];
			}else{
				if ($value['regle'] == 'notEmpty') {
					if (empty($data->$key)) {
						$errors[$key] = $value['message'];
					}
				}elseif (!preg_match('/^'.$value['regle'].'$/', $data->$key)) {
					$errors[$key] = $value['message'];
				}
			}
		}
		$this->errors = $errors;
		if (isset($this->Form)) {
			$this->Form->errors = $errors;
		}
		if (empty($errors)) {
			return true;
		}
		return false;
		
	}
}
