
<div class="main">
    <div class="wrap">
  		<div class="content-bottom">
			
			    <div class="clear"></div>
			<div class="box1">
			<div class="clear"></div>
				<div class="titre">
				<p>
					TOUTES NOS OFFRES
				</p></div>
			   	<?php foreach ($produit as $key => $value): ?>
					<div class="col_1_of_2 span_1_of_2">
						<a href="<?php echo Router::url("Visiteur/reservation_details/{$value->id_produit}"); ?>">
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
											<ul class="sub-icon1 list">
												<li><h3>Connectez vous</h3><a href=""></a></li>
												<li><p>Vous devez etes connecter ajouter ce produit <a href="<?php echo Router::url('connection/creatUser');?>">Créer votre compte si vous en avez pas</a></p></li>
											</ul>
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
