<?php
/**
* 
*/
class ProduitController extends controller
{
	/*
	function view($nom)
	{
		$this->set(array(
			'phrase' => 'Bienvenue sur la pages '.$nom,
			'nom'	 =>	'Machin'));
		$this->render('index');
	}*/

	function index(){
		$this->loadModel('produit');
		$conditions = array('fields' => array('id_produit'),
							'id' => 'id_produit');
		//$tb['produits'] = $this->produit->find($conditions);
		$tb['total'] = $this->produit->findCount($conditions);

		$conditions = array(
				'fields' => array('produit.etat','produit.id_produit','produit.date_arrivee','produit.date_depart','produit.prix','salle.id_salle','salle.titre','salle.capacite','salle.photo','salle.ville'),
				'other_table' =>array('produit','salle'),
				'conditions' => array('produit.id_salle' => 'salle.id_salle'),

				);
		
		//debug($this->produit->find($conditions));
		
		$today = new Datetime();

		// Verification de la adate avec celle du jour
		$data_rqt = $this->produit->find($conditions);
			
		foreach ($data_rqt as $key => $value) {
			if ($value->etat != 1) {
				$date_arrivee = new Datetime($value->date_arrivee);
				if ($date_arrivee > $today) {
					$produit[$key] = $value;
				}
				
			}
		}
		
		
		if (is_array($produit)) {
			$tb['produits']=$produit;
			//recuperation de trois derniers produits
			if (count($produit)<=3) {
				$last_produit = $produit;
			}else{
				$last_produit = array_splice($produit,count($produit)-3);
			}
			$tb['last_produit']=array_reverse($last_produit);
		}
		$this->set($tb);
	}


	
	function view($id,$description){
		$this->loadModel('produit');
		//echo "mon id : ".$id;
		$recept_Result_sql['produit']= $this->produit->findFirst(array(
			'conditions' => array('id_produit' => $id)
		));
		//echo "RESULTAT".$produits;pseudo
		
		if (empty($recept_Result_sql['produit'])) {
			$this->error404('Page Introuvable');
		}
		
		if ($description != $recept_Result_sql['produit']->description) {
			$this->redirect("produit/view/id:$id/description:".$recept_Result_sql['produit']->description);
		}
		$this->set($recept_Result_sql);
		

	}
	//echo convertTime('%Y-%m-%d %H:%M','%d.%m.%Y %H:%M','27.11.2009 23: 23');
	public function convertTime($dformat,$sformat,$ts) {
    	extract(strptime($ts,$sformat));
   		return strftime($dformat,mktime(
                          intval($tm_hour),
                          intval($tm_min),
                          intval($tm_sec),
                          intval($tm_mon)+1,
                          intval($tm_mday),
                          intval($tm_year)+1900
                        ));
  }


