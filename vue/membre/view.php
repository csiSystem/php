<h1><?php echo 'pseudo membre : '.$membre->pseudo;?></h1>
<?php  
	echo 'Nom :'.$membre->nom.'<br>';
	echo 'Prenom : '.$membre->prenom.'<br>';
	echo 'email : '.$membre->email.'<br>';
	echo 'sexe : '.$membre->sexe.'<br>';
	echo 'ville : '.$membre->ville.'<br>';
	echo 'cp : '.$membre->cp.'<br>';
	echo 'adesse : '.$membre->adesse.'<br>';
	echo 'statut : '.$membre->statut.'<br>';

?>

<p><a href="<?php 
//$myurl = BASE_URL.'/membre';
echo Router::url('membre/view');?>">Retour &larr;</a></p>
