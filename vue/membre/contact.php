<div class="register_account">
  	<div class="wrap">
  	<div class="content-bottom">
  	<div class="titre">
	<p>CONTACTER LOKISALLE</p></div>
    <h4 class="title">Contacter LOKISALLE </h4>
	<?php //debug($this);
	$url = Router::url('membre/contact');
	$mail = array('type'=>'email','required'=>true);
	if ($_SESSION['User']) {
		//debug($_SESSION['User']->email);
		$url = Router::url('/membre/contact'.$_SESSION['User']->id_membre);
		$mail = array('type'=>'email','required'=>true,'value'=>$_SESSION['User']->email);
	}
	?>
	<form action="<?php echo $url;?>" method="post">
		
		<div class="col_1_of_2 span_1_of_21">
			<?php echo $this->Form->input('sender','Expéditeur <span> * email<span>',$mail);?>
		 	<?php echo $this->Form->input('subject','Sujet',array('required'=>true));?>
			<?php echo $this->Form->input('message','Message<span>*<span>', array('type'=>'textarea','required'=>true));?>
					
		<div class="actions">
							<input type="submit" class="btn primary" value="Envoyer">
						</div>
		</div>
         <div class="clear"></div>
    </form>
  </div> 
  </div> 
</div>