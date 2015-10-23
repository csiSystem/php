<script type="text/javascript" src="<?php echo BASE_URL.'/webracine/js/megamenu.js';?>"></script>
<script>
    $(document).ready(function(){$(".megamenu").megamenu();});
</script>
<?php 
$tb_menu['acceuil'] = 'index';	
$tb_menu['reserver'] = 'reservation';
$tb_menu['recherche'] = 'recherche';

if($this->Session->isLogged()){
	$urlimg = BASE_URL."/webracine/images/user-ico.png";
	if ($this->Session->read('User')->statut == 1) {
		$tb_menu['gestion'] = 'gestion';
		$urlimg = BASE_URL."/webracine/images/admin-user.png";
	}
	$tb_menu['deconnecter']='logout';
	$tb_menu['profil'] = 'profil';
	$tb_menu['panier'] = 'panier';
	$html1 = '<div class="header-middle">
    <div class="wrap">
        <div class="section group">
            <div class="col_1_of_5 span_1_of_5">
                <h3 class="m_9"></h3>
            </div>
            <div class="col_1_of_5 span_1_of_5">
                <h3 class="m_9"></h3>
            </div>
            <div class="col_1_of_5 span_1_of_5">
                <h3 class="m_9">'.$this->Session->flash().'</h3>
            </div>
            <div class="col_1_of_5 span_1_of_5">
                <h3 class="m_9"></h3>
            </div>
            <div class="col_1_of_5 span_1_of_5">
                
                <img src="'.$urlimg.'" alt=""/>
                <p>Bonjour :'.$this->Session->user('pseudo').'</p>
            </div>
            <div class="clear"></div>
    
        </div>
    </div>
    </div>';

}else{
	
	$tb_menu['seconnecter'] = 'login';
	$tb_menu['compte'] = 'inscription';
}


$men_gestion['salles']      = array('salle_edit'=>'edit','salle_index'=>'index');
$men_gestion['produit']     = array('produit_edit'=>'edit','produit_index'=>'index');
$men_gestion['membre']      = array('membre_edit'=>'edit','membre_index'=>'index');
$men_gestion['commande']    = array('commande_index'=>'index');
$men_gestion['avis']        = array('avis_index'=>'index');
$men_gestion['promo']       = array('promo_edit'=>'edit','promo_index'=>'index');
$men_gestion['statistique'] = array('stat_index','index');
$men_gestion['newsletter']  = array('newletter_index','index');
				
$tb_language=array();
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
$tb_language['salle']		= 'Gestion salles';
$tb_language['produit']		= 'Gestion produits';
$tb_language['membre']		= 'Gestion membres';
$tb_language['commande']    = 'Gestion commandes';
$tb_language['avis']        = 'Gestion avis';
$tb_language['promo']       = 'Gestion codes promos';
$tb_language['statistiques']= 'Statistiques';
$tb_language['envoisletter']= 'Envoyer newsletter';
$html='';
//echo '<li><a class="color1" href="'.Router::url("Membre/".$tb_menu[$key]).'">'.$tb_language[$key].'</a></li>';
$html .= '<li><a class="color1" href="#">'.$tb_language['gestion'].'</a>
				<div class="megapanel">
					<div class="row">
						<div class="col1">
							<div class="h_nav">';
								$html .='<h4>'.$tb_language['salle'].'</h4>
								<ul>';
									$html .='<li><a href="'.Router::url('admin/salle/index').'">'.$tb_language['salle_index'].'</a></li>
									<li><a href="'.Router::url('admin/salle/edit').'">'.$tb_language['salle_edit'].'</a></li>
								</ul>
								
							</div>
							<div class="h_nav">
								<h4>'.$tb_language['commande'].'</h4>
								<ul>
									<li><a href="'.Router::url('admin/commande/index').'">'.$tb_language['commande_index'].'</a></li>
									
								</ul>
							</div>
						</div>
						<div class="col1">
							<div class="h_nav">
								<h4>'.$tb_language['produit'].'</h4>
								<ul>
									<li><a href="'.Router::url('admin/produit/index').'">'.$tb_language['produit_index'].'</a></li>
									<li><a href="'.Router::url('admin/produit/edit').'">'.$tb_language['produit_edit'].'</a></li>
								</ul>	
							</div>
							<div class="h_nav">	
								<h4>'.$tb_language['avis'].'</h4>
								<ul>
									<li><a href="'.Router::url('admin/avis/index').'">'.$tb_language['avis_index'].'</a></li>
								</ul>
							</div>
						</div>
						<div class="col1">
							<div class="h_nav">
								<h4>'.$tb_language['membre'].'</h4>
								<ul>
									<li><a href="'.Router::url('admin/membre/users').'">'.$tb_language['membre_index'].'</a></li>
									<li><a href="'.Router::url('admin/membre/edit').'">'.$tb_language['membre_edit'].'</a></li>
								</ul>	
							</div>
							<div class="h_nav">
								<h4>'.$tb_language['statistique'].'</h4>
								<ul>
									<li><a href="'.Router::url('admin/statistique/info').'">'.$tb_language['statistique'].'</a></li>
								</ul>
							</div>
						</div>
						<div class="col1">
							<div class="h_nav">
							<h4>'.$tb_language['promo'].'</h4>
								<ul>
									<li><a href="'.Router::url('admin/gestion_promos/index').'">'.$tb_language['promo_index'].'</a></li>
									<li><a href="'.Router::url('admin/gestion_promos/edit').'">'.$tb_language['promo_edit'].'</a></li>
								</ul>	
							</div>
							<div class="h_nav">
								<h4>'.$tb_language['envoisletter'].'</h4>
								<ul>
									<li><a href="'.Router::url('admin/newsletter/send').'">'.$tb_language['envoisletter'].'</a></li>
								</ul>	
							</div>	
						</div>
						
						
						<img src="'.BASE_URL."/webracine/images/admin-icon.png".'" alt=""/>
					</div>
				</div>
				</li>';

