<?php
/**
* 
*/
class AvisController extends controller
{
	function index(){
		$this->loadModel('avis');
		$conditions = array('fields' => array('id_avis','titre'),
							'id' => 'id_avis',
							'limit' => '3');
		$tb['avis'] = $this->avis->find($conditions);

		$tb['total'] = $this->avis->findCount($conditions);
		$this->set($tb);
	}


	/**
	* Admin
	*/
	function admin_index(){
		$this->loadModel('avis');
		//$conditions = array('id' => 'id_avis');
		$conditions = array(
			'fields' => array('avis.commentaire',
							  'avis.note','avis.date',
							  'avis.id_salle',
							  'avis.id_avis',
							  'avis.id_membre'
							  ),
			'other_table' =>array('avis','salle','membre'),	
			'conditions' => array('avis.id_membre' => 'membre.id_membre',
								  'avis.id_salle' => 'salle.id_salle') 
			);
		$tb['avis'] = $this->avis->find($conditions);
		$tb['total'] = $this->avis->findCount( array('id' => 'id_avis'));
		$this->set($tb);
	}

	function view($id,$titre){
		$this->loadModel('avis');
		$recept_Result_sql['avis']= $this->avis->findFirst(array(
			'conditions' => array('id_avis' => $id)
		));
		if (empty($recept_Result_sql['avis'])) {
			$this->error404('Page Introuvable');
		}
		
		if ($titre != $recept_Result_sql['avis']->titre) {
			$this->redirect("avis/view/id:$id/titre:".$recept_Result_sql['avis']->titre);
		}
		$this->set($recept_Result_sql);
		

	}

	
	/**
	* Permet d'editer un avis
	*/
	function edit($id = null){
		$this->loadModel('avis');

		//données recu depuis l'envoi du formulaire via Request
		$tb['id'] = '';
		$recept_data = $this->request->data;
		echo $id;
		$this->request->data->note = $this->request->data->note + 1; 
		debug($recept_data);
		
		if ($recept_data) {
			if ($this->avis->validates($recept_data)) {
				/*
				*si nous avions un element de type data
				* $this->avis->data->created = date('y-m-d h:i:s'),
				*/
				$this->request->data->date = date('y-m-d h:i:s');
				//envoi des données au model de auvegarde
				$this->avis->save($recept_data);
				$this->Session->setFlash('Le contenue a bien été Modifier');
				$this->redirect('Visiteur/reservation_details/'.$id);

				
				
			}else{
				$this->Session->setFlash('Mercie de corriger les info','error');
				$this->redirect('Visiteur/reservation_details/'.$id);
			}

		}
		//envoi de notre table a la vue	
		
	}



	
	function admin_delete($id){
		$this->loadModel('avis');
		$this->avis->delete($id);
		$this->Session->setFlash('Le contenue a bien été suprime');
		$this->redirect('admin/avis/index');
	}

}
?>