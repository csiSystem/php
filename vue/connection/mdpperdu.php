
<div class="main">
    <div class="wrap">
  		<div class="content-bottom">
			<div class="titre">
			<p>ZONE RESERVEE</p></div>
			     
			<div class="data">
				<div class="col_1_of_login span_1_of_login">
					<h4 class="title">Créer un compte</h4>
					<h5 class="sub_title">Créer un compte</h5>
					<p>Lorem ipsum dolor sit amet, consectetuer adipiscing elit, sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat. Ut wisi enim ad minim veniam, quis nostrud exerci tation ullamcorper suscipit lobortis nisl ut aliquip ex ea commodo consequat. Duis autem vel eum iriure dolor in hendrerit in vulputate velit esse molestie consequat, vel illum dolore eu feugiat nulla facilisis at vero eros et accumsan</p>
					<div class="button1">
					   <a href="register.html"><input type="submit" name="Submit" value="Continue"></a>
					 </div>
					 <div class="clear"></div>
				</div>
				<div class="col_1_of_login span_1_of_login">
				  <div class="login-title">
	           		<h4 class="title">Mod de passe oublié</h4>
					 <div class="comments-area">
						<form action="<?php echo Router::url('connection/mdpperdu')?>" method="post">
							<h4>
								Afin de pouvoir réinitialiser votre mot-de-passe, vous devez nous fournir votre adresse.	
							</h4>
							<p>
							<?php echo $this->Form->input('email','Email<span>*<span>',array('type'=>'email','required'=>true));?>
							</p>
							<!--p>
							<?php echo $this->Form->input('mdp','Mode de passe<span>*<span>',array('type'=>'password','required'=>true));?>
							</p-->
							<p id="login-form-remember">
								<label><a href="<?php echo Router::url("Visiteur/login"); ?>">Revenir à la connexion ? </a></label>
							 </p>
							<p>
								<input type="submit" class="btn primary" value="Se connecter">
							</p>
					</form>
					</div>
			      </div>
				</div>
				<div class="clear"></div>
			
			</div>

			
		</div>

		
	</div>
</div>
