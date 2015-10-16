<?php
class ConnectionController extends controller
{
	/**
	* login
	*/
	
	function login(){
		//debug("je suis ".$idpage);
		if($this->request->data){
			$data = $this->request->data;
			//$data->mdp = SHa1($data->mdp);read
			//debug($this->request->data);
			$this->loadModel('membre');
			$user = $this->membre->findFirst(array(
				'conditions' => array('pseudo' => $data->pseudo,'mdp'=> $data->mdp))
				);
			if (!empty($user)) {
				$this->Session->write('User',$user);
			}
			$this->request->data->mdp = '';
			
		}
		
		if($this->Session->isLogged()){
			if ($this->Session->user('statut') == 1) {
				
				if($this->Session->read('panier')){
					$this->redirect('admin/Membre/panier');
				}else{
					$this->redirect('cockpit');
				}
			}else{
				if($this->Session->read('panier')){
					$this->redirect('Membre/panier');
				}else{
					$this->redirect('Membre/index');
				}
			}
				
		}else{
			if ($this->request->data) {
				$this->Session->setFlash('Erreur de connection, veillez verifier vos données','erreur');
			}
			
		}
	}
	function mdpperdu(){
		if($this->request->data){
			$this->loadModel('membre');
			$user = $this->membre->findFirst(array(
				'conditions' => array('email' => $this->request->data->email),
				'fields' => array('id_membre','pseudo'))
				);
			if (!empty($user)) {
				//recuperation du mode passe generé
				$mdp_tmp = $this->random_password(8);
				unset($user->mdp);
				
				$user->mdp = $mdp_tmp;
				
				if(!$this->membre->save($user)){
					$this->Session->setFlash('Erreur de connexion, veillez essayer plus tards','erreur');
				}else{
					//envoi du nouveau mot de passe aau membre
					/*
						$to = "to@mail.com";
						$subject = "yoursubject";
						$message = "yourmessage";
						$headers = "yourheaders";
						$parameters = "yourparameters";

						mail($to,$subject,$message,$headers,$parameters);
					*/

					

					$password=$mdp_tmp;

					$email=$this->request->data->email;

					$subject="Votre mot de passe";
					//notre lo@
					$header="from:lokisalle@lokisalle.com";

					$message='bonjour '.$user->pseudo.'vorte mote-de-passe '.$password;

					mail($email, $subject, $message, $header);

					$this->Session->setFlash("Un email contenat votre mot de passe vous a été envoyé.",'succes');
				}
				
				
			}else{

				$this->Session->setFlash("Désolé aucun membre identifié avec ce email.",'succes');
			}
			$this->request->data->mdp = '';
			
		}
		
		
	}
	//regeneration automatique du mode passe
	function random_password( $length = 8 ) {
    	$chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$%^&*()_-=+;:,.?";
    	//$chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
   	 	$password = substr( str_shuffle( $chars ), 0, $length );
   	 	return $password;
	}
	
	function logout(){
		unset($_SESSION['User']);
		if($_SESSION['panier']){
			unset($_SESSION['panier']);
			$this->Session->setFlash('votre panier est vide');
		}
		$this->Session->setFlash('Vous est bien déconnecter');
		$this->redirect('/');

	}
	
	function connexion_panier($idpage){
		$this->loadModel('produit');

		$produit = $this->produit->findFirst(array(
				'conditions' => array('id_produit' => $idpage))
				);
		$dataTb= (array) $produit;
		
		if ($idpage && $produit){
			$this->Session->ajout_panier($dataTb);
			$this->redirect("connection/login");
		}

	}
}
?>