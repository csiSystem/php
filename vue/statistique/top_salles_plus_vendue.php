 <link href="<?php echo BASE_URL.'/webracine/styles/jquery.circliful.css';?>" rel="stylesheet" type="text/css" />
        <link href="<?php echo BASE_URL.'/webracine/styles/font-awesome.min.css';?>" rel="stylesheet" type="text/css" />

        <script src="http://code.jquery.com/jquery-1.10.2.min.js"></script>
        <script src="<?php echo BASE_URL.'/webracine/js/jquery.circliful.min.js';?>"></script>
<?php
/**
*CHARGEMENNT DES VENTES
*/

$tb_color = array("#272016","#5B370B","#905710","#A98554","#D5C3AB");
debug($salle);
debug($mieux_vendu);
debug($total_vendu);

$vente_html = '';

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
				debug($url);
				$vente_html .='<li><a href="'.$url.'" title="'.$salle[$v]['titre'].'"><span>'.$salle[$v]['titre'].' '.$salle[$v]['ville'].'</span></a></li>';
			}
			$vente_html .='</ul></div>';
			
		$vente_html .='</div>';
	}
}else{
	$vente_html="<h2>Aucun produit ne fait l'object de vente</h2>";
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
				<li><a href="<?php echo Router::url("admin/statistique/info/note") ?>"><span>Top des membres qui achate les plus (en termes quantité)</span></a></li>
				<li><a href="<?php echo Router::url("admin/statistique/info/ca") ?>"><span>Top des membres qui achate le plus cher (en termes de prix)</span></a></li>

			</ul>
		</div>
			
	</div>
	 <div class="clear"></div> 
  	<div class="titre">
	<p>LES SALLES LES PLUS VENDUES</p></div>
	<?php
		echo $vente_html;
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