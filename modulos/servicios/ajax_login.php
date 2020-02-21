<?php $this->Vista('null');

$mensaje = '';

if( isset($_POST['username']) && isset($_POST['pw']) ) {

	if( $this->login( $_POST['username'], $_POST['pw'] )) {

		$mensaje = array('msn' => 'Bienvenido '.$this->sessionGet('nombres')." ".$this->sessionGet('apellidos'), 
						'sesion' => true, 
						'redirect' => '?inicio');

	} else { 
		
		$mensaje = array('msn' => 'Contraseña o Usuario Incorrecto', 
						'sesion' => false );
	}

	echo json_encode( $mensaje );
}

