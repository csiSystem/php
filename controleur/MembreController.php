<?php
/**
* 
*/
class MembreController extends controller
{
	/**
	* login
	*/
	


	function contact($id=Null){
			$tb_mail= array();
			$sender='';
			$this->loadModel('membre');
			$conditions = array('id' => 'id_membre');
			$table_req =  $this->membre->find($conditions);

			
			foreach ($table_req as $key => $value) {
				
				if ($id && $id == $value->email) {
					$sender = $value->email;
				}
				if ($value->statut == 1) {
					$tb_mail[]=$value->email;
				}
			}
			$tb['sender']=$tb_mail;
			
			$recept_data = $this->request->data;
			if ($recept_data) {
				if ($this->newsletter->validates($recept_data)) {
					/*
					*parametre d'envoi de message
					*/

					$headers='MIME-Version: 1.0' . "\r\n";
					$headers .= 'Content-type: text/html;charset=iso-8859-1' . "\r\n";
					$headers .= 'From: '.$recept_data->sender. "\r\n";
					$to = implode(',',$tb_mail);
					$subject = $recept_data->subject;
					$message =$recept_data->message;
					//mail function
					$mail = mail($to, $subject, $message, $headers);

					if(!$mail) {   
					    $this->Session->setFlash('Email non envoi Erreur','erreur');
					    if (condition) {
					    	$this->redirect('membre/newsletter/index');
					    }
					} else {
					    $this->Session->setFlash('Votre email a été envoyer avec succes','succes');
					}
					//si les données on été envoyer on fait un redirectiion
					//$this->redirect('admin/newsletter/index');
				}else{
					$this->Session->setFlash('Mercie de corriger les info','erreur');
				}

			}else{
				
				$this->set($tb);
			}
		}
	function admin_users(){
		$this->loadModel('membre');
		//debug($this->membre);die();
		$conditions = array('fields' => array('id_membre','pseudo','nom','prenom','statut'),
							'id' => 'id_membre',
							);
		$tb['membres'] = $this->membre->find($conditions);

		$tb['total'] = $this->membre->findCount($conditions);
		//die($this->membre->findCount($conditions)); flash
		$this->set($tb);
	}

