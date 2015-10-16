
<div class="register_account">
  	<div class="wrap">
  	<div class="content-bottom">
  	<div class="titre">
	<p>EDITION CODE PROMOTION</p></div>
    <h4 class="title">Edition code </h4>
	<form action="<?php echo Router::url('admin/gestion_promos/edit'.$id)?>" method="post">
		<div class="col_1_of_2 span_1_of_21">
		 	
			<?php echo $this->Form->input('id_promo','hidden');?>
			<?php echo $this->Form->input('code_promo','Code promotion',array('required'=>true));?>
			<?php echo $this->Form->input('reduction','Reduction',array('required'=>true));?>
			        <div class="actions">
			<input type="submit" class="btn primary" value="Enregistrer">
		</div>
		</div>
    	

         <div class="clear"></div>
    </form>
  </div> 
  </div> 
</div>