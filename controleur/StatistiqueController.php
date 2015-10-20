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
	function top_salles_plus_vendue($id=null){

		$detail = array();
		$this->loadModel('produit');
		$condition_count = array('fields' => array('id_produit','id_salle'),
							'conditions' => array('id_produit' =>'id'));
		$tb['produit'] = $this->produit->find($condition_count);
		
		foreach ($tb['produit'] as $key => $value) {
			$conditions = array(
				'fields' => array('details_commande.id_produit'),
			'other_table' =>array('details_commande'),	
			'conditions' => array('details_commande.id_produit' => $value->id_produit)
			);
			$tb_nbCommande[$value->id_produit] = count((array)$this->salle->find($conditions));
			
		}
		$tb_salle = array();
		foreach ($tb['produit'] as $k => $v) {
			foreach ($tb_nbCommande as $key => $value) {
				if ($v == $key) {
					if (!in_array($v->id_salle, $tb_salle)) {
						$tb_salle[$v->id_salle] = $value;
					}else{
						$tb_salle[$v->id_salle] += $value;
					}
				}
			}
					
		}

		debug($tb_salle);
		die();
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
				$this->Session->setFlash("Aucun de produit de fait l'objet d'une notation", 'warning');
			}
		}
		if (isset($tb_moyen)) {
			$tb_moy =array();
			foreach ($tb_moyen as $key => $value) {
				if (!in_array($value, $tb_moy)) {
					$tb_moy[] = $value;
				}
			}
			$tb_not_salle = array();
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
			}
					
		}	

	}

}
?>