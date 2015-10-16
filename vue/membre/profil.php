
<?php 

if (!isset($commande)) {
	$html_commande = '<h3 class="m_1">Aucun commandes</h3>';
}else{
	$html_commande = '<h3 class="m_1">Vos commandes</h3>';
	$html_commande .= '<table class="sortables">
					<thead>
						<tr>
							<th>Numero de suivi</th>
							<th>Date</th>
						</tr>
					</thead>
					<tbody>';
	foreach ($commande as $k => $value){
		$html_commande .= '<tr>
			<td>'.$value->id_commande.'</td>
			<td>';
			$date = new Datetime($value->date); 
			$forma_date =  $date->format('d/m/Y');
			$html_commande .= $forma_date.'</td>
							</tr>';
	}
	$html_commande .='							
	</tbody></table>';							
							
	}

?>


<div class="main">
    <div class="wrap">
  		<div class="content-bottom">
			<div class="titre">
			<p>VOTRE PROFIL </p></div>
			    
			<div class="col_1_of_2 span_1_of_2">
                
                <div class="view view-fifth">
                    <div class="top_box">
                        <h3 class="m_1">Vos informations</h3>
                        <h3>
                        <?php  
							echo 'Nom :'.$membre->nom.'<br>';
							echo 'Prenom : '.$membre->prenom.'<br>';
							echo 'email : '.$membre->email.'<br>';
							echo 'sexe : '.$membre->sexe.'<br>';
							echo 'ville : '.$membre->ville.'<br>';
							echo 'cp : '.$membre->cp.'<br>';
							echo 'adesse : '.$membre->adesse.'<br>';
							//echo 'statut : '.$membre->statut.'<br>';

						?>
                        </h3>
                    </div>

                </div>
                
                <div class="clear"></div>
                <div class="btn1">
					<a href="<?php 
					//$myurl = BASE_URL.'/membre';
					echo Router::url('Membre/edit/'.$membre->id_membre);?>">Modifer vos informations</a>
				</div>
            </div>
       
            <div class="col_1_of_2 span_1_of_2">
                    
                <div class="view view-fifth ">

                    <div class="top_box">
                        <?php echo $html_commande ;?>
                        
                    </div>
                   
                </div>
                
                <div class="clear"></div>
            </div>

            <div class="clear">
            </div>
            <div class="clear"></div>
				
				<!-- div class="btn1">	


					<a href="<?php 
					//$myurl = BASE_URL.'/membre';
					echo Router::url('Membre/index');?>">Retour &larr;</a>
				</div -->
			<div class="header-bottom"><p>SUIVEZ NOUS</p></div>
		</div>

		
	</div>
</div>