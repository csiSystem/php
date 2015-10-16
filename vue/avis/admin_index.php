<?php 
//debug($produits);
$tb_mois = array("Janvier","Février","Mars","Avril","Mai","Juin","Juillet","Août","Septembre","Octobre","Novembre","Décembre");
?>
<div class="main">
    <div class="wrap">
  		<div class="content-bottom">
			<div class="titre">
			<p>GESTION DES AVIS</p></div>
			    
			<div class="data">
				<div classe="page-header">
					<h1><?php $total ?>Les avis postés</h1>
				</div>
				<table class="sorttable">
					<thead>
						<tr>
							<th>Id_avis</th>
							<th>Id_membre</th>
							<th>Id_salle</th>
							
							<th>Commentaire</th>
							<th>Note</th>
							<th>Date</th>
							<th>Supprimer</th>
						</tr>
					</thead>
					<tbody>
						
						<?php foreach ($avis as $key => $value): ?>
							<tr>
								<td><?php echo $value->id_avis; ?></td>
								<td><?php echo $value->id_membre; ?></td>
								<td><?php echo $value->id_salle; ?></td>
								<td><?php echo $value->commentaire; ?></td>
								<td><?php echo $value->note; ?></td>
								
								<td><?php $date = new Datetime($value->date); 
									$a = $date->format('d/m/Y') ;
									$ladate = explode('/', $a)[0].' '.$tb_mois[intval(explode('/', $a)[1])-1].' '.explode('/', $a)[2];
									echo $ladate;
									?></td>
								<td>
									<a onclick="return confirm('voulez vous vraiment supprimer ce contenu?');" href="<?php echo Router::url('admin/avis/delete/'.$value->id_avis); ?>">X</a>
								</td>
							</tr>
						<?php endforeach ?>
					</tbody>
				</table>
				

			</div>
			<div class="header-bottom"><p>SUIVEZ NOUS</p></div>
		</div>

		
	</div>
</div>
