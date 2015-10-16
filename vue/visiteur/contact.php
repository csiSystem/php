<div class="main">
    <div class="wrap">
  		<div class="content-bottom">
			<div class="titre">
			<p>Contacter LOKISALLE</p></div>
			     
			<div class="data">
				<div class="col_1_of_login span_1_of_login">
					<h4 class="title">Créer un compte</h4>
					<h5 class="sub_title">Créer un compte</h5>
					<p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat. Ut wisi enim ad minim veniam, quis nostrud exerci tation ullamcorper suscipit lobortis nisl ut aliquip ex ea commodo consequat. Duis autem vel eum iriure dolor in hendrerit in vulputate velit esse molestie consequat, vel illum dolore eu feugiat nulla facilisis at vero eros et accumsan</p>
					<div class="button1">
					   <a href="<?php echo Router::url("Visiteur/inscription"); ?>"><input type="submit" name="Submit" value="Continue"></a>
					 </div>
					 <div class="clear"></div>
				</div>
				<div class="col_1_of_login span_1_of_login">
				  <div class="login-title">
	           		<h4 class="title">Contacter LOKISALLE</h4>
					 <div class="comments-area">
						<form action="<?php echo Router::url('connection/login')?>" method="post">
							
							<?php echo $this->Form->input('sender','Expéditeur<span>* votre adresse mail<span>',array('type'=>'email','required'=>true));?>
							<?php echo $this->Form->input('subject','Sujet<span>*<span>',array('required'=>true));?>
							<?php echo $this->Form->input('message','Votre message<span>*<span>', array('type'=>'textarea','required'=>true));?>
							
							
							<p>
								<input type="submit" class="btn primary" value="Envoyer">
							</p>
					</form>
					</div>
			      </div>
				</div>
				<div class="clear"></div>
			
			</div>

			
		</div>
