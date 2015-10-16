<?php
/**
* 
*/
class Session
{
	
	public function __construct()
	{
		if (!isset($_SESSION)) {
			session_start();
			$_SESSION['lang'] = 'fr';
		}
		
	}
	/*
	* metre un message en session 
	**/
	public function setFlash($message, $type='succes'){
		$_SESSION['flash'] = array(
			'message' => $message,
			'type' => $type
		);
	}
	/*
	* Affiche un message en session 
	**/
	public function flash(){
		if (isset($_SESSION['flash']['message'])) {
			$url = BASE_URL.'/webracine/images/ok-icon.png';
			if (isset($_SESSION['flash']['type'])) {
				if ($_SESSION['flash']['type'] == 'erreur') {
					$url = BASE_URL.'/webracine/images/error-icon.png';
				}
				if ($_SESSION['flash']['type'] == 'warning') {
					$url = BASE_URL.'/webracine/images/warning-icon.png';
				}
			}
			$img =  '<img src="'.$url.'" alt=""/>'; 
			$msgSession =  '<div class="alerte-message '.$_SESSION['flash']['type'].'"><p>'.$img.''.$_SESSION['flash']['message'].'</p></div>';
			$_SESSION['flash'] = array();
			return $msgSession;
		}

	}
	

	public function  write($key,$value){
		$_SESSION[$key]=$value;
	}



	public function  read($key = null,$value = null){
		if ($key) {
			if (isset($_SESSION[$key])) {
				if (isset($_SESSION[$key]->$value)){
					return $_SESSION[$key]->$value;	
				}else{
					return $_SESSION[$key];	
				}
				
			}else{
				return false;
			}
			
		}else{
			return $_SESSION;
		}
	}
	public function isLogged(){
		return isset($_SESSION['User']->statut);
	}
	public function user($key){
		if ($this->read('User')){
			if (isset($this->read('User')->$key)) {
				return $this->read('User')->$key;
			}else{
				return false;
			}
		}
		return false;
	}
	/* ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ */
	/*                Fonctions de base de gestion du panier                   */
	/* ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ */

	/**
	* Ajoute un article dans le panier après vérification que nous ne somme pas en phase de paiement
	*
	* @param array  $select variable tableau associatif contenant les valeurs de l'article
	* @return Mixed Retourne VRAI si l'ajout est effectué, FAUX sinon voire une autre valeur si l'ajout
	*               est renvoyé vers la modification de quantité.
	* @see {@link modif_qte()}
	*/
	public function ajout_panier($select)
	{
	    $ajout = false;
	       
	    if(!isset($_SESSION['panier']['verrouille']) || $_SESSION['panier']['verrouille'] == false)
	    {
	        
            $_SESSION['panier'][$select['id_produit']]=$select;
            /*$_SESSION['panier']['date_depart']=$select['date_depart'];
            $_SESSION['panier']['date_arrivee']=$select['date_arrivee'];
            $_SESSION['panier']['id_salle']=$select['id_salle'];
            $_SESSION['panier']['prix']=$select['prix'];
            $_SESSION['panier']['id_promo']=$select['id_promo'];
            $_SESSION['panier']['etat']=$select['etat'];*/
            $ajout = true;
	        
	       
	    }
	    return $ajout;
	}

	public function modif_prix($ref_article, $codepromo,$reduction)
	{
	    /* On initialise la variable de retour */
	    $modifie = false;
	    if(!isset($_SESSION['panier']['verrouille']) || $_SESSION['panier']['verrouille'] == false)
	    {
	        if($this->verif_panier($ref_article) != false)
	        {
	            /* On compte le nombre d'articles différents dans le panier */
	            $nb_articles = count($_SESSION['panier']['id_produit']);
	            /* On parcoure le tableau de session pour modifier l'article précis. */
	            for($i = 0; $i < $nb_articles; $i++)
	            {
	                if($ref_article == $_SESSION['panier']['id_produit'][$i] && $ref_article == $_SESSION['panier']['id_promo'][$i])
	                {
	                    $_SESSION['panier']['prix'][$i] = $_SESSION['panier']['prix'][$i] - $reduction;
	                    $modifie = true;
	                }
	            }
	        }
	        else
	        {
	            $modifie = "artitile non present dans le panier";
	        }
	            
	       
	    }
	    return $modifie;
	}

	
	public function supprim_article($ref_article)
	{
	    $suppression = false;
	    if(!isset($_SESSION['panier']['verrouille']) || $_SESSION['panier']['verrouille'] == false)
	    {
	        /* On vérifie que l'article à supprimer est bien présent dans le panier */
	        if($this->verif_panier($ref_article) != false)
	        {
	            /* création d'un tableau temporaire de stockage des articles */
	            $panier_tmp = array("id_produit"=>array(),
	            					"date_depart"=>array(),
	            					"date_arrivee"=>array(),
	            					"id_salle"=>array(),
	            					"prix"=>array(),
	            					"id_promo"=>array(),
	            					"etat"=>array());
	            /* Comptage des articles du panier */
	            $nb_articles = count($_SESSION['panier']['id_produit']);
	            /* Transfert du panier dans le panier temporaire */
	            for($i = 0; $i < $nb_articles; $i++)
	            {
	                /* On transfère tout sauf l'article à supprimer */
	                if($_SESSION['panier']['id_produit'][$i] != $ref_article)
	                {
	                    array_push($_SESSION['panier']['id_produit'],$select['id_produit']);
			            array_push($_SESSION['panier']['date_depart'],$select['date_depart']);
			            array_push($_SESSION['panier']['date_arrivee'],$select['date_arrivee']);
			            array_push($_SESSION['panier']['id_salle'],$select['id_salle']);
			            array_push($_SESSION['panier']['prix'],$select['prix']);
			            array_push($_SESSION['panier']['id_promo'],$select['id_promo']);
			            array_push($_SESSION['panier']['etat'],$select['etat']);
			            $ajout = true;
	                }
	            }
	            /* Le transfert est terminé, on ré-initialise le panier */
	            $_SESSION['panier'] = $panier_tmp;
	            /* Option : on peut maintenant supprimer notre panier temporaire: */
	            unset($panier_tmp);
	            $suppression = true;
	        }
	        else
	        {
	            $suppression == "absent";
	        }
	    }
	    return $suppression;
	}

