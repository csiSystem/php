<?php
if($this->request->prefix == 'admin'){
	$this->layout = 'admin';
	if (!$this->Session->isLogged() || $this->Session->user('statut') != 1){
		$this->redirect('connection/login');
	}
}

?>