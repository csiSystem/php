 <link href="<?php echo BASE_URL.'/webracine/styles/jquery.circliful.css';?>" rel="stylesheet" type="text/css" />
        <link href="<?php echo BASE_URL.'/webracine/styles/font-awesome.min.css';?>" rel="stylesheet" type="text/css" />

        <script src="http://code.jquery.com/jquery-1.10.2.min.js"></script>
        <script src="<?php echo BASE_URL.'/webracine/js/jquery.circliful.min.js';?>"></script>
<?php
/**
*CHARGEMENNT DES VENTES
*/

$tb_color = array("#272016","#5B370B","#905710","#A98554","#D5C3AB");
//debug($salle);
//debug($total_commande);

$ca_html = '<div class="titre">
	<p>LES MEMEBRES QUI ACHETE LE PLUS (QUANTITE)</p></div>';
if (isset($achat)) {
	$i=0;
	foreach ($achat as $key => $value) {
		$i += 1;
		$vente = "vente".$i;
		$k= $i-1;
		$fgcolor = $tb_color[$k];
		$text = "du CA";
		$percent =round(($key/$chiffre_affaire) *100,2);
		
		$ca_html .= '<div class="stat">
		    <div  
		    	id="'.$vente.'"
			    data-dimension="240" 
			    data-text="'.$percent.'%" 
			    data-info="'.$text.'"
			    data-width="30" 
			    data-fontsize="25" 
			    data-percent="'.$percent.'" 
			    data-fgcolor="'.$fgcolor.'" 
			    data-bgcolor="#eee" 
			    data-fill="#ddd">
			    
			</div>';
			$ca_html .='<div class="statlink1"><ul class="statlink">';				
			foreach ($value as $v) {
				if (isset($membre[$v])) {
					$url = Router::url("Membre/".$membre[$v].'-'.$v);
					//debug($url);
					$ca_html .='<li><a href="'.$url.'" title="'.$membre[$v].'"><span>'.$membre[$v].'  ca:'.$key.'</span></a></li>';
				}else{
					$ca_html .='<li><a href="#"><span>Membre:'.$v.' ca:'.$percent.'</span></a></li>';
				}
				
			}
			$ca_html .='</ul></div>';
			
		$ca_html .='</div>';
	}
}else{
	$ca_html.="<h2>Aucun produit ne fait l'object de vente</h2>";
}

$qte_html = '<div class="titre">
	<p>LES MEMEBRES QUI ACHETE LE PLUS (QUANTITE)</p></div>';
if (isset($membre_qte)) {
	$i=0;
	foreach ($membre_qte as $key => $value) {
		$i += 1;
		$vente = "vente".$i;
		$k= $i-1;
		$fgcolor = $tb_color[$k];
		$text = "des Commandes";
		$percent =round(($key/$total_commande) *100); 
		$qte_html .= '<div class="stat">
		    <div  
		    	id="'.$vente.'"
			    data-dimension="240" 
			    data-text="'.$percent.'%" 
			    data-info="'.$text.'"
			    data-width="30" 
			    data-fontsize="25" 
			    data-percent="'.$percent.'" 
			    data-fgcolor="'.$fgcolor.'" 
			    data-bgcolor="#eee" 
			    data-fill="#ddd">
			    
			</div>';
			$qte_html .='<div class="statlink1"><ul class="statlink">';				
			foreach ($value as $v) {
				if (isset($membre[$v])) {
					$url = Router::url("Membre/".$membre[$v].'-'.$v);
					//debug($url);
					$qte_html .='<li><a href="'.$url.'" title="'.$membre[$v].'"><span>'.$membre[$v].'</span></a></li>';
				}else{
					$qte_html .='<li><a href="#"><span>Membre:'.$v.'</span></a></li>';
				}
				
			}
			$qte_html .='</ul></div>';
			
		$qte_html .='</div>';
	}
}else{
	$qte_html.="<h2>Aucun produit ne fait l'object de vente</h2>";
}


$note_html = '<div class="titre">
	<p>LES SALLES LES PLUS VENDUES</p></div>';
