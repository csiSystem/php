

<?php $val=false;

$a = $produits;
$data =array_chunk($a,4)[mt_rand(0, sizeof(array_chunk($a,4)))];


?>
<div class="index-banner">
       	  <div class="wmuSlider example1" style="height: 560px;">
			    <div class="wmuSliderWrapper">
			  	    <?php foreach ($data as $key => $value): ?>
						<?php 
							if ($val != true) {
								echo '<article style="position: relative; width: 100%; opacity: 1;">';
								$val = true; 
							}else{
								echo '<article style="position: absolute; width: 100%; opacity: 0;"> ';
							}
						?>	  
					  	
					   	<div class="banner-wrap">
						   	<div class="slider-left">
								<img src="<?php echo BASE_URL."/webracine/images/".$value->photo;?>" alt=""/> 
							</div>
							 <div class="slider-right">
							    <h2><?php echo $value->titre;?></h2>
							    <h2><?php echo $value->ville;?></h2>
							    <h3>Date d'arrivée : <?php $date = new Datetime($value->date_arrivee); echo $date->format('d/m/Y H:i');?>
							    	<br>Date de départ: <?php $date = new Datetime($value->date_depart); echo $date->format('d/m/Y H:i');?><br>Capacité: <?php echo $value->capacite;?> personnes.<br>Prix : <b><?php echo number_format($value->prix,2,",",".");?>&euro;</b></h3>
							    <a href="<?php echo Router::url("admin/Membre/reservation_details/$value->id_produit"); ?>"> &rarr;Fiche détaillée</a>

							    <div class="btn">
							    	<a href="<?php echo Router::url('connection/connexion_panier/'.$value->id_produit);?>">Réserver</a>
							    </div>
							 </div>
							 <div class="clear"></div>
						</div>
						</article>
				   <?php endforeach ?>
				</div>
                <a class="wmuSliderPrev">Previous</a><a class="wmuSliderNext">Next</a>
                <ul class="wmuSliderPagination">
                	<li><a href="#" class="">0</a></li>
                	<li><a href="#" class="">1</a></li>
                	<li><a href="#" class="wmuActive">2</a></li>
                	<li><a href="#">3</a></li>
                	<li><a href="#">4</a></li>
                </ul>
                 <a class="wmuSliderPrev">Previous</a><a class="wmuSliderNext">Next</a>
                 <ul class="wmuSliderPagination">
                 	<li><a href="#" class="wmuActive">0</a></li>
                 	<li><a href="#" class="">1</a></li>
                 	<li><a href="#" class="">2</a></li>
                 	<li><a href="#" class="">3</a></li>
                 	<li><a href="#" class="">4</a></li>
                 </ul>
                 </div>
            	 <script src="<?php echo BASE_URL."/webracine/js/jquery.wmuSlider.js";?>"></script> 
				 <script type="text/javascript" src="<?php echo BASE_URL."/webracine/js/modernizr.custom.min.js";?>"></script> 
				<script>
						 $('.example1').wmuSlider();         
					</script> 	           	      
             </div>
<div class="main">
    <div class="wrap">
  		<div class="content-bottom">
			<div class="header-bottom"><p>NOS TROIS DERNIERES OFFRES</p></div>
			    <div class="clear"></div>
			<div class="box1">
			   
			    
			   	<?php foreach ($last_produit as $key => $value): ?>
					<div class="col_1_of_3 span_1_of_3">
						<a href="<?php echo Router::url("admin/Membre/reservation_details/{$value->id_produit}"); ?>">
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
						        &rarr;Fiche detaillée
			    	        </span>
							<ul class="list">
							    <li>
								  	<!-- img src="web/images/plus.png" alt=""/ -->
								  	<ul class="icon1 sub-icon1 profile_img">
									  	<li>
										  	<a class="active-icon c1" href="<?php echo Router::url('connection/connexion_panier/'.$value->id_produit);?>"> + Ajout au panier</a>
											
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
			<div class="header-bottom"><p>SUIVEZ NOUS</p></div>
		</div>

		<div class="content-top">

     		<div class="lsidebar span_1_of_c1">
				<p>Nous sommes sur les réseaux sociaux</p>
			</div>
			<div class="cont span_2_of_c1">
			  	<div class="social">	
			     	<ul>	
				  		<li class="facebook"><a href="#"><span> </span></a><div class="radius"> <img src="<?php echo BASE_URL."/webracine/images/radius.png";?>"><a href="#"> </a></div><div class="border hide"><p class="num">1.51K</p></div></li>
				 	</ul>
	   		   </div>
			   <div class="social">	
				   	<ul>	
						<li class="twitter"><a href="#"><span> </span></a><div class="radius"> <img src="<?php echo BASE_URL."/webracine/images/radius.png";?>"></div><div class="border hide"><p class="num">1.51K</p></div></li>
				  	</ul>
	     		</div>
				 	<div class="social">	
					   	<ul>	
							<li class="google"><a href="#"><span> </span></a><div class="radius"> <img src="<?php echo BASE_URL."/webracine/images/radius.png";?>"></div><div class="border hide"><p class="num">1.51K</p></div></li>
					   	</ul>
		    		</div>
				<div class="social">	
					<ul>	
						<li class="dot"><a href="#"><span> </span></a><div class="radius"> <img src="<?php echo BASE_URL."/webracine/images/radius.png";?>"></div><div class="border hide"><p class="num">1.51K</p></div></li>
					</ul>
	     		</div>
				<div class="clear"> </div>
			</div>
			<div class="clear"></div>			
		</div>
			  
	</div>
</div>

                
<?php
//debug($last_produit);
//$scr=BASE_URL."/webracine/images/".$produits[1]->photo;
//echo $scr;
//echo '<img src="'.BASE_URL."/webracine/images/".$produits[1]->photo.'" alt=""> ';
//<?php echo Router::url('admin/membre/edit/'.$value->id_membre); ?
?>


