<?php
/**
* 
*/
class Gestion_promosController extends controller
{
	function index(){
		$this->loadModel('gestion_promos');
		$conditions = array('fields' => array('id_promo','titre'),
							'id' => 'id_promo',
							'limit' => '3');
		$tb['promos'] = $this->gestion_promos->find($conditions);

		$tb['total'] = $this->gestion_promos->findCount($conditions);
		$this->set($tb);
	}
	function view($id,$titre){
		$this->loadModel('gestion_promos');
		$recept_Result_sql['gestion_promos']= $this->gestion_promos->findFirst(array(
			'conditions' => array('id_promo' => $id)
		));
		if (empty($recept_Result_sql['gestion_promos'])) {
			$this->error404('Page Introuvable');
		}
		
		if ($titre != $recept_Result_sql['gestion_promos']->titre) {
			$this->redirect("promo/view/id:$id/titre:".$recept_Result_sql['gestion_promos']->titre);
		}
		$this->set($recept_Result_sql);
		

	}
	
	
	function cgv(){
		
	}

	
	/**
	* Permet d'editer un promo
	*/
	function admin_edit($id = null){
		$this->loadModel('gestion_promos');

		//données recu depuis l'envoi du formulaire via Request
		$tb['id'] = '';
		$recept_data = $this->request->data;
		debug($recept_data);
		if ($recept_data) {
			if ($this->gestion_promos->validates($recept_data)) {
				/*
				*si nous avions un element de type data
				* $this->gestion_promos->data->created = date('y-m-d h:i:s'),
				*/

				//envoi des données au model de auvegarde
				$this->gestion_promos->save($recept_data);
				$this->Session->setFlash('Le contenue a bien été Modifier');

				//si les données on été envoyer on fait un redirectiion
				$this->redirect('admin/gestion_promos/index');
			}else{
				$this->Session->setFlash('Mercie de corriger les info','error');
			}

		}else{
			if ($id) {
				$this->request->data = $this->gestion_promos->findFirst(array(
				'conditions' => array('id_promo' => $id)
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
		$this->loadModel('gestion_promos');
		$conditions = array('id' => 'id_promo',
							);
		$tb['promos'] = $this->gestion_promos->find($conditions);
		$tb['total'] = $this->gestion_promos->findCount($conditions);
		$this->set($tb);
	}

	function admin_delete($id){
		$this->loadModel('gestion_promos');
		$this->gestion_promos->delete($id);
		$this->Session->setFlash('Le contenue a bien été suprime');
		$this->redirect('admin/gestion_promos/index');
	}

}
?>