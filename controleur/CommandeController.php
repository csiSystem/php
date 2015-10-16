<?php
/**
* 
*/
class CommandeController extends controller
{
	function index(){
		$this->loadModel('commande');
		$conditions = array('fields' => array('id_commande','titre'),
							'id' => 'id_commande',
							'limit' => '3');
		
		$tb['commandes'] = $this->commande->find($conditions);

		$tb['total'] = $this->commande->findCount($conditions);
		$this->set($tb);
	}


	
	/**
	* Permet d'editer un commande
	*/
	function edit($id = null){
		$this->loadModel('commande');

		//données recu depuis l'envoi du formulaire via Request
		$tb['id'] = '';
		$recept_data = $this->request->data;
		debug($recept_data);
		if ($recept_data) {
			if ($this->commande->validates($recept_data)) {
				/*
				*si nous avions un element de type data
				* $this->commande->data->created = date('y-m-d h:i:s'),
				*/

				//envoi des données au model de auvegarde
				$this->commande->save($recept_data);
				$this->Session->setFlash('Le contenue a bien été Modifier');

				//si les données on été envoyer on fait un redirectiion
				$this->redirect('admin/commande/index');
			}else{
				$this->Session->setFlash('Mercie de corriger les info','error');
			}

		}else{
			if ($id) {
				$this->request->data = $this->commande->findFirst(array(
				'conditions' => array('id_commande' => $id)
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
	function admin_index($id=null){

		$this->loadModel('commande');
		$conditions = array('id' => 'id_commande',
							);
		$tb['detail'] = '';
		$tb['total'] = $this->commande->findCount($conditions);
		$ca =0;
		$requet_date = $this->commande->find($conditions);
		
		$tb['commandes'] = $requet_date;
		
		foreach ($requet_date as $key => $value) {
			$ca += $value->montant; 
		}
		$tb['chiffre_affaire']=$ca;
		
		if ($id) {
			$conditions = array(
			'fields' => array('commande.id_commande','produit.prix','commande.montant','commande.date','commande.id_membre','membre.pseudo','produit.id_produit','salle.id_salle','salle.ville'),
			'other_table' =>array('membre','produit','commande','details_commande','salle'),
			'conditions' => array('commande.id_membre' => 'membre.id_membre',
								'commande.id_commande' => 'details_commande.id_commande',
								'details_commande.id_produit' => 'produit.id_produit',
								'produit.id_salle' => 'salle.id_salle',
								$id =>'commande.id_commande') 
			);
			//debug($conditions);
		
		$tb['detail'] = $this->commande->find($conditions);
		}
		
		$this->set($tb);
		//debug($tb);
	}

	function delete($id){
		$this->loadModel('commande');
		$this->commande->delete($id);
		$this->Session->setFlash('Le contenue a bien été suprime');
		$this->redirect('admin/commande/index');
	}

}
?>