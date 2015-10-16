
<div class="main">
    <div class="wrap">
  		<div class="content-bottom">
			<div class="titre">
			<p>MODIFIER VOS INFORMATIONS</p></div>
			    
			<div class="data">
				<div classe="page-header">
					<h1>Commandes</h1>
				</div>
				<div >
					<p>Total commande :<strong> <?php echo $total; ?></strong> </p>
				</div>
				<table class="sorttable">
					<thead>
						<tr>
							<th>id_commande</th>
							<th>id_membre</th>
							<th>Montant</th>
							
						</tr>
					</thead>
					<tbody>
						<?php foreach ($commandes as $key => $value): ?>
							<tr>
								<td><a href="<?php echo Router::url('admin/commande/index/'.$value->id_commande); ?>"><?php echo $value->id_commande; ?></a></td>
								<td><?php echo $value->id_commande; ?></td>
								<td>
									<?php echo number_format($value->montant,2,",",".");?>&euro;
								</td>
								
							</tr>
						<?php endforeach ?>
					</tbody>


					
				</table>
				<div class="col_1_of_2 span_1_of_21">
				
					
				</div>
				<div class="col_1_of_2 span_1_of_21">
				<h4 class="sub_title">Informations :</h4>
					<div >
					<p>Le Chiffre d'affaire (CA) de notre société est de :<strong> <?php echo number_format($chiffre_affaire,2,",",".");?>&euro;</strong></p>
				</div>
				</div>
				 <div class="clear"></div>
				<?php $html=''; ?>
				<?php 
					if (is_array($detail)){
						$html ='<table><thead><tr>
								<th>id_commande</th>
								<th>Montant</th>
								<th>Date</th>
								<th>id_membre</th>
								<th>Pseudo</th>
								<th>id_produit</th>
								<th>id_salle</th>
								<th>Ville</th>
								
							</tr>
						</thead>

						<tbody>';
						foreach ($detail as $key => $value){
							$date = new Datetime($value->date);
							
							$html .='<tr>';
							$html .='<td>'.$value->id_commande.'</td>';

							$html .='<td>'.number_format($value->prix,2,",",".").'&euro;</td>';
							$html .='<td>'.$date->format('d/m/y').'</td>';
							$html .='<td>'.$value->id_membre.'</td>';
							$html .='<td>'.$value->pseudo.'</td>';
							$html .='<td>'.$value->id_produit.'</td>';
							$html .='<td>'.$value->id_salle.'</td>';
							$html .='<td>'.$value->ville.'</td>';
								
							$html .='</tr>';
						}
					$html .='</tbody></table>';
				 }?>
				<?php echo $html; ?>
				
			
			</div>
			<div class="header-bottom"><p>SUIVEZ NOUS</p></div>
		</div>

		
	</div>
</div>
