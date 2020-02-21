<?php ( $this->isLog() ? '' : $this->redirect('?login') );


	#***************************************************************************
	# clientes -> Configuraciones del modulo
	#***************************************************************************

	$this->Vista("view_nuevo_cliente");
	$this->titulo_modulo   = "Nuevo Cliente";
	$this->modulo_anterior = null;
	$this->titulo_anterior = 'Clientes';

	#***************************************************************************
	# Departamentos
    #***************************************************************************

	$data = $this->getDepartamentos();
	$this->departamento = '<option value=""></option>';
	for ($i=0; $i < count($data); $i++) { $this->departamento .= '<option value="'.$data[$i]['clave'].'">'.$data[$i]['nombre'].'</option>'; }
	