	/**
	* Supprimer un article du panier : autre méthode.
	*
	* @param String     $ref_article numéro de référence de l'article à supprimer
	* @param Boolean    $reindex : facultatif, par défaut, vaut true pour ré-indexer le tableau après
	*                   suppression. On peut envoyer false si cette ré-indexation n'est pas nécessaire.
	* @return Mixed     Retourne TRUE si la suppression a bien été effectuée,
	*                   FALSE sinon, "absent" si l'article était déjà retiré du panier
	*/
	public function supprim_article2($ref_article, $reindex = true)
	{
	    $suppression = false;
	    if(!isset($_SESSION['panier']['verrouille']) || $_SESSION['panier']['verrouille'] == false)
	    {
	         /* sortie la clé a été trouvée */
	        if ($this->verif_panier($ref_article) != false)
	        {
	            /* on traverse le panier pour supprimer ce qui doit l'être */
	            foreach ($_SESSION['panier'] as $k=>$v)
	            {
	                if($k == $ref_article )
	                {
	                    unset($_SESSION['panier'][$k]);    // remplace la ligne foireuse
	                    $suppression = true;
	                }
	                /* Réindexation des clés du panier si l'option $reindex a été laissée à true */
	                
	            }
	        }
	        else
	        {
	            $suppression = "absent";
	        }
	    }
	    return $suppression;
	}

	/**
	* Fonction qui supprime tout le contenu du panier en détruisant la variable après
	* vérification qu'on ne soit pas en phase de paiement.
	*
	* @return Mixed    Retourne VRAI si l'exécution s'est correctement déroulée, Faux sinon et "inexistant" si
	*                  le panier avait déjà été détruit ou n'avait jamais été créé.
	*/
	public  function vider_panier()
	{
	    $vide = false;
	    if(!isset($_SESSION['panier']['verrouille']) || $_SESSION['panier']['verrouille'] == false)
	    {
	        if(isset($_SESSION['panier']))
	        {
	            unset($_SESSION['panier']);
	            if(!isset($_SESSION['panier']))
	            {
	                $vide = true;
	            }
	        }
	        else
	        {
	            /* Le panier était déjà détruit, on renvoie une autre valeur exploitable au retour */
	            $vide = "inexistant";
	        }
	    }
	    return $vide;
	}

	/**
	* Calcule le montant total du panier
	*
	* @return Double
	*/
	public function montant_panier()
	{
	    /* On initialise le montant */
	    $montant = 0;
	    /* Comptage des articles du panier */
	    //$nb_articles = count($_SESSION['panier']);
	    /* On va calculer le total par article */
	   
	    foreach ($_SESSION['panier'] as $key => $value) {
	    	//debug($value);die();
	    	$montant += $value['prix'] + $value['prix']*0.196;
	    	
	    }
	    /*for($i = 0; $i < $nb_articles; $i++)
	    {
	        $montant +=  $_SESSION['panier']['prix'][$i];
	    }
	    On retourne le résultat */
	    return $montant;
	}

	/**
	* Vérifie la présence d'un article dans le panier
	*
	* @param String $ref_article référence de l'article à vérifier
	* @return Boolean Renvoie Vrai si l'article est trouvé dans le panier, Faux sinon
	*/
	public function verif_panier($ref_article)
	{
	    /* On initialise la variable de retour */
	    $present = false;
	    /* On vérifie les numéros de références des articles et on compare avec l'article à vérifier */
	    if ($this->read('panier')) {
	    	if(array_search($ref_article,array_keys($this->read('panier'))) !== false)
		    {
		        $present = true;
		    }	# code...
	    
	    }
	    
	    return $present;
	}

	/**
	* Fonction de verrouillage du panier pendant la phase de paiement.
	*
	*/
	public function preparerPaiement()
	{
	    $_SESSION['panier']['verrouille'] = true;
	    header("Location: NOTRE BANQUE");
	}

	/**
	* Fonction qui va enregistrer les informations de la commande dans
	* la base de données et détruire le panier.
	*
	*/
	public function paiementAccepte()
	{
	    /* ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ */
	    /*   Stockage du panier dans la BDD   */
	    /* ajoutez ici votre code d'insertion */
	    /* ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ */
	    unset($_SESSION['panier']);
	}
}
?>