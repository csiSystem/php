<?php
/**
* 
*/
class SalleController extends controller
{
	function index(){
		$this->loadModel('salle');
		$conditions = array('fields' => array('id_salle','titre'),
							'id' => 'id_salle',
							'limit' => '3');
		$tb['salles'] = $this->salle->find($conditions);

		$tb['total'] = $this->salle->findCount($conditions);
		$this->set($tb);
	}
	function admin_view($id,$titre){
		$this->loadModel('salle');
		$recept_Result_sql['salle']= $this->salle->findFirst(array(
			'conditions' => array('id_salle' => $id)
		));
		if (empty($recept_Result_sql['salle'])) {
			$this->error404('Page Introuvable');
		}
		/*
		if ($titre != $recept_Result_sql['salle']->titre) {
			$this->redirect("salle/view/id:$id/titre:".$recept_Result_sql['salle']->titre);
		}*/
		$this->set($recept_Result_sql);
		

	}

	
	/**
	* Permet d'editer un salle
	*/
	function admin_edit($id = null){
		$this->loadModel('salle');

		//données recu depuis l'envoi du formulaire via Request
		$tb['id'] = '';
		$recept_data = $this->request->data;
		debug($recept_data);
		
		if ($recept_data) {
			if ($this->salle->validates($recept_data)) {
				/*
				*si nous avions un element de type data
				* $this->salle->data->created = date('y-m-d h:i:s'),
				*/

				//envoi des données au model de auvegarde
				$this->salle->save($recept_data);
				$this->Session->setFlash('Le contenue a bien été Modifier');

				//si les données on été envoyer on fait un redirectiion
				$this->redirect('admin/salle/index');
			}else{
				$this->Session->setFlash('Mercie de corriger les info','error');
			}

		}else{
			if ($id) {
				$this->request->data = $this->salle->findFirst(array(
				'conditions' => array('id_salle' => $id)
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
	function admin_index(){
		$this->loadModel('salle');
		$conditions = array('id' => 'id_salle',
							);
		$tb['salles'] = $this->salle->find($conditions);
		$tb['total'] = $this->salle->findCount($conditions);
		$this->set($tb);
	}

	function admin_delete($id){
		$this->loadModel('salle');
		$this->salle->delete($id);
		$this->Session->setFlash('Le contenue a bien été suprime');
		$this->redirect('admin/salle/index');
	}

}
?>