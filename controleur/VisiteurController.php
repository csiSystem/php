<?php
class VisiteurController extends controller
{
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
					$this->Session->setFlash("Date est inferieur a la date d'aujourd'hui etape0",'error');
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
					$this->Session->setFlash("Désolé, aucun result trouvé etape1 ",'error');
					$tb['produit']=$produit;
					$tb['reserch']=true;
					$this->set($tb);
				}
				
			}
			if (sizeof($result_serch) == 0) {
				$this->Session->setFlash("Désolé, aucun result trouvé etape12",'error');
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
			//debug($data_rqt);
			//die();
			foreach ($data_rqt as $key => $value) {
				if ($value->etat != 1) {
					$date_arrivee = new Datetime($value->date_arrivee);

					if ($date_arrivee > $today && $value->id_produit == $id) {
						$detail[$id] = $value;
						$tb['detail_produit'] = $detail;
						//$adress,$cp,$ville,$pays
						$date_simil = date_create($value->date_arrivee);
						$date_ar = date_create($value->date_arrivee);
						$simil=$value->ville;
						$id_salle = $value->id_salle;
						$tb['adresse'] = array($value->adresse,$value->cp,$value->ville,$value->pays);
						$this->set($tb);
						
					}
				}
			}
			if ($simil !== '') {
				//$date_ar = $date_simil;
				date_add($date_simil,date_interval_create_from_date_string("3 days"));
				//echo date_format($date,"Y-m-d");
				$produit_similaire = array();
				foreach ($data_rqt as $key => $value) {
					$date_arrivee = date_create($value->date_arrivee);
					if ($value->etat != 1 && $date_ar <= $date_arrivee) {
						
						if ($date_arrivee > $today && $value->ville == $simil && $value->id_produit != $id && $date_arrivee < $date_simil) {
							$produit_similaire[$key] = $value;
						}
					}
				}
				if (sizeof($produit_similaire) != 0) {
					if (sizeof($produit_similaire < 3)) {
						foreach ($data_rqt as $key => $value) {
							$date_arrivee = date_create($value->date_arrivee);
							if (sizeof($produit_similaire) < 5){ 
								if ($value->etat != 1 && $date_ar <= $date_arrivee && !in_array($key, array_keys($produit_similaire))) {
									
									if ($date_arrivee > $today && $value->ville == $simil && $value->id_produit != $id) {
										$produit_similaire[$key] = $value;
									}
								}
							}else{
								break;
							}
						}
					}
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
			//debug($tb);
			if (sizeof($detail) == 0) {
				$this->Session->setFlash("Désolé, ce produit n'est plus disponible",'error');
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
		$str ='';

		if(!$file)  {
		  echo "Err: No access to Google service: ".$a."<br/>\n";
		}else {
			//$result = strpos($a,'are') !== false ? true : false;
			$get = simplexml_load_string($file);

			if ($get->status == "OK") {
				$lat = (float) $get->result->geometry->location->lat;
				$long = (float) $get->result->geometry->location->lng;
				echo "lat: ".$lat."; long: ".$long."; ".$a."<br/>\n";
				//exec("lat: ".$lat."; long: ".$long."; ".$a."<br/>\n";);
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
	function validation(){
		$recept_data = $this->request->data;
		
		
		if ($recept_data) {
			if (isset($this->request->data->sender)) {
				$tb_mail= array();
				$sender='';
				$this->loadModel('membre');
				$conditions = array('id' => 'id_membre');
				$table_req =  $this->membre->find($conditions);

				
				foreach ($table_req as $key => $value) {
					
					if (isset($id) && $id == $value->email) {
						$sender = $value->email;
					}
					if ($value->statut == 1) {
						$tb_mail[]=$value->email;
					}
				}
				$tb['sender']=$tb_mail;
				$headers='MIME-Version: 1.0' . "\r\n";
				$headers .= 'Content-type: text/html;charset=iso-8859-1' . "\r\n";
				$headers .= 'From: '.$recept_data->sender. "\r\n";
				$to = implode(',',$tb_mail);
				$subject = $recept_data->subject;
				$message =$recept_data->message;
				//mail function
				$mail = mail($to, $subject, $message, $headers);

				if(!$mail) {   
				    $this->Session->setFlash('Erreur de connextion. Massage non envoyer. Reésseyez plus tard','error');
				    
				}else {
				    $this->Session->setFlash('Votre email a été envoyer avec succes','succes');
				}
			}
		}else{
			$this->Session->setFlash('Votre inscription est validée, Merci de bien vouloir vous connnecter ','succes');
		}
		//envoi de notre table a la vue	
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
	function login(){
		$this->redirect("connection/login");
	}

	function inscription(){
		
		//Chargement de la pas inscrition
		//données recu depuis l'envoi du formulaire via Request
		if ($this->request->data) {
			$this->loadModel('membre');

			$cond_pseudo = array('fields' => array('pseudo'),
			'conditions' => array('pseudo' => $this->request->data->pseudo),
						);
			$cond_email = array('fields' => array('email'),
				'conditions' => array('email' => $this->request->data->email),
							);
			$verif_pseudo = $this->membre->findFirst($cond_pseudo);
			$verif_email = $this->membre->findFirst($cond_email);
						
			if ($this->membre->validates($this->request->data)) {
				/*
				*si nous avions un element de type data
				* $this->membre->data->created = date('y-m-d h:i:s'),
				*/
				if (!is_object($verif_email) && !is_object($verif_pseudo)){
					
					$this->membre->save($this->request->data);
					$this->Session->setFlash('Le contenue a bien été Modifier');
					//renvoi de la clè recuper apres save ou insertion

					//si les données on été envoyer on fait un redirectiion
					$this->redirect("Visiteur/validation");
					
				}else{
					
					if (is_object($verif_email)) {
						$this->Session->setFlash('Le PSEUDO est deja utilisé, veillez utiliser autres', 'erreur');
						echo "donéé existante I";

					}
					if (is_object($verif_pseudo)) {
						$this->Session->setFlash('votre EMAIL result deja utilisé', 'erreur');
						echo "donéé existante II";
					}
					
				}
				//debug($_SESSION);
			}else{
				$this->Session->setFlash('Mercie de corriger les info','erreur');
			}
		}
	}

	function mentions(){
		//$this->loadModel('membre');
		//Chargement de la pas inscrition
		//données recu depuis l'envoi du formulaire via Request
	}
	function test(){
		//$this->loadModel('membre');
		//Chargement de la pas inscrition
		//données recu depuis l'envoi du formulaire via Request
	}
	function cgv(){
		//$this->loadModel('membre');
		//Chargement de la pas inscrition
		//données recu depuis l'envoi du formulaire via Request
	}
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
					    $this->Session->setFlash('Email non envoi Erreur','error');
					} else {
					    $this->Session->setFlash('Votre email a été envoyer avec succes','succes');
					}
					//si les données on été envoyer on fait un redirectiion
					//$this->redirect('admin/newsletter/index');
				}else{
					$this->Session->setFlash('Mercie de corriger les info','error');
				}

			}else{
				
				$this->set($tb);
			}
		}


		


	
	
}
?>