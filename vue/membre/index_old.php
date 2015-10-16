<div>
	<h1>Gestion des membres</h1>
</div>
<?php
	foreach ($membres as $key => $value): ?>
		<h2><?php echo $value->pseudo; ?></h2>
		<!-- p><a href="<?php //echo BASE_URL.'/membre/view/'.$value->id_membre; ?>">detail &rarr;</a>
		Membre/view/'.$value->id_membre.'/'.$value->pseudo
		Membre/:pseudo-:id','membre/view/id:([0-9]+)/pseudo:([a-z0-9\-]+)')-->
		<p><a href="<?php 
		$a = $value->id_membre.'/'.$value->pseudo;
		echo Router::url('Membre/view/'.$a); ?>">detail &rarr;</a></p>
		<p><a href="<?php 
		echo Router::url('Membre/'.$value->pseudo.'-'.$value->id_membre); ?>">detail &rarr;</a></p>
		<p><a href="<?php 
		echo Router::url('admin/Membre/'); ?>">detail &rarr;</a></p>
<?php endforeach ?>
<h3>Occurnces : <?php echo $total ?></h3>
