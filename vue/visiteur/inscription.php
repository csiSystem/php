<div class="register_account">
          	<div class="wrap">
    	    <h4 class="title">Creer un nouveau compte</h4>
    		<form action="<?php echo Router::url('Visiteur/inscription')?>" method="post">
    			<div class="col_1_of_2 span_1_of_21">
    			 	
					<?php echo $this->Form->input('id_membre','hidden');?>
					<?php echo $this->Form->input('nom','Nom',array('required'=>true));?>
					<div class="line">
						<?php echo $this->Form->input('prenom','Prenom', array('class'=>'prenom','required'=>true));?>
						</div>
					<div class="line1">	
						<?php echo $this->Form->input('sexe','Sexe',array('type'=>'radio','class'=>'gender','required'=>true,'val' =>array('M','F')));?>
					</div>
					<div class="clear"></div>
					<?php echo $this->Form->input('mdp','Mot de passe',array('required'=>true));?>
					
					<?php echo $this->Form->input('email','Email<span>*<span>',array('type'=>'email','required'=>true));?>
					
				</div>
		    	<div class="col_1_of_2 span_1_of_21">	
		    		<?php echo $this->Form->input('pseudo','Pseudo',array('required'=>true));?>
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
<!-- div class="page-header">
	<h1>Inscrition </h1>
</div>
<form action="<?php echo Router::url('Visiteur/inscription')?>" method="post">
	
	<?php echo $this->Form->input('id_membre','hidden');?>
	<?php echo $this->Form->input('pseudo','Pseudo');?>
	<?php echo $this->Form->input('nom','Nom');?>
	<?php echo $this->Form->input('prenom','Prenom');?>
	<?php echo $this->Form->input('mdp','Mot de passe');?>
	<?php echo $this->Form->input('email','Email');?>
	<?php echo $this->Form->input('sexe','Sexe',array('type'=>'radio','val' =>array('M','F')));?>
	<?php echo $this->Form->input('ville','Ville');?>
	<?php echo $this->Form->input('cp','Cp');?>
	<?php echo $this->Form->input('adesse','Adesse');?>
	<?php echo $this->Form->input('statut','hidden');?>
	<div class="actions">
		<input type="submit" class="btn primary" value="Envoyer">
	</div>

</form>
<div>
	
<p><a href="<?php echo Router::url('Visiteur/index'); ?>">retour &larr;</a></p>
</div -->