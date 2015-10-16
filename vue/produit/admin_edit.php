<div class="register_account">
  	<div class="wrap">
  	<div class="content-bottom">
  	<div class="titre">
	<p>EDITION DE PRODUIT</p></div>
    <h4 class="title">Editer un Produit</h4>
	<form action="<?php echo Router::url('admin/produit/edit/'.$id)?>" method="post">
		<div class="col_1_of_2 span_1_of_21">
		 	
			
			<?php echo $this->Form->input('id_produit','hidden');?>
			<?php echo $this->Form->input('id_salle','choix Salle',array('type'=>'select','src'=>$tb_salle,'required'=>true));?>
			<?php echo $this->Form->input('date_arrivee','Data arrivée',array('type'=>'datetime','required'=>true));?>
			<?php echo $this->Form->input('date_depart','Date depart',array('type'=>'datetime','required'=>true));?>
			
			
		</div>
    	<div class="col_1_of_2 span_1_of_21">	
    		<?php echo $this->Form->input('prix','Prix',array('required'=>true));?>
			<?php echo $this->Form->input('etat','Etat',array('type'=>'select','src'=>array(0=>'Libre',1=>'Alouer'),'required'=>true));?>
			<?php echo $this->Form->input('id_promo','Code promo',array('type'=>'select','src'=>$tb_promo));?>
		</div>
        <div class="actions">
			<input type="submit" class="btn primary" value="Enregistrer">
		</div>
         <div class="clear"></div>
    </form>
    <div>
		<?//php echo debug($tb_salle)?>
		<p><a href="<?php echo Router::url('admin/produit/index'); ?>">retour &larr;</a></p>
	</div>
	 <div class="clear"></div>
	<div class="header-bottom"><p><br></p></div>
  </div> 
  </div> 
</div>
<!-- div class="main">
    <div class="wrap">
  		<div class="content-bottom">
			<div class="titre">
			<p>MODIFIER VOS INFORMATIONS</p></div>
			    
			<div class="data">
				<div class="page-header">
					<h1>Editer un Produit</h1>
				</div>
				<form action="<?php echo Router::url('admin/produit/edit/'.$id)?>" method="post">
					<?php echo $this->Form->input('id_produit','hidden');?>
					<?php echo $this->Form->input('id_salle','choix Salle',array('type'=>'select','src'=>$tb_salle,'required'=>true));?>
					<?php echo $this->Form->input('date_arrivee','Data arrivée',array('type'=>'datetime'));?>
					<?php echo $this->Form->input('date_depart','Date depart',array('type'=>'datetime'));?>
					<?php echo $this->Form->input('prix','Prix',array('required'=>true));?>
					<?php echo $this->Form->input('etat','Etat',array('type'=>'select','src'=>array(0=>'Libre',1=>'Allouer'),'required'=>true));?>
					<?php echo $this->Form->input('id_promo','Code promo',array('type'=>'select','src'=>$tb_promo));?>
					
					
					
					<div class="actions">
						<input type="submit" class="btn primary" value="Envoyer">
					</div>

				</form>
				<div>
				<?//php echo debug($tb_salle)?>
				<p><a href="<?php echo Router::url('admin/produit/index'); ?>">retour &larr;</a></p>
				</div>

			
			</div>

			</div>
			<div class="header-bottom"><p>SUIVEZ NOUS</p></div>
		</div>

		
	</div>
</div -->
