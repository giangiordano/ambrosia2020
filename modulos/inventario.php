<?php ( $this->isLog() ? '' : $this->redirect('?login') );


	#***************************************************************************
	# Inventario -> Configuraciones del modulo
	#***************************************************************************

	$this->Vista("view_inventario");
	$this->titulo_modulo   = "Inventario";
	$this->modulo_anterior = null;
	$this->titulo_anterior = 'Bodega';

	#***************************************************************************
	# Inventario -> START
	#***************************************************************************

	$data = $this->getProductos();
	$this->productos = '<option value=""></option>';
	for ($i=0; $i < count($data); $i++) { $this->productos .= '<option value="'.$data[$i]['clave'].'">'.$data[$i]['nombre'].'</option>'; }
	

