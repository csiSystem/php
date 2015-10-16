


<div class="main">
    <div class="wrap">
  		<div class="content-bottom">
			<div class="titre">
			<p>MODIFIER VOS INFORMATIONS</p></div>
			    
			<div class="data">
				<?php 

				if (isset($id)){
					$html = '<div class="page-header">
					<h1>Inscrition à la Newsletter </h1>

				</div>
				';
					$html .= '<div><p>Vos informations</p> <form action="'.Router::url('newsletter/edit').'" method="post">';
					
					$html .= $this->Form->input('id_newsletter','hidden');
					$html .= $this->Form->input('id_membre','hidden', array('value'=>$id));
					
					$html .= '<table border="0" cellpadding="10" cellspacing="5" >';
					foreach ($mydata as $key => $value){
						$html .= '<tr> 
							      <td >'.$key.'
								</td>
							      <td >'.$value.'</td>
							    </tr>';	
					}
					$html .= '</table><div class="actions">
								<input type="submit" class="btn primary" value="Envoyer">
							</div>
							<div>
					
							<p><a href="'.Router::url('admin/membre/edit/'.$id).'">Modifier vos informations &larr;</a></p>
							</div>
						</form></div>';
					echo $html;
				}


				?>

				<div>
					
				<p><a href="<?php echo Router::url('admin/membre/index'); ?>">retour &larr;</a></p>
				</div>	
			
			</div>

			</div>
			<div class="header-bottom"><p>SUIVEZ NOUS</p></div>
		</div>

		
	</div>
</div>