	function cgv(){
		//$this->loadModel('membre');
		//Chargement de la pas inscrition
		//données recu depuis l'envoi du formulaire via Request
		
		
	}

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
	function admin_index(){
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

	function profil($id=null,$pseudo=null){
		
		//debug($id);
		//die();
		$this->loadModel('membre');
		//echo "mon id : ".$id;
		if (!$this->Session->isLogged()) {
			$this->redirect('connection/login');		
		}
		$recept_Result_sql['membre']= $this->membre->findFirst(array(
			'conditions' => array('id_membre' => $id)
		));
		//echo "RESULTAT".$membres;
		if ($id) {
			$condition_comd = array(
			'fields' => array('commande.id_commande','commande.date'),
			'other_table' =>array('membre','commande'),
			'conditions' => array('commande.id_membre' => 'membre.id_membre',
									$id =>'membre.id_membre') 
			);
		}	//d
		$recept_commande= $this->membre->find($condition_comd);
		
		if (empty($recept_Result_sql['membre'])) {
			$this->error404('Page Introuvable');
		}

		$commande = (array) $recept_commande;

		if (is_array($commande)) {
			
			$recept_Result_sql['commande'] = $commande;
			//recuperation de trois derniers produits
			if (count($commande)<=3) {
				$last_command = $commande;
			}else{
				$last_command = array_splice($commande,count($commande)-3);
			}
			$recept_Result_sql['commande']=array_reverse($last_command);
		}

		
		if ($pseudo != $recept_Result_sql['membre']->pseudo) {
			$this->redirect("Membre/".$recept_Result_sql['membre']->pseudo.'-'.$recept_Result_sql['membre']->id_membre);
		}
		$this->set($recept_Result_sql);
		

	}
	function admin_profil(){
		//die();
		$id= $this->Session->read('User')->id_membre;
		$this->loadModel('membre');
		//echo "mon id : ".$id;
		debug($id);

		if (!$this->Session->isLogged()) {
			$this->redirect('connection/login');		
		}
		$recept_Result_sql['membre']= $this->membre->findFirst(array(
			'conditions' => array('id_membre' => $id)
		));
		debug($recept_Result_sql);
		debug(var_dump(empty($recept_Result_sql['membre'])));
		//die();
		
		/*
		if ($pseudo != $recept_Result_sql['membre']->pseudo) {
			$this->redirect("admin/".$recept_Result_sql['membre']->pseudo.'-'.$recept_Result_sql['membre']->id_membre);
		}*/
		$this->set($recept_Result_sql);
		

	}
	
	/*************************/
	function recherche(){
		$this->loadModel('produit');
		$conditions = array('fields' => array('id_produit'),
							'id' => 'id_produit');
		$tb['total'] = $this->produit->findCount($conditions);

		$conditions = array(
				'fields' => array('produit.etat','produit.id_produit','produit.date_arrivee','produit.date_depart','produit.prix','salle.id_salle','salle.titre','salle.capacite','salle.photo','salle.ville'),
				'other_table' =>array('produit','salle'),
				'conditions' => array('produit.id_salle' => 'salle.id_salle'),
				);
		$tb_annee = array("2015","2016","2017","2018","2019","2020","2021","2022","2023","2025","2026","2027");
		
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
		//par defaut on affiche toute nos offre
		if (is_array($produit)) {
			$tb['produit']=$produit;
			
		}
		$tb['reserch']=false;
		//Virification des donne arrivant du formulaire de rechercher
		if ($this->request->data) {
			
			$current_month = explode('-', $today->format("Y-m-d"))[0];
			$current_year =explode('-', $today->format("Y-m-d"))[1];
			$current_day =explode('-', $today->format("Y-m-d"))[2];

			$date_serch = $this->request->data;
			$mot_clef='';
			if ($date_serch->mot_clef){
				$mot_clef = $date_serch->mot_clef;
				
			}
			//formatage de la date pour la recherche
			
			$date=false;
			$today = new Datetime();
			// Recherche sur une date et ou un mois 
			if (is_numeric($date_serch->annee) && is_numeric($date_serch->mois)) {
				$mois = $date_serch->mois+1;
				$date = new Datetime($tb_annee[$date_serch->annee].'-'.$mois.'-'.$current_day);
				if ($date_serch->mois != $current_month) {
					$date = new Datetime($tb_annee[$date_serch->annee].'-'.$mois.'-01');
				}
				
				//debug($date);

			}else{
				if (is_numeric($date_serch->annee)) {
					$date = new Datetime($tb_annee[$date_serch->annee].'-'.$current_month.'-'.$current_day);
				}
				if (is_numeric($date_serch->mois)) {
					$mois = $date_serch->mois+1;
					$date = new Datetime($current_year.'-'.$mois.'-'.$current_day);
					if ($date_serch->mois != $current_month) {
						$date = new Datetime($tb_annee[$date_serch->annee].'-'.$mois.'-01');
					}
				}
			}
			//verification de la formation de la date
			if($date){
				if ($today->format("Y-m-d") <= $date->format("Y-m-d")) {
					$result_serch=array();
					if ($date_serch->mot_clef){
						foreach ($produit as $key => $value) {
							$date_arrivee = new Datetime($value->date_arrivee);
							if ($date_arrivee > $date) {
								if (strripos($value->ville,$date_serch->mot_clef) !== false || strripos($value->titre,$date_serch->mot_clef) !== false || strripos($value->capacite,$date_serch->mot_clef) !== false) {
								//$result = strpos($a,'are') !== false ? true : false;
									$result_serch[$key] = $value;
								}
							}
						}
					}else{
						foreach ($produit as $key => $value) {
							$date_arrivee = new Datetime($value->date_arrivee);
							if ($date_arrivee > $date) {
								$result_serch[$key] = $value;
							}
						}
					}
				}else{
					$this->Session->setFlash("Date est inferieur a la date d'aujourd'hui etape0",'erreur');
				}	
			}else{
				// si aucune date formatée verification du mot clé si saisie
				if ($date_serch->mot_clef) {
					foreach ($produit as $key => $value) {
						$date_arrivee = new Datetime($value->date_arrivee);
						if ($date_arrivee > $today) {
							if (strripos($value->ville, $date_serch->mot_clef) !== false || strripos($value->titre, $date_serch->mot_clef) !== false || strripos($value->capacite,$date_serch->mot_clef) !== false) {
							//$result = strpos($a,'are') !== false ? true : false;
								$result_serch[$key] = $value;
							}
						}
					}
				}else{
					$this->Session->setFlash("Désolé, aucun result trouvé etape1 ",'erreur');
					$tb['produit']=$produit;
					$tb['reserch']=true;
					$this->set($tb);
				}
				
			}
			if (sizeof($result_serch) == 0) {
				$this->Session->setFlash("Désolé, aucun result trouvé etape12",'erreur');
			}else{
				$tb['produit'] = $result_serch;
				$tb['reserch']=true;
			}
		}
		$this->set($tb);
		
		
		
	}
	function admin_recherche(){
		$this->loadModel('produit');
		$conditions = array('fields' => array('id_produit'),
							'id' => 'id_produit');
		$tb['total'] = $this->produit->findCount($conditions);

		$conditions = array(
				'fields' => array('produit.etat','produit.id_produit','produit.date_arrivee','produit.date_depart','produit.prix','salle.id_salle','salle.titre','salle.capacite','salle.photo','salle.ville'),
				'other_table' =>array('produit','salle'),
				'conditions' => array('produit.id_salle' => 'salle.id_salle'),
				);
		$tb_annee = array("2015","2016","2017","2018","2019","2020","2021","2022","2023","2025","2026","2027");
		
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
		//par defaut on affiche toute nos offre
		if (is_array($produit)) {
			$tb['produit']=$produit;
			
		}
		$tb['reserch']=false;
		//Virification des donne arrivant du formulaire de rechercher
		if ($this->request->data) {
			
			$current_month = explode('-', $today->format("Y-m-d"))[0];
			$current_year =explode('-', $today->format("Y-m-d"))[1];
			$current_day =explode('-', $today->format("Y-m-d"))[2];

			$date_serch = $this->request->data;
			$mot_clef='';
			if ($date_serch->mot_clef){
				$mot_clef = $date_serch->mot_clef;
				
			}
			//formatage de la date pour la recherche
			
			$date=false;
			$today = new Datetime();
			// Recherche sur une date et ou un mois 
			if (is_numeric($date_serch->annee) && is_numeric($date_serch->mois)) {
				$mois = $date_serch->mois+1;
				$date = new Datetime($tb_annee[$date_serch->annee].'-'.$mois.'-'.$current_day);
				if ($date_serch->mois != $current_month) {
					$date = new Datetime($tb_annee[$date_serch->annee].'-'.$mois.'-01');
				}
				
				//debug($date);

			}else{
				if (is_numeric($date_serch->annee)) {
					$date = new Datetime($tb_annee[$date_serch->annee].'-'.$current_month.'-'.$current_day);
				}
				if (is_numeric($date_serch->mois)) {
					$mois = $date_serch->mois+1;
					$date = new Datetime($current_year.'-'.$mois.'-'.$current_day);
					if ($date_serch->mois != $current_month) {
						$date = new Datetime($tb_annee[$date_serch->annee].'-'.$mois.'-01');
					}
				}
			}
			//verification de la formation de la date
			if($date){
				if ($today->format("Y-m-d") <= $date->format("Y-m-d")) {
					$result_serch=array();
					if ($date_serch->mot_clef){
						foreach ($produit as $key => $value) {
							$date_arrivee = new Datetime($value->date_arrivee);
							if ($date_arrivee > $date) {
								if (strripos($value->ville,$date_serch->mot_clef) !== false || strripos($value->titre,$date_serch->mot_clef) !== false || strripos($value->capacite,$date_serch->mot_clef) !== false) {
								//$result = strpos($a,'are') !== false ? true : false;
									$result_serch[$key] = $value;
								}
							}
						}
					}else{
						foreach ($produit as $key => $value) {
							$date_arrivee = new Datetime($value->date_arrivee);
							if ($date_arrivee > $date) {
								$result_serch[$key] = $value;
							}
						}
					}
				}else{
					$this->Session->setFlash("Date est inferieur a la date d'aujourd'hui etape0",'erreur');
				}	
			}else{
				// si aucune date formatée verification du mot clé si saisie
				if ($date_serch->mot_clef) {
					foreach ($produit as $key => $value) {
						$date_arrivee = new Datetime($value->date_arrivee);
						if ($date_arrivee > $today) {
							if (strripos($value->ville, $date_serch->mot_clef) !== false || strripos($value->titre, $date_serch->mot_clef) !== false || strripos($value->capacite,$date_serch->mot_clef) !== false) {
							//$result = strpos($a,'are') !== false ? true : false;
								$result_serch[$key] = $value;
							}
						}
					}
				}else{
					$this->Session->setFlash("Désolé, aucun result trouvé etape1 ",'erreur');
					$tb['produit']=$produit;
					$tb['reserch']=true;
					$this->set($tb);
				}
				
			}
			if (sizeof($result_serch) == 0) {
				$this->Session->setFlash("Désolé, aucun result trouvé etape12",'erreur');
			}else{
				$tb['produit'] = $result_serch;
				$tb['reserch']=true;
			}
		}
		$this->set($tb);
		
		
		
	}
	function reservation_details($id=null){
		if ($id) {
			$detail = array();
			$this->loadModel('produit');
			/*$conditions = array('fields' => array('id_produit'),
								'id' => 'id_produit');
			$tb['total'] = $this->produit->findCount($conditions);*/

			$conditions = array(
					'fields' => array('produit.etat','produit.id_produit','produit.date_arrivee','produit.date_depart','produit.prix','salle.id_salle','salle.titre','salle.capacite','salle.photo','salle.ville','salle.adresse','salle.description','salle.categorie','salle.cp','salle.pays'),
					'other_table' =>array('produit','salle'),
					'conditions' => array('produit.id_salle' => 'salle.id_salle')
			);
			$today = new Datetime();
			// Verification de la adate avec celle du jour
			$data_rqt = $this->produit->find($conditions);
			$id_salle = 0;
			$simil='';
			debug($data_rqt);
			//die();
			foreach ($data_rqt as $key => $value) {
				if ($value->etat != 1) {
					$date_arrivee = new Datetime($value->date_arrivee);
					if ($date_arrivee > $today && $value->id_produit == $id) {
						$detail[$id] = $value;
						$tb['detail_produit'] = $detail;
						//$adress,$cp,$ville,$pays
						$simil=$value->ville;
						$id_salle = $value->id_salle;
						$tb['geolocal'] = $this->geolocal_latLong($value->adresse,$value->cp,$value->ville,$value->pays);
						break;
					}
				}
			}
			if ($simil !== '') {
				$produit_similaire = array();
				foreach ($data_rqt as $key => $value) {
					if ($value->etat != 1) {
						$date_arrivee = new Datetime($value->date_arrivee);
						if ($date_arrivee > $today && $value->ville == $simil && $value->id_produit != $id ) {
							$produit_similaire[$key] = $value;
						}
					}
				}
				if (sizeof($produit_similaire) != 0) {
					$tb['similaire'] = $produit_similaire;		
				}
			}
			if ($id_salle != 0) {
				//$this->loadModel('avis');
				$condition_count = array('fields' => array('id_produit'),
								'id' => 'id_avis');
				//$tb['total_avis'] = $this->produit->findCount($condition_count);

				$conditions = array(
					'fields' => array('avis.commentaire',
							  'avis.note','avis.date',
							  'avis.id_salle',
							  'avis.id_avis',
							  'avis.id_membre',
							  ),
				'other_table' =>array('avis','salle'),	
				'conditions' => array('salle.id_salle' => 'avis.id_salle',
									'avis.id_salle' => $id_salle),
				);
				$tb['avis'] = $this->produit->find($conditions);
				if (sizeof($tb['avis'] != 0)) {
					$note_moyen= 0;
					foreach ($tb['avis'] as $key => $value) {
						$note_moyen += $value->note;
					}
					if ($note_moyen != 0) {
						$moyenne =  round($note_moyen / sizeof($tb['avis'])* 2) / 2;
						$tb['moyenne'] = $moyenne;
					}else{
						$tb['moyenne'] = $note_moyen;
					}
				}
				//$tb['total_avis'] = $this->avis->findCount( array('id' => 'id_avis','avis.id_salle' => $id_salle));
			}
			debug($tb);
			if (sizeof($detail) == 0) {
				$this->Session->setFlash("Désolé, ce produit n'est plus disponible",'erreur');
			}else{
				
				$this->set($tb);
			}
		}else
		{
			$this->redirect('');
		}
		

	}
	function admin_reservation_details($id=null){
		if ($id) {
			$detail = array();
			$this->loadModel('produit');
			/*$conditions = array('fields' => array('id_produit'),
								'id' => 'id_produit');
			$tb['total'] = $this->produit->findCount($conditions);*/

			$conditions = array(
					'fields' => array('produit.etat','produit.id_produit','produit.date_arrivee','produit.date_depart','produit.prix','salle.id_salle','salle.titre','salle.capacite','salle.photo','salle.ville','salle.adresse','salle.description','salle.categorie','salle.cp','salle.pays'),
					'other_table' =>array('produit','salle'),
					'conditions' => array('produit.id_salle' => 'salle.id_salle')
			);
			$today = new Datetime();
			// Verification de la adate avec celle du jour
			$data_rqt = $this->produit->find($conditions);
			$id_salle = 0;
			$simil='';
			debug($data_rqt);
			//die();
			foreach ($data_rqt as $key => $value) {
				if ($value->etat != 1) {
					$date_arrivee = new Datetime($value->date_arrivee);
					if ($date_arrivee > $today && $value->id_produit == $id) {
						$detail[$id] = $value;
						$tb['detail_produit'] = $detail;
						//$adress,$cp,$ville,$pays
						$simil=$value->ville;
						$id_salle = $value->id_salle;
						$tb['geolocal'] = $this->geolocal_latLong($value->adresse,$value->cp,$value->ville,$value->pays);
						break;
					}
				}
			}
			if ($simil !== '') {
				$produit_similaire = array();
				foreach ($data_rqt as $key => $value) {
					if ($value->etat != 1) {
						$date_arrivee = new Datetime($value->date_arrivee);
						if ($date_arrivee > $today && $value->ville == $simil && $value->id_produit != $id ) {
							$produit_similaire[$key] = $value;
						}
					}
				}
				if (sizeof($produit_similaire) != 0) {
					$tb['similaire'] = $produit_similaire;		
				}
			}
			if ($id_salle != 0) {
				//$this->loadModel('avis');
				$condition_count = array('fields' => array('id_produit'),
								'id' => 'id_avis');
				//$tb['total_avis'] = $this->produit->findCount($condition_count);

				$conditions = array(
					'fields' => array('avis.commentaire',
							  'avis.note','avis.date',
							  'avis.id_salle',
							  'avis.id_avis',
							  'avis.id_membre',
							  ),
				'other_table' =>array('avis','salle'),	
				'conditions' => array('salle.id_salle' => 'avis.id_salle',
									'avis.id_salle' => $id_salle),
				);
				$tb['avis'] = $this->produit->find($conditions);
				if (sizeof($tb['avis'] != 0)) {
					$note_moyen= 0;
					foreach ($tb['avis'] as $key => $value) {
						$note_moyen += $value->note;
					}
					if ($note_moyen != 0) {
						$moyenne =  round($note_moyen / sizeof($tb['avis'])* 2) / 2;
						$tb['moyenne'] = $moyenne;
					}else{
						$tb['moyenne'] = $note_moyen;
					}
				}
				//$tb['total_avis'] = $this->avis->findCount( array('id' => 'id_avis','avis.id_salle' => $id_salle));
			}
			debug($tb);
			if (sizeof($detail) == 0) {
				$this->Session->setFlash("Désolé, ce produit n'est plus disponible",'erreur');
			}else{
				
				$this->set($tb);
			}
		}else
		{
			$this->redirect('');
		}
		

	}
	function geolocal_latLong($adress,$cp,$ville,$pays){
		$street="48 Boulevard de Bercy"; $postcode="75012"; $city="Paris"; $region="France";
		$adress_par_defaut['rue']= ' 31 Avenue George V';
		$adress_par_defaut['cp']= '75008';
		$adress_par_defaut['ville']='Paris';
		$adress_par_defaut['pays']='France';
		$default_a=$adress_par_defaut['rue'].", ".$adress_par_defaut['cp'].", ".$adress_par_defaut['ville'].", ".$adress_par_defaut['pays'];
		$default_address = urlencode($default_a);
		$default_link = "http://maps.google.com/maps/api/geocode/xml?address=".$default_address."&sensor=false";
		$default_file = file_get_contents($default_link);



		$a=$adress.", ".$cp.", ".$ville.", ".$pays;
		$address = urlencode($a);
		$link = "http://maps.google.com/maps/api/geocode/xml?address=".$address."&sensor=false";
		$file = file_get_contents($link);

		if(!$file)  {
		  echo "Err: No access to Google service: ".$a."<br/>\n";
		}else {
			//$result = strpos($a,'are') !== false ? true : false;
			$get = simplexml_load_string($file);

			if ($get->status == "OK") {
				$lat = (float) $get->result->geometry->location->lat;
				$long = (float) $get->result->geometry->location->lng;
				echo "lat: ".$lat."; long: ".$long."; ".$a."<br/>\n";
				$geolocal['latitude'] = $lat;
				$geolocal['longitude'] = $long;
				return $geolocal; 
			}else{
				if(!$default_file) {
				  echo "Err: No access to Google service: ".$a."<br/>\n";
				}else {
					//$result = strpos($a,'are') !== false ? true : false;
					$get = simplexml_load_string($default_file);

					if ($get->status == "OK") {
						$lat = (float) $get->result->geometry->location->lat;
						$long = (float) $get->result->geometry->location->lng;
						echo "lat: ".$lat."; long: ".$long."; ".$a."<br/>\n";
						$geolocal['latitude'] = $lat;
						$geolocal['longitude'] = $long;
						return $geolocal;
					}else{		
						echo "Err: address not found: ".$a."<br/>\n";
		  			}
				}
			}
		}
	}


	function reservation(){
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
			$tb['produit']=$produit;
			$this->set($tb);
		}
	}
	function admin_reservation(){
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
			$tb['produit']=$produit;
			$this->set($tb);
		}
	}

	/************************/
	
	/**
	* Permet d'editer un membre
	*/
	function admin_edit($id = null){
		$this->loadModel('membre');

		//données recu depuis l'envoi du formulaire via Request
		$tb['id'] = '';
		$recept_data = $this->request->data;
		if ($recept_data) {
			
			if ($this->membre->validates($recept_data)) {
				
				//envoi des données au model de auvegarde
				$this->membre->save($recept_data);
				
				$this->Session->setFlash('Le contenue a bien été Modifier');

				//si les données on été envoyer on fait un redirectiion

				$this->redirect('admin/Membre/index');
			}else{
				$this->Session->setFlash('Mercie de corriger les info','erreur');
			}

			
		}else{
			if ($id) {
				$this->request->data = $this->membre->findFirst(array(
				'conditions' => array('id_membre' => $id)
				));
				$tb['id'] = $id;
			}
		}
		//envoi de notre table a la vue	
		$this->set($tb);
	}

	function edit($id = null){
		$this->loadModel('membre');

		//données recu depuis l'envoi du formulaire via Request
		$tb['id'] = '';
		$recept_data = $this->request->data;
		if ($recept_data) {
			
			if ($this->membre->validates($recept_data)) {
				//envoi des données au model de auvegarde
				$this->membre->save($recept_data);
				
				$this->Session->setFlash('Le contenue a bien été Modifier');

				//si les données on été envoyer on fait un redirectiion
				$this->redirect('Membre/index');
			}else{
				$this->Session->setFlash('Mercie de corriger les info','erreur');
			}

			
		}else{
			if ($id) {
				$this->request->data = $this->membre->findFirst(array(
				'conditions' => array('id_membre' => $id)
				));
				$tb['id'] = $id;
			}
		}
		//envoi de notre table a la vue	
		$this->set($tb);
	}



	/**
	* Admin
	*/
	
	function admin_delete($id){
		$this->loadModel('membre');
		$this->membre->delete($id);
		$this->Session->setFlash('Le contenue a bien été suprime');
		$this->redirect('admin/index');
	}

	function panier(){
		$this->loadModel('produit');
		

		if ($this->Session->read('panier')) {
			foreach ($this->Session->read('panier') as $key => $value) {
				
				$conditions = array(
				'fields' => array('salle.id_salle','salle.titre','salle.capacite','salle.photo','salle.ville'),
				'other_table' =>array('produit','salle'),
				'conditions' => array('produit.id_salle' => 'salle.id_salle',
									'produit.id_produit' => $key) 
				);
				$dt = $this->produit->find($conditions);
				
				if (sizeof($dt)>0){
					foreach ($dt as $v) {
						$data_rql [$key]= $v;
					}
				}
			}
			if ($data_rql) {
				$tb['salle']= $data_rql;
			}
			$tb['montant'] = $this->Session->montant_panier();
			$this->set($tb);

		}else{
			$this->redirect('connection/login');
		}
	}
	function admin_panier(){
		$this->loadModel('produit');
		

		if ($this->Session->read('panier')) {
			foreach ($this->Session->read('panier') as $key => $value) {
				
				$conditions = array(
				'fields' => array('salle.id_salle','salle.titre','salle.capacite','salle.photo','salle.ville'),
				'other_table' =>array('produit','salle'),
				'conditions' => array('produit.id_salle' => 'salle.id_salle',
									'produit.id_produit' => $key) 
				);
				$dt = $this->produit->find($conditions);
				if (sizeof($dt)>0){
					foreach ($dt as $v) {
						$data_rql [$key]= $v;
					}
				}
			}
			if ($data_rql) {
				$tb['salle']= $data_rql;
			}
			$tb['montant'] = $this->Session->montant_panier();
			$this->set($tb);

		}else{
			$this->redirect('connection/login');
		}
	}
	function panier_promo(){
		$this->loadModel('produit');
		if ($this->request->data) {
			/*
			*Gestion des code promo
			*/
			$data_promo= array();
			$conditions = array(
					'fields' => array('promotion.code_promo','promotion.reduction'),
					'other_table' =>array('produit','promotion'),
					'conditions' => array('produit.id_promo' => 'promotion.id_promo') 
					);
			
			foreach ($_SESSION['panier'] as $key => $value) {
		    	//debug($value);
		    	if ($value['id_promo'] != 0) {
		    		$conditions = array(
					'fields' => array('promotion.code_promo','promotion.reduction'),
					'other_table' =>array('produit','promotion'),
					'conditions' => array('produit.id_promo' => 'promotion.id_promo',
						'produit.id_produit'=>$key) 
					);
					$data_promo[$key] = (array)$this->produit->findFirst($conditions);
					//debug($data_promo);					
					
		    	}
		    }
		    
		    if (sizeof($data_promo) != 0 ) {
				//debug($data_promo);
				//and $this->request->data == $data_promo['code_promo'] 
				//$_SESSION['panier'][$key]['prix'] = $_SESSION['panier'][$key]['prix'] - $data_promo['reduction'];
				//$_SESSION['panier'][$key]['statut']= 1;
				$a = false;
				foreach ($data_promo as $k => $v) {
					# code...
				
					foreach ($_SESSION['panier'] as $key => $value) {
			    		//debug($v['code_promo']);
			    		//debug($this->request->data->code_promo);
			    		//die();
			    		if ($k == $key and $v['code_promo'] == $this->request->data->code_promo){
							//debug($value['prix'] - $data_promo[$key]['reduction']);
							$value['prix'] = $value['prix'] - $data_promo[$key]['reduction'];
							$value['statut']= 1;
							$value['id_promo']= 0;
							//debug($value);
							$this->Session->ajout_panier($value);
							$a = true;
						}
				    }
			    }
			    if ($a != true) {
			    	$this->Session->setFlash("votre code de promotion n'est pas valabe pour ces produit du panier",'warning');
			    }else{
			    	$this->Session->setFlash("votre code de promotion est appliqué au panier",'succes');
			    }
			    
			}else{
				$this->Session->setFlash('vos produit ne sont pas en promotion ou vos code sont deja utilse pour ce panier','warning');
			}
			$this->redirect('Membre/panier');
		}
	}
	function admin_panier_promo(){
		$this->loadModel('produit');
		if ($this->request->data) {
			/*
			*Gestion des code promo
			*/
			$data_promo= array();
			$conditions = array(
					'fields' => array('promotion.code_promo','promotion.reduction'),
					'other_table' =>array('produit','promotion'),
					'conditions' => array('produit.id_promo' => 'promotion.id_promo') 
					);
			
			foreach ($_SESSION['panier'] as $key => $value) {
		    	//debug($value);
		    	if ($value['id_promo'] != 0) {
		    		$conditions = array(
					'fields' => array('promotion.code_promo','promotion.reduction'),
					'other_table' =>array('produit','promotion'),
					'conditions' => array('produit.id_promo' => 'promotion.id_promo',
						'produit.id_produit'=>$key) 
					);
					$data_promo[$key] = (array)$this->produit->findFirst($conditions);
					//debug($data_promo);					
					
		    	}
		    }
		    //debug($_SESSION['panier']);
		    //$this->redirect('/membre/panier');
		   
			if (sizeof($data_promo) != 0 ) {
				//debug($data_promo);
				//and $this->request->data == $data_promo['code_promo'] 
				//$_SESSION['panier'][$key]['prix'] = $_SESSION['panier'][$key]['prix'] - $data_promo['reduction'];
				//$_SESSION['panier'][$key]['statut']= 1;
				$a = false;
				foreach ($data_promo as $k => $v) {
					# code...
				
					foreach ($_SESSION['panier'] as $key => $value) {
			    		//debug($v['code_promo']);
			    		//debug($this->request->data->code_promo);
			    		//die();
			    		if ($k == $key and $v['code_promo'] == $this->request->data->code_promo){
							//debug($value['prix'] - $data_promo[$key]['reduction']);
							$value['prix'] = $value['prix'] - $data_promo[$key]['reduction'];
							$value['statut']= 1;
							$value['id_promo']= 0;
							//debug($value);
							$this->Session->ajout_panier($value);
							$a = true;
						}
				    }
			    }
			    if ($a != true) {
			    	$this->Session->setFlash("votre code de promotion n'est pas valabe pour ces produit du panier");
			    }
			}else{
				$this->Session->setFlash('vos produit ne sont pas en promotion ou vos code sont deja utilse pour ce panier');
			}
			$this->redirect('admin/panier');
		}
	}

	function supprime_panier($id=null){
		$this->loadModel('produit');
		//debug($id);
		
		if($id){
			debug(array_keys($this->Session->read('panier')));
			//die();
			$table_keys = array_keys($this->Session->read('panier'));
			foreach ($table_keys as $key) {
				//debug('kkkkk '.$key);
				if ($key == $id) {
					$this->Session->supprim_article2($id);
				}
			}
			
		}else{
			$this->Session->vider_panier();
			$this->Session->setFlash('Votre panier a bien été vidé');
		}
		
		$this->redirect('Membre/panier');

	}

	function admin_supprime_panier($id=null){
		$this->loadModel('produit');
		if($id){
			debug(array_keys($this->Session->read('panier')));
			$table_keys = array_keys($this->Session->read('panier'));
			foreach ($table_keys as $key) {
				if ($key == $id) {
					$this->Session->supprim_article2($id);
				}
			}
			/*if (array_search($id,array_keys($this->Session->read('panier')))) {
				$this->Session->supprim_article2($id);
				
			}*/
		}else{
			$this->Session->vider_panier();
			$this->Session->setFlash('Votre panier a bien été vidé');
		}
		
		$this->redirect('admin/panier');

	}

	function payer_panier(){
		//debug($this->request->data);
		//die();
		if ($this->request->data->payer == 0){
			$this->Session->setFlash('Vous devez accepter les conditions generales de ventes','erreur');
			$this->redirect('Membre/panier');
		}else{
			if ($this->request->data->payer == 1) {
				//debug($this);

				$this->loadModel('commande');
				$this->request->data->date = date('y-m-d h:i:s');
				unset($this->request->data->payer);
				$this->commande->data= $this->request->data;
								
				if($this->commande->save($this->commande->data)){
					
					//$conditions = array('id' => 'id_commande');
					$conditions = array('fields' => array('id_commande'),
							'id' => 'id_commande');
					$table_req =  $this->commande->find($conditions);
					$max=0;
					foreach ($table_req as $key => $value) {
						if ($max < $value->id_commande) {
							$max = $value->id_commande;
						}
						
					}
					unset($this->request->data->montant);
					unset($this->request->data->id_membre);
					unset($this->request->data->date);
					$table = array('table'=>'details_commande','id_table'=>'id_details_commande');
					
					$this->request->data->id_commande=$max;
					//debug($_SESSION['panier']);
					foreach ($_SESSION['panier'] as $key => $value) {
						
						$this->request->data->id_produit = $_SESSION['panier'][$key]['id_produit'];
						//debug($this->request->data);
						$this->commande->save($this->commande->data,$table);

					}
					$this->loadModel('produit');
					unset($this->request->data->id_commande);
					$this->produit->data= $this->request->data;
					foreach ($_SESSION['panier'] as $key => $value) {
						//unset($this->request->data->id_produit);
						
						$this->request->data->etat =  1;
						//debug($this->request->data);
						$this->produit->save($this->produit->data);

					}
					$this->Session->preparerPaiement();
					//$this->membre->data->
					$this->Session->paiementAccepte();
					$this->Session->setFlash('Transaction votre achat a bien été effectuée');
					$this->redirect('Membre/panier');
				}
				$this->Session->setFlash('Erreur de connexion essayer plus tard');
				$this->redirect('Membre/panier');
			}
		}
		
	}
	function admin_payer_panier(){
		//debug($this->request->data);
		//die();
		if ($this->request->data->payer == 0){
			$this->Session->setFlash('Vous devez accepter les conditions generales de ventes');
			$this->redirect('Membre/panier');
		}else{
			if ($this->request->data->payer == 1) {
				//debug($this);

				$this->loadModel('commande');
				$this->request->data->date = date('y-m-d h:i:s');
				unset($this->request->data->payer);
				$this->commande->data= $this->request->data;
								
				if($this->commande->save($this->commande->data)){
					
					//$conditions = array('id' => 'id_commande');
					$conditions = array('fields' => array('id_commande'),
							'id' => 'id_commande');
					$table_req =  $this->commande->find($conditions);
					$max=0;
					foreach ($table_req as $key => $value) {
						if ($max < $value->id_commande) {
							$max = $value->id_commande;
						}
						
					}
					unset($this->request->data->montant);
					unset($this->request->data->id_membre);
					unset($this->request->data->date);
					$table = array('table'=>'details_commande','id_table'=>'id_details_commande');
					
					$this->request->data->id_commande=$max;
					//debug($_SESSION['panier']);
					foreach ($_SESSION['panier'] as $key => $value) {
						
						$this->request->data->id_produit = $_SESSION['panier'][$key]['id_produit'];
						//debug($this->request->data);
						$this->commande->save($this->commande->data,$table);

					}
					$this->loadModel('produit');
					unset($this->request->data->id_commande);
					$this->produit->data= $this->request->data;
					foreach ($_SESSION['panier'] as $key => $value) {
						//unset($this->request->data->id_produit);
						
						$this->request->data->etat =  1;
						//debug($this->request->data);
						$this->produit->save($this->produit->data);

					}
					$this->Session->preparerPaiement();
					//$this->membre->data->
					$this->Session->paiementAccepte();
					$this->Session->setFlash('Transaction votre achat a bien été effectuée');
					$this->redirect('admin/panier');
				}
				$this->Session->setFlash('Erreur de connexion essayer plus tard');
				$this->redirect('admin/panier');
			}
		}
		
	}

}
?>