?>

<div class="header-logo">
	 <div class="wrap"> 
		<div class="logo">
			<a href="<?php echo BASE_URL."";?>"><img src="<?php echo BASE_URL."/webracine/images/logo1.png";?>" alt=""/></a>
			
		</div>
	    
		
		<div class="clear"></div>
 	</div>
</div>
<div class="header-menu">
   	<div class="wrap">
   		<!-- start header menu -->
		<ul class="megamenu skyblue">
		    <?php
		    if($this->Session->isLogged()){
		    	$link = isset($tb_menu['gestion']) ? Router::url("admin/membre/".$tb_menu['acceuil']) : Router::url("Membre/".$tb_menu['acceuil']);
		    	echo '<li><a class="color1" href="'.$link.'">'.$tb_language['acceuil'].'</a></li>';
		    }else{
		    	echo '<li><a class="color1" href="'.Router::url("Visiteur/".$tb_menu['acceuil']).'">'.$tb_language['acceuil'].'</a></li>';
		    }
		    echo '<li><a class="color1" href="'.Router::url("Visiteur/".$tb_menu['reserver']).'">'.$tb_language['reserver'].'</a></li>';
		    echo '<li><a class="color1" href="'.Router::url("Visiteur/".$tb_menu['recherche']).'">'.$tb_language['recherche'].'</a></li>';
		   if($this->Session->isLogged()){
		    	/*echo '<li><a class="color1" href="'.$link.'">'.$tb_language['acceuil'].'</a></li>';
		    	echo '<li><a class="color1" href="'.Router::url("Membre/".$tb_menu['reserver']).'">'.$tb_language['reserver'].'</a></li>';
		    	echo '<li><a class="color1" href="'.Router::url("Membre/".$tb_menu['recherche']).'">'.$tb_language['recherche'].'</a></li>';*/
		    	echo '<li><a class="color1" href="'.Router::url("connection/".$tb_menu['deconnecter']).'">'.$tb_language['deconnecter'].'</a></li>';		    	
		    	echo '<li><a class="color1" href="'.Router::url("Membre/".$this->Session->user('pseudo').'-'.$this->Session->user('id_membre')).'">'.$tb_language['profil'].'</a></li>';
		    	echo '<li><a class="color1" href="'.Router::url("Membre/".$tb_menu['panier']).'">'.$tb_language['panier'].'</a></li>';
		    	if (isset($tb_menu['gestion'])) {
		    		echo $html;
		    	}
			
		    }else{
		    	echo '<li><a class="color1" href="'.Router::url("Visiteur/".$tb_menu['seconnecter']).'">'.$tb_language['seconnecter'].'</a></li>';		    
		    	echo '<li><a class="color1" href="'.Router::url("Visiteur/".$tb_menu['compte']).'">'.$tb_language['compte'].'</a></li>';
		    
		    }
		    /*
		    foreach ($tb_menu as $key => $value){
		    	
		    	if($this->Session->isLogged()){
					if (isset($tb_menu['gestion'])) {
					    	echo $html;
					}
		    		if ($key == 'deconnecter' || $key=='profil' || $key =='panier') {
		    			if($key=='profil'){
		    				echo '<li><a class="color1" href="'.Router::url("Membre/".$this->Session->user('pseudo').'-'.$this->Session->user('id_membre')).'">'.$tb_language[$key].'</a></li>';
		    			}
		    			if ($key=='deconnecter') {
		    					echo '<li><a class="color1" href="'.Router::url("connection/".$tb_menu[$key]).'">'.$tb_language[$key].'</a></li>';
		    				}
		    			if ($key =='panier') {
		    				echo '<li><a class="color1" href="'.Router::url("Membre/".$tb_menu[$key]).'">'.$tb_language[$key].'</a></li>';
		    			}
		    			
		    		}else{
		    			echo '<li><a class="color1" href="'.Router::url("Visiteur/".$tb_menu[$key]).'">'.$tb_language[$key].'</a></li>';
		    		}
		    	}else{
		    		echo '<li><a class="color1" href="'.Router::url("Visiteur/".$tb_menu[$key]).'">'.$tb_language[$key].'</a></li>';
		    	}
		    }
		    if (isset($tb_menu['gestion'])) {
		    	echo $html;
		    }*/
		    ?>
	   </ul>
	   <div class="clear"></div>
   	</div>
</div>
<?php 
	if ($this->Session->isLogged()) {
		echo $html1;
	}else{
		echo $this->Session->flash();
	}
?>

