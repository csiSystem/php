<?php 
//debug($produits);
$tb_mois = array("Janvier","Février","Mars","Avril","Mai","Juin","Juillet","Août","Septembre","Octobre","Novembre","Décembre");
?>
<div class="main">
    <div class="wrap">
  		<div class="content-bottom">
			<div class="titre">
			<p>Gestion des produits</p></div>
			    
			<div class="data">
				
				<div classe="page-header">
						<h1>Gestion des produits</h1>
					</div>
					<table class="sorttable">
						<thead>
							<tr>
								<th>ID</th>
								<th>Date arrivée</th>
								<th>Date depart</th>
								
								<th>Promo</th>
								<th>Salle</th>
								<th>Prix</th>
								<th>Etat</th>
								<th colspan="2">Actions</th>
							</tr>
						</thead>
						<tbody>
							
							<?php foreach ($produits as $key => $value): ?>
								<tr>
									<td><?php echo $value->id_produit; ?></td>
									
									<td><?php $date = new Datetime($value->date_arrivee); 
									$a = $date->format('d/m/Y') ;
									$ladate = explode('/', $a)[0].' '.$tb_mois[intval(explode('/', $a)[1])-1].' '.explode('/', $a)[2];
									echo $ladate;
									?></td>
									<td><?php $date = new Datetime($value->date_depart); 
									$a = $date->format('d/m/Y') ;
									$ladate = explode('/', $a)[0].' '.$tb_mois[intval(explode('/', $a)[1])-1].' '.explode('/', $a)[2];
									echo $ladate;
									?></td>
									
									<td>
										<?php foreach ($promo as $k => $v) {
											$codepro ='';
											if ($value->id_promo == $v->id_promo) {
												$codepro = $v->code_promo;
												break;
											}
										}  
										?>
										<a href="<?php echo Router::url('admin/gestion_promos/index'); ?>"><?php echo $codepro;?></a>
									</td>
									<td>
										<?php foreach ($salle as $k => $v) {
											$titre ='';
											if ($value->id_salle == $v->id_salle) {
												$titre= $v->titre;
												break;
											}
										}

										?>
										<a href="<?php echo Router::url('admin/salle/view/'.$value->id_salle); ?>"><?php echo $titre;?></a>
									</td>
									<td><?php echo $value->prix; ?></td>
									<td><?php echo $value->etat; ?></td>
									<td>
										<a href="<?php echo Router::url('admin/produit/edit/'.$value->id_produit); ?>">Editer</a>
									</td>
									<td>
										<a onclick="return confirm('voulez vous vraiment supprimer ce contenu?');" href="<?php echo Router::url('admin/produit/delete/'.$value->id_produit); ?>">Supprimer</a>
									</td>
								</tr>
							<?php endforeach ?>
						</tbody>
					</table>
					<h3><?php echo 'Total produits :'.$total ?></h3>
					
			</div>
				<div class="clear"></div>
  				<div class="button1">
					   <a href="<?php echo Router::url('admin/produit/edit'); ?>"><input type="submit" name="Submit" value="Ajouter un produit"></a>
				 </div>
				 <p><br></p>
				 <div class="clear"></div>
			</div>
			<div class="header-bottom"><p><?php echo 'Total produits :'.$total ?></p></div>
		</div>

		
	</div>
</div>
