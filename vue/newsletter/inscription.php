
<div class="main">
    <div class="wrap">
  		<div class="content-bottom">
			<div class="titre">
			<p>INSCRIPTION A LA NEWSLETTER</p></div>
			    
			<div class="data">
			
				<div class="col_1_of_2 span_1_of_21">
					<div>
					<h1>Inscrition à la Newsletter </h1>
				</div>
				<div class="clear"></div>
				<p>Vos informations : </p> 
				<?php 
				//debug($_SESSION['User']);
				echo '<h3><p>Nom : '.$this->Session->user('nom').'</p><p>Email : '.$_SESSION['User']->email.'</p></h3>';
				echo '<div>
						<p><a href="'.Router::url('admin/membre/edit/'.$_SESSION['User']->id_membre).'">Modifier vos informations &larr;</a></p>
					</div>
					';
				//debug($inscrit);
				if (!isset($inscrit)) {
					
					$html = '<div><form action="'.Router::url('newsletter/inscription').'" method="post">';
					$html .= $this->Form->input('id_newsletter','hidden');
					$html .= $this->Form->input('id_membre','hidden', array('value'=>$_SESSION['User']->id_membre));
					$html .= '<div class="actions">
							<input type="submit" class="btn primary" value="inscrivez-vous">
						</div>';
					$html .= '</form></div>';
					echo $html;
				}?>
				</div>
				<div class="col_1_of_2 span_1_of_21">
					<?php 
					if (isset($inscrit)) {
						echo '<p>vous êtes déjà inscription à la newsletter</p>';
					}
					
					?>

					<div>
					<?php
						$url=Router::url('Membre/index');
						if ($_SESSION['User']->statut == 1) {
							$url=Router::url('admin/membre/index');
						}
					?>
					<p><a href="<?php echo $url; ?>">retour &larr;</a></p>
					</div>	
				</div>
				
			<div class="clear"></div>
			</div>

			</div>
			<div class="clear"></div>
		</div>

		
	</div>
</div>
