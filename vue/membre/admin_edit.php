
<div class="main">
    <div class="wrap">
  		<div class="content-bottom">
			<div class="titre">
			<p>GESTION DES MEMBRES</p></div>
			 

			<div class="register_account">
          	
    	    <h4 class="title">Mise a jour de vos informations</h4>
    		<form action="<?php echo Router::url('Visiteur/inscription')?>" method="post">
    			<div class="col_1_of_2 span_1_of_21">
    			 	
					<?php echo $this->Form->input('id_membre','hidden');?>
					<?php echo $this->Form->input('nom','Nom',array('required'=>true));?>
					<div class="line">
						<?php echo $this->Form->input('prenom','Prenom', array('class'=>'prenom','required'=>true));?>
						</div>
					<div class="line1">	
						<?php echo $this->Form->input('sexe','Sexe',array('type'=>'radio','class'=>'gender','required'=>true,'val' =>array('m','f')));?>
					</div>
					<div class="clear"></div>
					<?php echo $this->Form->input('mdp','Mot de passe',array('required'=>true));?>
					
					<?php echo $this->Form->input('email','Email<span>*<span>',array('type'=>'email','required'=>true));?>
					
				</div>
		    	<div class="col_1_of_2 span_1_of_21">	
		    		<?php 
		    			echo $this->Form->input('pseudo','Pseudo',array('required'=>true));
		    		?>
		    		<?php echo $this->Form->input('ville','Ville',array('required'=>true));?>
					<?php echo $this->Form->input('cp','Cp',array('required'=>true));?>
					<?php echo $this->Form->input('adesse','Adesse',array('required'=>true));?>
					<?php echo $this->Form->input('statut','hidden',array('val'=>0));?>
				</div>
		        <div class="actions">
					<input type="submit" class="btn primary" value="Enregistrer">
				</div>
		         <div class="clear"></div>
		    </form>
    	  
        		
	</div>
</div>