  	/**
	* Permet reecrire la daye 
	*/
	public function correctiondata($reupdata){
		$newdata= array();
		$obj = new stdClass();
		/*
		$this->data = new stdClass();
			foreach ($_POST as $key => $value) {
				$this->data->$key=$value;
			}*/
		$date_arrivee;
		$date_depart;
		$arrivee;
		$depart;
		//debug($reupdata);
		//$recept_data = $this->request->data;
		foreach ($reupdata as $key => $value) {
			if ($key != 'time_date_arrivee' && $key != 'time_date_depart' ){	
				if ($key == 'date_date_depart') {
					//$date_depart = str_replace('/', '.',$value);
					$k = explode('/', $value);
					$newdata['date_depart'] = $k[2].'-'.$k[1].'-'.$k[0].' '.$reupdata->time_date_depart;
				}elseif ($key == 'date_date_arrivee') {
					//$date_arrivee = str_replace('/', '.', $value);
					$h = explode('/', $value);
					$newdata['date_arrivee'] = $h[2].'-'.$h[1].'-'.$h[0].' '.$reupdata->time_date_arrivee;
				}else{
					
					$newdata[$key] = ' '.$value;
				}
			}
				
			//echo $value->timedate_depart;
		}/*
		foreach ($newdata as $key => $value) {
			if ($key == 'date_arrivee'  ) {
				$newdata[$key] = $value.' '.$time_arrivee;
				$arrivee = $value.' '.$time_arrivee;;
			}
			if ($key == 'date_depart') {
				$newdata[$key] = $value.' '.$time_depart;
				$depart =$value.' '.$time_depart;
			}
		}*/
		//$this->data = new stdClass();
		foreach ($newdata as $key => $value) {
			$obj->$key=$value;
		}
		$this->request->data =$obj;
		
		debug($this->request);
		//debug($newdata);
		/*

		$r = time();
		$k = new Datetime();
		$today = str_replace('\/','-',date('y/d/m',$r));
		//echo date('y/d/m',$r);
		$a = new Datetime('2015-11-24 23:30');
		echo $a->format('U').' ';
		echo $k->format('U');
		var_dump($k->format('U') < $a->format('U'));
		*/
		
		$today = new Datetime();
		if ($obj){
			$a = new Datetime($obj->date_arrivee);

			if ($obj->date_arrivee){
				$d = new Datetime($obj->date_depart);
				if ($a->format('U') > $a->format('U')){
					$this->Session->setFlash("La date de départ est superieur à la date d'arriver",'error');
					return false;
				}elseif ($a->format('U') < $today->format('U')) {
					$this->Session->setFlash("La date de départ est inférieur ou égale a la date d'aujourd'hui",'error');
					return false;
				}else{
					return $obj;	
				}
		
			}
		}
		
	}

	
	/**
	* Permet d'editer un produit
	*/
	function admin_edit($id = null){
		$this->loadModel('produit');

		//données recu depuis l'envoi du formulaire via Request
		$tb['id'] = '';
		
		$recept_data = $this->request->data;
		//unset($recept_data->time_date_arrivee);
		//debug($recept_data);

		
		//$this->request->data->date_date = $this->request->data->date_date_depart;
		
		//debug($recept_data); 
		if ($recept_data) {
			$h = explode('/', $this->request->data->date_date_arrivee);
			$this->request->data->date_arrivee = $h[2].'-'.$h[1].'-'.$h[0].' '.$this->request->data->time_date_arrivee;
				

			$k = explode('/', $this->request->data->date_date_depart);
			$this->request->data->date_depart = $k[2].'-'.$k[1].'-'.$k[0].' '.$this->request->data->time_date_depart;	

			unset($this->request->data->date_date_arrivee);
			unset($this->request->data->time_date_arrivee);
			unset($this->request->data->date_date_depart);
			unset($this->request->data->time_date_depart);



			$transform_data = $this->dateerrors($recept_data->date_arrivee,$recept_data->date_depart);
			/*debug($transform_data);
			debug($recept_data);
			debug($recept_data); */

			if  ($this->produit->validates($this->request->data) && $transform_data === true){
				//if (is_array($transform_data)) {
				/*
				*si nous avions un element de type data
				* $this->produit->data->created = date('y-m-d h:i:s'),
				*/

				//envoi des données au model de auvegarde
				$this->produit->save($recept_data);
				
				$this->Session->setFlash('Le contenue a bien été Modifier');

				//renvoi de la clè recuper apres save ou insertion
				//$id = $this->produit->id;
				
				//debug($this->produit);die();

				//si les données on été envoyer on fait un redirectiion
				$this->redirect('admin/produit/index');
			}else{
				$this->Session->setFlash('Mercie de corriger les info','error');
				if ($transform_data !== true) {
					$this->Session->setFlash($transform_data,'error');
					
				}
			}

			
		}else{
			if ($id) {
				$this->request->data = $this->produit->findFirst(array(
				'conditions' => array('id_produit' => $id)
				));
				$tb['id'] = $id;
				
			}
			$promo = $this->produit->find(array('other_table' => 'promotion'));
			$salle = $this->produit->find(array('other_table' => 'salle'));
			
			if ($salle) {
				$tableau_salle = array();
				foreach ($salle as $key => $value) {
				$tableau_salle[$value->id_salle] = $value->pays.' '.$value->ville.' '.$value->adresse.' '.$value->cp.' '.$value->titre.' '.$value->capacite.' '.$value->categorie;
				}
				$tb['tb_salle'] = $tableau_salle;
			}
			if ($promo) {
				$tableau_promo = array();
				foreach ($promo as $key => $value) {
				$tableau_promo[$value->id_promo] = $value->code_promo.' '.$value->reduction;
				}
				$tb['tb_promo'] = $tableau_promo;
			}
		}
		//envoi de notre table a la vue	
		$this->set($tb);
	}

	public function dateerrors($date_init,$date_end){
		$today = new Datetime();
		$a = new Datetime($date_init);
		if ($a){
			$d = new Datetime($date_end);
			if ($a->format('U') > $d->format('U')){
				$str = "La date de départ est superieur à la date d'arriver";
				return $str;
			}elseif ($a->format('U') < $today->format('U')) {
				$str = "La date de départ est inférieur ou égale a la date d'aujourd'hui";
				return $str;
			}else{
				return true;	
			}
		}
	}

	/**
	* Admin
	*/
	function admin_index(){
		$this->loadModel('produit');
		//debug($this->produit);die();
		$conditions = array('id' => 'id_produit');
		$tb['produits'] = $this->produit->find($conditions);

		$tb['promo'] = $this->produit->find(array('other_table' => 'promotion'));
		$tb['salle'] = $this->produit->find(array('other_table' => 'salle'));

		$tb['total'] = $this->produit->findCount($conditions);
		//die($this->produit->findCount($conditions)); flash
		//debug($tb);die();
		$this->set($tb);
	}

	function admin_delete($id){
		$this->loadModel('produit');
		$this->produit->delete($id);
		$this->Session->setFlash('Le contenue a bien été suprime');
		$this->redirect('admin/produit/index');
	}

}
?>