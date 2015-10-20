<?php
	/**
	* 
	*/
	class NewsletterController extends controller
	{
		

		function admin_send(){
			$table= array();
			$sender='';
			$this->loadModel('newsletter');
			$conditions = array('id' => 'id_newsletter');

			$tb['total'] = $this->newsletter->findCount($conditions);
			$conditions = array(
				'fields' => array('membre.email','newsletter.id_newsletter','newsletter.id_membre'),
				'other_table' =>array('membre','newsletter'),
				'conditions' => array('newsletter.id_membre' => 'membre.id_membre') 
				);
			$table_req =  $this->newsletter->find($conditions);
			
			foreach ($table_req as $key => $value) {
				if ($value->id_membre != $this->Session->user('id_membre')) {
				 	$table[]= $value->email;
				}
			}
			
			if (sizeof($table) > 0) {
				$sender=$this->Session->user('id_membre');
				$tb['email'] = implode(',',$table);
				$tb['sender'] = $this->Session->user('id_membre');
			}
			$this->set($tb);
			
		}

		function admin_edit($id = null){
			$this->loadModel('newsletter');

			//données recu depuis l'envoi du formulaire via Request
			$tb['id'] = '';
			$recept_data = $this->request->data;
			//$conditions = array('id' => 'id_newsletter');
			//$ma_requet=$this->newsletter->findCount($conditions);
			if ($recept_data) {
				if ($this->newsletter->validates($recept_data)) {
					/*
					*si nous avions un element de type data
					* $this->salle->data->created = date('y-m-d h:i:s'),
					*/
					
					//envoi des données au model de auvegarde
					$this->newsletter->save($recept_data);
					$this->Session->setFlash('Message envoyer');

					//si les données on été envoyer on fait un redirectiion
					$this->redirect('admin/newsletter/index');
				}else{
					$this->Session->setFlash('Mercie de corriger les info','error');
				}

			}else{
				if ($id) {
					$conditions = array(
					'fields' => array('membre.email','membre.pseudo','membre.nom','membre.ville'),
					'other_table' =>array('membre'),
					'conditions' => array('membre.id_membre' => $id) 
					);
					foreach ($this->newsletter->find($conditions) as $key => $value) {
						//$mydata['id_membre']=$value->is_membre;
						$mydata['email']=$value->email;
						$mydata['pseudo']=$value->pseudo;
						$mydata['nom']=$value->nom;
						$mydata['ville']=$value->ville;
						
					}
					$tb['id'] = $id;
					$tb['mydata'] = $mydata;
					$tb['datamembre'] = $this->newsletter->find($conditions);
					//envoi de notre table a la vue	
					$this->set($tb);
				}
			}
					
					
		}
		function edit($id = null){
			if ($id != null) {
				# code...
			
				$this->loadModel('newsletter');
				//debug($this->request->params[0]);
				//$id = $this->request->params[0];
				//données recu depuis l'envoi du formulaire via Request
				//$tb['id'] = '';
				$recept_data = $this->request->data;
				
				if ($recept_data) {
					if ($this->newsletter->validates($recept_data)) {
						/*
						*si nous avions un element de type data
						* $this->salle->data->created = date('y-m-d h:i:s'),
						*/

						//envoi des données au model de auvegarde
						$this->newsletter->save($recept_data);
						$this->Session->setFlash('Votre Inscrition à la Newsletter a été bien envoyer');

						//si les données on été envoyer on fait un redirectiion
						//$this->redirect('newsletter/index');

					}else{
						$this->Session->setFlash('Mercie de corriger les info','error');
					}

				}else{
					$id = $this->request->params[0];
					if ($id) {
						$conditions = array(
						'fields' => array('membre.email','membre.pseudo','membre.nom','membre.ville'),
						'other_table' =>array('membre'),
						'conditions' => array('membre.id_membre' => $id) 
						);
						$marequet=$this->newsletter->find($conditions);
						debug($marequet);
						foreach ($marequet as $key => $value) {
							//$mydata['id_membre']=$value->is_membre;
							$mydata['email']=$value->email;
							$mydata['pseudo']=$value->pseudo;
							$mydata['nom']=$value->nom;
							$mydata['ville']=$value->ville;
							
						}
						$tb['id'] = $id;
						$tb['mydata'] = $mydata;
						$tb['datamembre'] = $this->newsletter->find($conditions);
						//envoi de notre table a la vue	
						$this->set($tb);
					}
				}
				//envoi de notre table a la vue	
				
			}else{
				if ($this->Session->isLogged()) {
					# code...
				}
			}
		}

		function inscription(){
			$this->loadModel('newsletter');
			$recept_data = $this->request->data;
			if ($this->Session->isLogged()) {
				
				$inscrit=false;
				$user = $this->newsletter->findFirst(array(
				'conditions' => array('newsletter.id_membre' => $this->Session->user('id_membre')))
				);
				if (is_object($user)) {
					$this->Session->setFlash('vous êtes déjà inscription à la newsletter','warning');
					$tb['inscrit']=$inscrit;
				}else{
					if ($recept_data) {
						if ($this->newsletter->validates($recept_data)) {
							//envoi des données au model de auvegarde
							$this->newsletter->save($recept_data);
							
							$this->Session->setFlash('vous êtes bien inscription à la newsletter','succes');
							$inscrit = true;
							$tb['inscrit']=$inscrit;
							//si les données on été envoyer on fait un redirectiion
							//$this->redirect('admin/newsletter/index');
						}else{
							$this->Session->setFlash('Mercie de corriger les info','error');
						}
					}

				}
				$this->set($tb);
			}else{
				$this->redirect('connection/login');
			}
		}/*
			$recept_data = $this->request->data;
					if ($recept_data) {
						if ($this->newsletter->validates($recept_data)) {
							//
							//*parametre d'envoi de message
							///
							$msg=array();
							$headers='MIME-Version: 1.0' . "\r\n";
							$headers .= 'Content-type: text/html;charset=iso-8859-1' . "\r\n";
							$headers .= 'From: System Admin '.$_POST['email'] . "\r\n";
							$to = $_POST['to'];
							$subject = $_POST['subject'];
							$message = $_POST['message'];
							//mail function
							$mail = mail($to, $subject, $message, $headers);
							if(!$mail) {   
							    $this->Session->setFlash('Email non envoi Erreur','error');
							} else {
							    $this->Session->setFlash('Votre email a été envoyer avec succes','succes');
							}
							//si les données on été envoyer on fait un redirectiion
							//$this->request->params=$msg;
							//$this->redirect('newsletter/index/');
						}else{
							$this->Session->setFlash('Mercie de corriger les info','error');
						}

					}else{
						$this->Session->setFlash('Echexc de connextion','error');
					}
					
		}*/
	}
?>