<?php
/**
* 
*/
class PagesController extends controller
{
	/*
	function view($nom)
	{
		$this->set(array(
			'phrase' => 'Bienvenue sur la pages '.$nom,
			'nom'	 =>	'Machin'));
		$this->render('index');
	}*/
	function view($id){
		$this->loadModel('membre');
		echo "mon id : ".$id;
		$membres = $this->membre->findFirst(array(
			'conditions' => array('id_membre' => $id)));
		//echo "RESULTAT".$membres;
		if (empty($membres)) {
			$this->erreur404('Page Introuvable');
		}
		$this->set('membre',$membres);

	}
}
?>