if (isset($mieux_note)) {
	$i=0;
	foreach ($mieux_note as $key => $value) {
		$i += 1;
		$vente = "vente".$i;
		$k= $i-1;
		$fgcolor = $tb_color[$k];
		$text = "de Moyenne";
		$percent =round(($key/10) *100); 
		$note_html .= '<div class="stat">
		    <div  
		    	id="'.$vente.'"
			    data-dimension="240" 
			    data-text="'.$percent.'%" 
			    data-info="'.$text.'"
			    data-width="30" 
			    data-fontsize="25" 
			    data-percent="'.$percent.'" 
			    data-fgcolor="'.$fgcolor.'" 
			    data-bgcolor="#eee" 
			    data-fill="#ddd">
			    
			</div>';
			$note_html .='<div class="statlink1"><ul class="statlink">';				
			foreach ($value as $v) {
				$url = Router::url('admin/salle/view/'.$v);
				//debug($url);
				$note_html .='<li><a href="'.$url.'" title="'.$salle[$v]['titre'].'"><span>'.$salle[$v]['titre'].' '.$salle[$v]['ville'].'</span></a></li>';
			}
			$note_html .='</ul></div>';
			
		$note_html .='</div>';
	}
}else{
	$note_html.="<h2>Aucun produit ne fait l'object de vente</h2>";
}
$vente_html = '<div class="titre">
	<p>LES SALLES LES PLUS VENDUES</p></div>';
if (isset($mieux_vendu)) {
	$i=0;
	foreach ($mieux_vendu as $key => $value) {
		$i += 1;
		$vente = "vente".$i;
		$k= $i-1;
		$fgcolor = $tb_color[$k];
		$text = "des Ventes";
		$percent =round(($key/$total_vendu) *100); 
		$vente_html .= '<div class="stat">
		    <div  
		    	id="'.$vente.'"
			    data-dimension="240" 
			    data-text="'.$percent.'%" 
			    data-info="'.$text.'"
			    data-width="30" 
			    data-fontsize="25" 
			    data-percent="'.$percent.'" 
			    data-fgcolor="'.$fgcolor.'" 
			    data-bgcolor="#eee" 
			    data-fill="#ddd">
			    
			</div>';
			$vente_html .='<div class="statlink1"><ul class="statlink">';				
			foreach ($value as $v) {
				$url = Router::url('admin/salle/view/'.$v);
				//debug($url);
				$vente_html .='<li><a href="'.$url.'" title="'.$salle[$v]['titre'].'"><span>'.$salle[$v]['titre'].' '.$salle[$v]['ville'].'</span></a></li>';
			}
			$vente_html .='</ul></div>';
			
		$vente_html .='</div>';
	}
}else{
	$vente_html.="<h2>Aucun produit ne fait l'object de vente</h2>";
}

?>
<div class="register_account">
  	<div class="wrap">
  	<div class="content-bottom">
  	<div>
		<div class="statlink1">
			<ul class="statlink">			
				<li><a href="<?php echo Router::url("admin/statistique/info/note") ?>"><span>To des salles les plus Notées</span></a></li>
				<li><a href="<?php echo Router::url("admin/statistique/info/vente") ?>"><span>Top des salles les plus Vendues</span></a></li>
				<li><a href="<?php echo Router::url("admin/statistique/info/achat") ?>"><span>Top des membres qui achate les plus (en termes quantité)</span></a></li>
				<li><a href="<?php echo Router::url("admin/statistique/info/ca") ?>"><span>Top des membres qui achate le plus cher (en termes de prix)</span></a></li>

			</ul>
		</div>
			
	</div>
	 <div class="clear"></div> 
  	
	<?php
		if (isset($mieux_note)) {
			echo $note_html;
		}
		if (isset($membre_qte)) {
			echo $qte_html;
		}
		if (isset($mieux_vendu)) {
			echo $vente_html;
		}
		if (isset($achat)) {
			echo $ca_html;
		}
	?>
	
    
	 
  </div>
  <div class="clear"></div> 
  </div> 
</div>



<script>
$( document ).ready(function() {
   	$('#vente1').circliful();
   	$('#vente2').circliful();
   	$('#vente3').circliful();
   	$('#vente4').circliful(); 
    $('#vente5').circliful();
    });
</script>