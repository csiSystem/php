
<div class="main">
    <div class="wrap">
  		<div class="content-bottom">
			<div class="titre">
			<p>MODIFIER VOS INFORMATIONS</p></div>
			    
			<div class="data">
				<div classe="page-header">
					<h1><?php $total ?>salles</h1>
				</div>
				<table class="sorttable">
					<thead>
						<tr>
							<th>ID</th>
							<th>Pays</th>
							<th>Ville</th>
							<th>Adesse</th>
							<th>Cp</th>
							<th>Titre</th>
							<th>Description</th>
							<th>photo</th>
							<th>Capacité</th>
							<th>Catégorie</th>
							<th colspan="2">Actions</th>
						</tr>
					</thead>
					<tbody>
						
						<?php foreach ($salles as $key => $value): ?>
							<tr>
								<td><?php echo $value->id_salle; ?></td>
								<td><?php echo $value->pays; ?></td>
								<td><?php echo $value->ville; ?></td>
								<td><?php echo $value->adresse; ?></td>
								<td><?php echo $value->cp; ?></td>
								<td><?php echo $value->titre; ?></td>
								<td><?php echo $value->description; ?></td>
								
								<td>
									<a href="<?php echo Router::url('admin/salle/view/'.$value->id_salle); ?>">Detaille</a>
				    			</td>
								<td><?php echo $value->capacite; ?></td>
								<td><?php echo $value->categorie; ?></td>
								<td>
									<a href="<?php echo Router::url('admin/salle/edit/'.$value->id_salle); ?>">Editer</a>
								</td>
								<td>
									<a onclick="return confirm('voulez vous vraiment supprimer ce contenu?');" href="<?php echo Router::url('admin/salle/delete/'.$value->id_salle); ?>">Supprimer</a>
								</td>
							</tr>
						<?php endforeach ?>
					</tbody>
				</table>
				<div class="clear"></div>
  				<div class="button1">
					   <a href="<?php echo Router::url('admin/salle/edit'); ?>"><input type="submit" name="Submit" value="Ajouter une salle"></a>
				 </div>
				 <p><br></p>
				 <div class="clear"></div>
				
			</div>

		</div>

		
	</div>
</div>
