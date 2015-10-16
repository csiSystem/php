
<div class="main">
    <div class="wrap">
  		<div class="content-bottom">
			<div class="titre">
			<p>GESTION DES PROMOTION</p></div>
			    
			<div class="data">
							
								
								<div classe="page-header">
					
				</div>
				<table class="sorttable">
					<thead>
						<tr>
							<th>ID</th>
							<th>Code promo</th>
							<th>Reduction</th>
							<th colspan="2">Actions</th>
						</tr>
					</thead>
					<tbody>
						
						<?php foreach ($promos as $key => $value): ?>
							<tr>
								<td><?php echo $value->id_promo; ?></td>
								<td><?php echo $value->code_promo; ?></td>
								<td><?php echo $value->reduction; ?></td>
								
								
								<td>
									<a href="<?php echo Router::url('admin/gestion_promos/edit/'.$value->id_promo); ?>">Editer</a>
								</td>
								<td>
									<a onclick="return confirm('voulez vous vraiment supprimer ce contenu?');" href="<?php echo Router::url('admin/gestion_promos/delete/'.$value->id_salle); ?>">Supprimer</a>
								</td>
							</tr>
						<?php endforeach ?>
					</tbody>
				</table>
				<h1><?php $total ?>salles</h1>
				
  				<div class="button1">
					   <a href="<?php echo Router::url('admin/gestion_promos/edit'); ?>"><input type="submit" name="Submit" value="Ajouter une salle"></a>
				 </div>
				 <div class="clear"></div>
			</div>
			
		</div>

		
	</div>
</div>
