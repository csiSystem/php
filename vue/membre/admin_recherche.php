
<div class="main">
    <div class="wrap">
  		<div class="content-bottom">
			
			    <div class="clear"></div>
			<div class="box1">
			<div class="clear"></div>
			   
			   <div class="chercher">

			   	<form action="<?php echo Router::url('admin/Membre/recherche')?>" method="post">
					<?php 
						$tb_mois = array("Janvier","Février","Mars","Avril","Mai","Juin","Juillet","Août","Septembre","Octobre","Novembre","Décembre");
						$tb_annee = array("2015","2016","2017","2018","2019","2020","2021","2022","2023","2025","2026","2027");
					?>
					<div class="section group">
						<div class="col_1_of_middle span_1_of_middle">
							<p>A la date du:</p>
							<?php echo $this->Form->input('mois',"Choix du mois",array('type'=>'select','src'=>$tb_mois));?>
							<?php echo $this->Form->input('annee',"Choix de l'année",array('type'=>'select','src'=>$tb_annee));?>
						
		   				 </div>
						<div class="col_1_of_middle span_1_of_middle">
								<p>Par un mot clé</p>
								<?php echo $this->Form->input('mot_clef','Mots clé');?>
								
						</div>
					</div>
					<div class="actions">
						<input type="submit" class="btn primary" value="Recherche">
					</div>

				</form>
			   </div>
			   <div class="titre">
			   	<p>
			   		<?php
					if (isset($reserch) && $reserch === true){
						echo "RESULTAT RECHERCHE";
					}else{
						echo "TOUTES NOS OFFRES";
					}
				?>
			   </p></div>
			    
			   	<?php foreach ($produit as $key => $value): ?>
					<div class="col_1_of_2 span_1_of_2">
						<!-- a href="<?php echo Router::url("admin/Membre/reservation_details/id:{$produits[1]->id_produit}"); ?>"-->
						<a href="<?php echo Router::url('admin/Membre/reservation_details/'.$value->id_produit); ?>">
						    <div class="view view-fifth">
								<div class="top_box">
							  		<h3 class="m_1"><?php echo $value->titre;?> <?php echo $value->ville;?></h3>
							  		<p class="m_2">
							  			<?php echo $value->capacite;?> personnes, 
							  			du <?php $date = new Datetime($value->date_arrivee); echo $date->format('d/m/Y H:i');?>
							    		au <?php $date = new Datetime($value->date_depart); echo $date->format('d/m/Y H:i');?>
							    	</p>
								    <div class="grid_img">
									   <div class="css3"><img src="<?php echo BASE_URL."/webracine/images/".$value->photo;?>" alt=""/></div>
								          <div class="mask">
				                       		<div class="info">Voir détaile</div>
						                  </div>
				                    </div>
		                       		<div class="price"><?php echo number_format($value->prix,2,",",".");?>&euro;</div>
							    </div>
						    </div>
						   	<span class="rating">
						        &rarr;Fiche détaillée
			    	        </span>
							<ul class="list">
							    <li>
								  	<!-- img src="web/images/plus.png" alt=""/ -->
								  	<ul class="icon1 sub-icon1 profile_img">
									  	<li>
										  	<a class="active-icon c1" href="<?php echo Router::url('connection/connexion_panier/'.$value->id_produit);?>">Ajouter au panier</a>
											
										</li>
									</ul>
							   </li>
						    </ul>
					    	<div class="clear"></div>
				    	</a>
				    </div>
			    <?php endforeach ?>
				<div class="clear"></div>
			</div>
			
		</div>
