
<div class="main">
    <div class="wrap">
  		<div class="content-bottom">
			<div class="titre">
			<h3 class="m_1">DETAIL SALLE : <?Php echo $salle->titre.' '.$salle->ville;?></h3> </div>
			    
			<div class="col_1_of_2 span_1_of_2">
                
                <div class="view view-fifth">
                    <div class="top_box">
                        <h3 class="m_1">Vos informations</h3>
                        <h3>
                        <?php  
                        	echo 'Titre :'.$salle->titre.'<br>';
							echo 'Pays :'.$salle->pays.'<br>';
							echo 'Ville : '.$salle->ville.'<br>';
							echo 'Cp : '.$salle->cp.'<br>';
							echo 'Adresse : '.$salle->adresse.'<br>';
							echo 'Capacite : '.$salle->capacite.'<br>';
							echo 'Categorie : '.$salle->categorie.'<br>';
							
							echo 'Description : '.$salle->description.'<br>';
							//echo 'statut : '.$membre->statut.'<br>';

						?>
                        </h3>
                    </div>

                </div>
                
                <div class="clear"></div>
  				<div class="button1">
					   <a href="<?php echo Router::url('admin/salle/edit/'.$salle->id_salle); ?>"><input type="submit" name="Submit" value="Metre à jour"></a>
				 </div>
				 <div class="clear"></div>
				
            </div>
       		
            <div class="col_1_of_2 span_1_of_2">
                    
                <div class="grid_img">
					 <div class="css3"><img src="<?php echo BASE_URL."/webracine/images/".$salle->photo;?>" alt=""/></div>
								          
				</div>
                
                <div class="clear"></div>
            </div>

            <div class="clear">
            </div>
            
				
				
			<div class="header-bottom"><p></p></div>
		</div>

		
	</div>
</div>