<?php ( $this->isLog() ? '' : $this->redirect('?login') );

	#***************************************************************************
	# INICIO -> Configuraciones del modulo
	#***************************************************************************

	$this->Vista("view_inicio");
	$this->titulo_modulo   = "Inicio";
	$this->modulo_anterior = null;
	$this->titulo_anterior = 'Dashboard';

	#***************************************************************************
	# INICIO -> START
	#***************************************************************************

