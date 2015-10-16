<?php
/**
* 
*/

function debug($var){
	if (Conf::$debug>0) {
		$debug = debug_backtrace();
		echo '<p>&nbsp;</p><p><a href="#" onclick="$(this).parent().next(\'ol\').slideToggle(); return false;"><strong>'.$debug[0]['file'].'</strong> l.'.$debug[0]['line'].'</a></p>';
		//print_r(debug_backtrace());
		echo '<ol style="display:none">';
		foreach ($debug as $key => $value) {
			if ($key > 0) {
				echo '<li><strong>'.$value['file'].'</strong> l.'.$value['line'].'</li>';	
			}
		}
		echo "</ol>";
		echo "<pre>";
		print_r($var);
		echo "</pre>";
		}
		//recupe du tableau de tous les fichier ayant appelé notre fonction	
}	

function translate_lang($mot){
	$tb_language['mention'] = array('fr'=>'Mention légale',	'it'=>'',	'en'=>'');
	$tb_language['plan'] = array('fr'=>'le plan du site',	'it'=>'',	'en'=>'');
	$tb_language['cgv'] = array('fr'=>'Condition légal de vente',	'it'=>'',	'en'=>'');
	$tb_language['printpage'] = array('fr'=>'Imprimer la page',	'it'=>'',	'en'=>'');
	$tb_language['inscritletter'] = array('fr'=>'S\'inscrire à la newsletter',	'it'=>'',	'en'=>'');
	$tb_language['contact'] = array('fr'=>'Contact',	'it'=>'',	'en'=>'');
	

	$tb_language['gestion']   = 'Administation';
	$tb_language['avis_index']   = 'Voir liste des avis';
	$tb_language['salle_edit']   = 'Ajouter une salle';
	$tb_language['salle_index']   = 'Affichage des salles';
	$tb_language['produit_edit']  = 'Ajouter un produit';
	$tb_language['produit_index'] = 'Affichage des produits';
	$tb_language['membre_edit']   = 'Ajouter un membre';
	$tb_language['membre_index']  = 'Affichage des membres';
	$tb_language['commande_index']= 'Affichage des commandes';
	$tb_language['produit_index'] = 'Affichage des produits';
	$tb_language['promo_edit'] = 'Ajouter une promotion';
	$tb_language['promo_index'] = 'Affichage des promotions';
	$tb_language['statistique'] = 'Statistique';
	$tb_language['stat_salle_vendu'] = 'Top 5 des salles les plus vendu';
	$tb_language['stat_salle_note'] = 'Top 5 des salles mieux notés';
	$tb_language['stat_membre_achat'] = 'Top 5 des des memebres qui achète le plus (en termes de quantités) ';
	$tb_language['stat_membre_achat_cher'] = 'Top 5 des des memebres qui achète le plus cher (en termes de prix) ';

	$tb_language['acceuil']		= 'Acceuil';
	$tb_language['reserver']	= 'Réservation';
	$tb_language['seconnecter']	= 'Se connecter';
	$tb_language['compte']		= 'Créer votre compte';
	$tb_language['deconnecter']	= 'Se déconnecter';
	$tb_language['profil']		= 'Voir votre profil';
	$tb_language['panier']		= 'Voir votre panier';
	$tb_language['recherche']	= 'Recherche';
	$tb_language['salle']		= 'Gestion des salles';
	$tb_language['produit']		= 'Gestion des produits';
	$tb_language['membre']		= 'Gestion des membres';
	$tb_language['commande']    = 'Gestion des commandes';
	$tb_language['avis']        = 'Gestion des avis';
	$tb_language['promo']       = 'Gestion des codes promos';
	$tb_language['statistiques']= 'Statistiques';
	$tb_language['envoisletter']= 'Envoyer la newsletter';
	/*
	array('fr'=>'Mention légale',
		'it'=>'',
		'en'=>'');
	*/

	if (isset($tb_language[$mot])) {
		return $tb_language[$mot][$_SESSION['lang']];
	}else{
		return $mot;
	}
}

/*
classe 
	input
	clearfix
	
*/
?>