<?php
$tb_footer = array('inscritletter'=>array('25','login'),'mentions' => array('21','index'),
				'cgv'=>array('22','cvg'),
				'plan'=>array('23','plan'),
				'printpage'=>array('24','print'),
				
				'contact'=>array('26','contact'),

				);
$tb_language=array();
$tb_language['mentions'] = 'Mention légale';
$tb_language['plan'] = 'le plan du site';
$tb_language['cgv'] = 'Condition légal de vente';
$tb_language['printpage'] = 'Imprimer la page';
$tb_language['inscritletter'] = "S'inscrire à la newsletter";
$tb_language['contact'] = 'Contact';


?>
<div id="pied2page">
    <ul>
    	<?php foreach ($tb_footer as $key => $value): ?>
		<li id="<?php echo 'item'.$value[0];?>">
			<?php if ($key == 'printpage') {

				echo '<a href="#" onclick="window.print(); return false;" title="'.$tb_language[$key].'"><span>'.$tb_language[$key].'</span></a></li>';
			}else{
				
					//debug($_SESSION['User']);
				if (isset($_SESSION['User'])) {
					if ($key == 'inscritletter' || $key == 'contact'){
						if ( $key == 'contact'){
							echo '<a href="'.Router::url('Membre/'.$key).'" title="'.$tb_language[$key].'"><span>'.$tb_language[$key].'</span></a></li>';
						}
						if ($key == 'inscritletter'){
							echo '<a href="'.Router::url('newsletter/edit/'.$_SESSION['User']->id_membre).'" title="'.$tb_language[$key].'"><span>'.$tb_language[$key].'</span></a></li>';
						}

						
					}else{
						echo '<a href="'.Router::url('Visiteur/'.$key).'" title="'.$tb_language[$key].'"><span>'.$tb_language[$key].'</span></a></li>';
					}
				}else{
					echo '<a href="'.Router::url('Visiteur/'.$key).'" title="'.$tb_language[$key].'"><span>'.$tb_language[$key].'</span></a></li>';
				}
				
			}
			?>
			
		<?php endforeach ?>
	</ul>		
</div>