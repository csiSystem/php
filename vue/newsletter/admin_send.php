

<div class="register_account">
  	<div class="wrap">
  	<div class="content-bottom">
  	<div class="titre">
	<p>EDITION DE LA NEWSLETTER</p></div>
    <h4 class="title">Editer une Newsletter </h4>
	<form action="<?php echo Router::url('admin/newsletter/index')?>" method="post">
		
		<div class="col_1_of_2 span_1_of_21">
		 	<h3>
			<?php 
			$attr_email = array('value'=>$sender);
			$attr_subejt = array('required'=>true);
			$attr_message = array('type'=>'textarea','required'=>true);
			
			if ($total >= 1 ) {
				echo 'Le nombre d\'abonnés à la news letter : '.$total ;
			}else{
				echo 'Aucun membre inscrit à la news letter';
				$attr_email = array('value'=>$sender,'disabled'=>"disabled");
				$attr_subejt = array('required'=>true, 'disabled'=>"disabled");
				$attr_message = array('type'=>'textarea','required'=>true,'disabled'=>"disabled");
			} ?>
			</h3>
			<?php echo $this->Form->input('email','Expéditeur',$attr_email);?>
			<?php echo $this->Form->input('subject','Sujet',$attr_subejt);?>
			<?php echo $this->Form->input('to','hidden', array('value'=>$email));?>
			<?php echo $this->Form->input('message','Message', $attr_message);?>
			<?php 
				if ($total >= 1 ) {
					echo '<div class="actions">
							<input type="submit" class="btn primary" value="Enregistrer">
						</div>';	
				}
			?>
		
		</div>
         <div class="clear"></div>
    </form>
  </div> 
  </div> 
</div>
