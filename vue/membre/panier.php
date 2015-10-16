<script type="text/javascript" src="<?php echo BASE_URL.'/webracine/js/sorttable.js';?>"></script>
<?php 
$tb_mois = array("Janvier","Février","Mars","Avril","Mai","Juin","Juillet","Août","Septembre","Octobre","Novembre","Décembre");
?>

<div class="main">
    <div class="wrap">
  		<div class="content-bottom">
			<div class="titre">
			<p>VOTRE PANIER </p></div>
			    
			<div class="data">
				
				<?php 
					$h = $this->Session->read('panier');
					//debug($h[6]);
				//debug($this);
				$tva=19.6;
				?>
				<table class="sorttable" >
					<thead>
						<tr>
							<th>Produit</th>
							<th>Salle</th>
							<th>Photo</th>
							<th>Ville</th>
							<th>Capacite</th>
							<th>Date arrivée</th>
							<th>Date départ</th>
							<th>Retraite</th>
							<th>Prix HT</th>
							<th>TVA</th>
						</tr>
					</thead>
					<tfoot >
							
							<td colspan="8">Prix Total TTC :</td>
							<td  colspan="2"><?php echo $montant;?> &euro;</td>
						</tfoot>
					<tbody>
						<?php foreach ($salle as $k => $value): ?>
							
							
							<tr>
								<td><?php echo $k ?></td>
								<td><?php echo $value->titre; ?></td>
								<!-- td><?php echo $value->photo; ?></td-->
								<!-- td width="50" background="<?php echo BASE_URL.'/webracine/images/logohotel1.jpg'?>" ></td -->
								<td><a href="<?php echo BASE_URL.'/Membre/reservation_details/'.$k?>">voir photo</a></td>
								<td><?php echo $value->ville; ?></td>
								<td><?php echo $value->capacite; ?></td>
								<td><?php $date = new Datetime($this->Session->read('panier')[$k]['date_arrivee']); 
								$a = $date->format('d/m/Y') ;
								$ladate = explode('/', $a)[0].' '.$tb_mois[intval(explode('/', $a)[1])-1].' '.explode('/', $a)[2];
								echo $ladate;
								?></td>
								<td><?php $date = new Datetime($this->Session->read('panier')[$k]['date_depart']); 
								$a = $date->format('d/m/Y') ;
								$ladate = explode('/', $a)[0].' '.$tb_mois[intval(explode('/', $a)[1])-1].' '.explode('/', $a)[2];
								echo $ladate;
								?></td>
								<td><a onclick="return confirm('voulez vous vraiment supprimer ce contenu?');" href="<?php echo Router::url('/Membre/supprime_panier/'.$k); ?>">x</a></td>
								<td><?php echo $this->Session->read('panier')[$k]['prix']; ?>&euro;</td>
								<td><?php echo "%".$tva; ?></td>
								
												
							</tr>
							
						<?php endforeach ?>
						
					</tbody>
						
								
					
				</table>
				<div class="col_1_of_2 span_1_of_21">
				<form action="<?php echo Router::url('Membre/panier_promo')?>" method="post">
					<div class="promo">
					<?php echo $this->Form->input('code_promo','Utiliser un code promo',array('required'=>true));?>
					</div>
					<div class="actions">
						<input type="submit" class="btn primary" value="Envoyer">
					</div>

				</form>

				
				</div>
				<div class="col_1_of_2 span_1_of_21">
				<form action="<?php echo Router::url('Membre/payer_panier')?>" method="post">
					
					<?php
					$url =  Router::url('Visiteur/cgv');
					echo $this->Form->input('payer','J\'acceptation les contions generales de vente(<a href="'.$url.'">Voir</a>)',array('type'=>'checkbox','required'=>true));?>
					<?php echo $this->Form->input('id_membre','hidden', array('value'=>$this->Session->read('User')->id_membre));?>
					<?php echo $this->Form->input('montant','hidden', array('value'=>$montant));?>
					<?php //"<a href=".$url.">Voir</a>" ?>
					<!-- a href="<?php echo Router::url('Visiteur/cgv'); ?>" class="primay btn">Voir</a -->
					<div class="actions">
						<input type="submit" class="btn primary" value="Payer">
					</div>
					<div>
					<p><br>
					<a href="<?php echo Router::url('Membre/supprime_panier'); ?>">Vider votre panier</a>
					</p>
				</div>
				
				</form>
				
					
				</div>
				<div class="col_1_of_2 span_1_of_21">
				<h4 class="sub_title">Informations :</h4>
					<div><p>Tous nos articles sont calculés avec le taux de TVA à 19,6%</p>
					<p>Règlement : Par chèque uniquement</p>
					<p>Nous attandons votre règlement par chèque à l'adresse suivant:<br>
					Ma boutique- 1 Rue Boswellia, 75000, paris France</p></div>
				</div>
				<!-- form>
				<input TYPE="button" onClick="window.print()" value="Imprimer">
				</form -->
			</div>
			
		</div>
		<div class="clear"></div>

		
	</div>
</div>
<!-- A HREF="javascript:window.print()">Click to Print This Page</A>
<scr LANGUAGE="JavaScript"> 
if (window.print) {
document.write('<form><input type=button name=print value="Print" onClick="window.print()"></form>');
}
move_uploaded_file
</script -->