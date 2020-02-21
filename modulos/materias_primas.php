<?php ( $this->isLog() ? '' : $this->redirect('?login') );

	#***************************************************************************
	# materias_primas -> Configuraciones del modulo
	#***************************************************************************

	$this->Vista("view_materias_primas");
	$this->titulo_modulo   = "Materias Primas";
	$this->modulo_anterior = null;
	$this->titulo_anterior = 'Producción';

	#***************************************************************************
	# materias_primas -> START
	#***************************************************************************

	$data = $this->getProveedores();
	$this->proveedor = '<option value=""></option>';
	for ($i=0; $i < count($data); $i++) { $this->proveedor .= '<option value="'.$data[$i]['clave'].'">'.$data[$i]['nombre'].'</option>'; }
	

	$data = $this->getMateriaPrima();
	$this->materia_prima = '<option value=""></option>';
	for ($i=0; $i < count($data); $i++) { $this->materia_prima .= '<option value="'.$data[$i]['clave'].'">'.$data[$i]['nombre'].'</option>'; }
	
