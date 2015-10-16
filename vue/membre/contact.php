

<div class="main">
    <div class="wrap">
  		<div class="content-bottom">
			<div class="titre">
			<p>MODIFIER VOS INFORMATIONS</p></div>
			    
			<div class="data">
				<div class="page-header">
				<h1>Contacter LOKISALLE </h1>

				</div>
				<?php //debug($this);
					$url = Router::url('membre/contact');
					if ($_SESSION['User']) {
						$url = Router::url('/membre/contact'.$_SESSION['User']->id_membre);
					}
				?>
				<form action="<?php echo $url;?>" method="post">
					<?php echo $this->Form->input('sender','Expéditeur');?>
					<?php echo $this->Form->input('subject','Sujet',array('required'=>true));?>
					<?php echo $this->Form->input('message','Message', array('type'=>'textarea','required'=>true));?>
					
					<div class="actions">
						<input type="submit" class="btn primary" value="Envoyer">
					</div>

				</form>
				<div>

				</div>
				<div>
					
				<p><a href="<?php echo Router::url('membre/index'); ?>">retour &larr;</a></p>
				</div>

			</div>
			<div class="header-bottom"><p>SUIVEZ NOUS</p></div>
		</div>

		
	</div>
</div>