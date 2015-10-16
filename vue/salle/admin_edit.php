
<div class="register_account">
  	<div class="wrap">
  	<div class="content-bottom">
  	<div class="titre">
	<p>EDITION SALLE</p></div>
    <h4 class="title">Edition Salle</h4>
	<form action="<?php echo Router::url('admin/salle/edit/'.$id)?>" method="post">
		<div class="col_1_of_2 span_1_of_21">
		 	
			
			<?php echo $this->Form->input('id_salle','hidden');?>
			<?php echo $this->Form->input('pays','Pays',array('required'=>true));?>
			<?php echo $this->Form->input('ville','Ville',array('required'=>true));?>
			<?php echo $this->Form->input('adresse','Adresse',array('required'=>true));?>
			<?php echo $this->Form->input('cp','Code postal',array('required'=>true));?>
			<?php echo $this->Form->input('categorie','Categorie',array('type'=>'radio','required'=>true,'val' =>array('reunion','congres')));?>
			
			
		</div>
    	<div class="col_1_of_2 span_1_of_21">	
    		<?php echo $this->Form->input('titre','Titre',array('required'=>true));?>
    		<?php echo $this->Form->input('capacite','Capacite',array('required'=>true));?>
			<?php echo $this->Form->input('description','Description',array('type'=>'textarea','required'=>true));?>
			<div class="line">	
			<?php echo $this->Form->input('photo','Photo',array('required'=>true));?>
			</div>

			<!-- div class="line1">	
				<?php echo $this->Form->input('sexe','Sexe',array('type'=>'radio','class'=>'gender','required'=>true,'val' =>array('M','F')));?>
			</div -->
		</div>
        <div class="actions">
			<input type="submit" class="btn primary" value="Enregistrer">
		</div>
         <div class="clear"></div>
    </form>
  </div> 
  </div> 
</div>
<!-- div class="main">
    <div class="wrap">
  		<div class="content-bottom">
			<div class="titre">
			<p>EDITION SALLE</p></div>
			    
			<div class="data">
				<div class="page-header">
					<h1>Editer une Salle </h1>
				</div>
				<form action="<?php echo Router::url('admin/salle/edit/'.$id)?>" method="post">
										
					<?php echo $this->Form->input('capacite','Capacite');?>
					<?php echo $this->Form->input('categorie','Categorie',array('type'=>'radio','val' =>array('reunion','congres')));?>
					<?php echo $this->Form->input('description','Description');?>
					<?php echo $this->Form->input('photo','Photo');?>
					<div class="actions">
						<input type="submit" class="btn primary" value="Envoyer">
					</div>

				</form>
				<div>
					
				<p><a href="<?php echo Router::url('admin/salle/index'); ?>">retour &larr;</a></p>
				</div>

			</div>
			<div class="header-bottom"><p>SUIVEZ NOUS</p></div>
		</div>

		
	</div>
</div -->
