<div>
	<h1>Zone reservée</h1>
</div>
<form action="<?php echo Router::url('membre/login')?>" method="post">
		<?php echo $this->Form->input('pseudo','Identifien',array('required'=>true));?>
		<?php echo $this->Form->input('mdp','Mode de passe',array('type'=>'password','required'=>true));?>
	<div></div>	
	<div class="actions">
		<input type="submit" class="btn primary" value="Se connecter">
	</div>

</form>