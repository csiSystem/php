
<div class="main">
    <div class="wrap">
  		<div class="content-bottom">
			<div class="titre">
			<p>GESTION DES MEMBRES</p></div>
			    
			<div class="data">
				<div classe="page-header">
					<h1><?php $total ?>Membres</h1>
				</div>
				<table class="sorttable">
					<thead>
						<tr>
							<th>ID</th>
							<th>pseudo</th>
							<th>Nom</th>
							<th>Prenom</th>
							<th>statut</th>
							<th colspan="2">Actions</th>
						</tr>
					</thead>
					<tbody>
						
						<?php foreach ($membres as $key => $value): ?>
							<tr>
								<td><?php echo $value->id_membre; ?></td>
								<td><?php echo $value->pseudo; ?></td>
								<td><?php echo $value->nom; ?></td>
								<td><?php echo $value->prenom; ?></td>
								<td><span class="label <?php echo ($value->statut ==1)?'succes':'error'; ?>"><?php echo ($value->statut ==1)?'Administrateur':'Membres'; ?></span></td>
								<td>
									<a href="<?php echo Router::url('admin/membre/edit/'.$value->id_membre); ?>">Editer</a>
								</td>
								<td>
									<a onclick="return confirm('voulez vous vraiment supprimer ce contenu?');" href="<?php echo Router::url('admin/membre/delete/'.$value->id_membre); ?>">Supprimer</a>
								</td>
							</tr>
						<?php endforeach ?>
					</tbody>
				</table>
				<h3><?php echo 'Total membres : '.$total ?></h3>
				<div class="button1">
					   <a href="<?php echo Router::url('admin/membre/edit'); ?>"><input type="submit" name="Submit" value="Ajouter un membre"></a>
				 </div>
				 <div class="clear"></div>
			</div>
			<div class="clear"></div>
  		</div>

		
	</div>
</div>