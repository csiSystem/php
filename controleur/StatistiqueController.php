<?php
/**
* 
*/
class StatistiqueController extends controller
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

	function top_membre_achat_qte($id=null){
		$detail = array();
		$this->loadModel('commande');
		$condition_count = array('fields' => array('id_membre','montant'),
							'id' =>'id_membre');
		$commande = $this->commande->find($condition_count);
		$conditions = array(
				'fields' => array('membre.pseudo'),
			'other_table' =>array('commande', 'membre'),	
			'conditions' => array('commande.id_membre' => 'membre.id_membre')
			);
		$salle = $this->commande->find($conditions);
		//debug($commande);
		
		if (sizeof($commande) > 0) {
			$list_membre= array();
			//liste les membre
			foreach ($commande as $key => $value) {
				$list_membre[] = $value->id_membre;
			}
			//liste membre par nombre de commande
			$list_membre = array_count_values($list_membre);
			debug($list_membre);
			
			$newTB = $this->find_top_five($list_membre);
			debug($newTB);
			if (is_array($newTB)) {
				$tb['membre_qte'] = $newTB;
				//$tb['chiffre_affaire'] = array_sum($tb_membre_montant_commande);
			}else{
				$this->Session->setFlash("Aucun produit ne fait l'objet d'une vente", 'warning');
			}
			/*
			foreach (array_values($list_membre) as $v) {
				
				$tb_tmp = array();
				foreach ($list_membre as $key => $value) {
					if ($v == $value) {
						$tb_tmp[]=$key;
					}
				}
				if (sizeof($tb_tmp) > 0) {
					$tb_not_salle[(string)$v] = $tb_tmp;
				}
			}
			if (sizeof($tb_not_salle) > 0) {
				krsort($tb_not_salle);
				$newTB= array();
				if (sizeof($tb_not_salle) > 5) {
					$i = 0;
					foreach ($tb_not_salle as $key => $value) {
						if (sizeof($newTB) < 5) {
							$newTB[$key] = $value;
						}else{
							break;
						}
					}
				}else{
					$newTB = $tb_not_salle;
				}
				//debug($newTB);
				$tb['membre_qte'] = $newTB;
			}*/

			$tb_membre_n_commande= array();
			$tb_membre_montant_commande= array();
			//debug(array_keys($list_membre));
			foreach (array_keys($list_membre) as $v) {
				foreach ($commande as $key => $value) {
					if ($v == $value->id_membre) {
						if (!in_array($v, array_keys($tb_membre_montant_commande))) {
							$tb_membre_montant_commande[$value->id_membre] =  $value->montant;
						}else{
							//debug($v->id_salle);
							$tb_membre_montant_commande[$value->id_membre] = $tb_membre_montant_commande[$value->id_membre] + $value->montant;
						}
					}
				}
			}
			debug($tb_membre_montant_commande);
			//$chiffre_affaire = array_sum($tb_membre_montant_commande);
			//debug($chiffre_affaire);
			$newTB = $this->find_top_five($tb_membre_montant_commande);
			debug($newTB);
			if (is_array($newTB)) {
				$tb['mieux_vendu'] = $newTB;
				$tb['chiffre_affaire'] = array_sum($tb_membre_montant_commande);
			}else{
				$this->Session->setFlash("Les membre actuel ne font l'objet d'aucun achat", 'warning');
			}
			die();
		}
			
		
	}


	function top_salles_plus_vendue($id=null){

		$detail = array();
		$this->loadModel('produit');
		$condition_count = array('fields' => array('id_produit','id_salle'),
							'id' =>'id_produit');
		$tb['produit'] = $this->produit->find($condition_count);
		$conditions = array(
				'fields' => array('produit.etat','produit.id_produit','produit.date_arrivee','produit.date_depart','produit.prix','salle.id_salle','salle.titre','salle.capacite','salle.photo','salle.ville'),
				'other_table' =>array('produit','salle'),
				'conditions' => array('produit.id_salle' => 'salle.id_salle'),

				);
		$tb['salle'] = $this->produit->find($conditions);
		debug($tb['salle']);
		foreach ($tb['produit'] as $key => $value) {
			$conditions = array(
				'fields' => array('details_commande.id_produit'),
			'other_table' =>array('details_commande'),	
			'conditions' => array('details_commande.id_produit' => $value->id_produit)
			);
			$tb_nbCommande[$value->id_produit] = count((array)$this->produit->find($conditions));
			
		}
		debug($tb['produit']);
		debug($tb_nbCommande);
		
		$tb_salle = array();
		foreach ($tb['produit'] as $k => $v) {
			foreach ($tb_nbCommande as $key => $value) {
				if ($v->id_produit == $key) {
					if (!in_array($v->id_salle, array_keys($tb_salle))) {
						$tb_salle[$v->id_salle] = $value;
					}else{
						//debug($v->id_salle);
						$tb_salle[$v->id_salle] = $tb_salle[$v->id_salle] + $value;
					}
				}
			}
					
		}

		debug($tb_salle);
		$newTB = $this->find_top_five($tb_salle);
		debug($newTB);
		if (is_array($newTB)) {
			$tb['mieux_vendu'] = $newTB;
		}else{
			$this->Session->setFlash("Aucun produit ne fait l'objet d'une vente", 'warning');
		}
		
		//die();

		/*$tb_not_salle = array();
		if (sizeof($tb_salle) > 0) {
			foreach (array_values($tb_salle) as $v) {
				
				$tb_tmp = array();
				foreach ($tb_salle as $key => $value) {
					if ($v == $value) {
						$tb_tmp[]=$key;
					}
				}
				if (sizeof($tb_tmp) > 0) {
					$tb_not_salle[(string)$v] = $tb_tmp;
				}

			}
			if (sizeof($tb_not_salle) > 0) {
				krsort($tb_not_salle);
				$newTB= array();
				if (sizeof($tb_not_salle) > 5) {
					$i = 0;
					foreach ($tb_not_salle as $key => $value) {
						if (sizeof($newTB) < 5) {
							$newTB[$key] = $value;
						}else{
							break;
						}
					}
				}else{
					$newTB = $tb_not_salle;
				}
				debug($newTB);
				$tb['mieux_vendu'] = $newTB;
			}
		}else{
			$this->Session->setFlash("Aucun produit ne fait l'objet d'une vente", 'warning');
		}*/
	}
	

	function top_salles_mieux_note($id=null){

		$detail = array();
		$this->loadModel('salle');
		$condition_count = array('fields' => array('id_salle','ville','titre'),
							'id' => 'id_salle');
		$tb['salle'] = $this->salle->find($condition_count);
		
		foreach ($this->salle->find($condition_count) as $key => $value) {
			$conditions = array(
				'fields' => array('avis.commentaire',
						  'avis.note','avis.date',
						  'avis.id_salle',
						  'avis.id_avis',
						  'avis.id_membre',
						  ),
			'other_table' =>array('avis','salle'),	
			'conditions' => array('salle.id_salle' => 'avis.id_salle',
								'avis.id_salle' => $value->id_salle),
			);
			$tb['avis'] = $this->salle->find($conditions);
			if (sizeof($tb['avis']) != 0) {
				$note_moyen= 0;
				foreach ($tb['avis'] as $key => $v) {
					$note_moyen += $v->note;
				}
				if ($note_moyen != 0) {
					$moyenne =  round($note_moyen / sizeof($tb['avis'])* 2) / 2;
					$tb_moyen[$value->id_salle] = $moyenne;
				}else{
					$tb_moyen[$value->id_salle] = $note_moyen;
				}
				
			}else{
				$this->Session->setFlash("Aucun produit ne fait l'objet d'une notation", 'warning');
			}
		}
		if (isset($tb_moyen)) {
			$tb_moy =array();
			foreach ($tb_moyen as $key => $value) {
				if (!in_array($value, $tb_moy)) {
					$tb_moy[] = $value;
				}
			}
			
			$newTB = $this->find_top_five($tb_moy,$tb_moyen);
			debug($newTB);
			$tb['mieux_note'] = $newTB;
			/*$tb_not_salle = array();
			
			if (sizeof($tb_moy) > 0) {
				foreach ($tb_moy as $v) {
					
					$tb_tmp = array();
					foreach ($tb_moyen as $key => $value) {

						if ($v == $value) {
							$tb_tmp[]=$key;
						}
					}
					if (sizeof($tb_tmp) > 0) {
						//debug($v);
						$tb_not_salle[(string)$v] = $tb_tmp;
						$tb_tmp = array();
					}

				}
				if (sizeof($tb_not_salle) > 0) {
					krsort($tb_not_salle);
					$newTB= array();
					if (sizeof($tb_not_salle) > 5) {
						$i = 0;
						foreach ($tb_not_salle as $key => $value) {
							if (sizeof($newTB) < 5) {
								$newTB[$key] = $value;
							}else{
								break;
							}
						}
					}else{
						$newTB = $tb_not_salle;
					}
					//debug($newTB);
					$tb['mieux_note'] = $newTB;
				}
			}*/
					
		}	

	}

	function find_top_five($tb_moy = array(), $tb_moyen = null){
		$tb_not_salle = array();
		if ( is_null($tb_moyen) ) {
			$tb_moyen =  $tb_moy;
		}
		if (sizeof($tb_moy) > 0) {
			foreach ($tb_moy as $v) {
				$tb_tmp = array();
				foreach ($tb_moyen as $key => $value) {
					if ($v == $value) {
						$tb_tmp[]=$key;
					}
				}
				if (sizeof($tb_tmp) > 0) {
					//debug($v);
					$tb_not_salle[(string)$v] = $tb_tmp;
					$tb_tmp = array();
				}
			}
			if (sizeof($tb_not_salle) > 0) {
				krsort($tb_not_salle);
				$newTB= array();
				if (sizeof($tb_not_salle) > 5) {
					$i = 0;
					foreach ($tb_not_salle as $key => $value) {
						if (sizeof($newTB) < 5) {
							$newTB[$key] = $value;
						}else{
							break;
						}
					}
				}else{
					$newTB = $tb_not_salle;
				}
				//debug($newTB);
				return $newTB;
			}else{
				return false;
			}
		}else{
			return false;
		}
			
	}
	

}
?>