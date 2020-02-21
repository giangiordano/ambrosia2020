<?php ( $this->isLog() ? '' : $this->redirect('?login') );

	#***************************************************************************
	# Produccion -> Configuraciones del modulo
	#***************************************************************************

	$this->Vista("view_produccion");
	$this->titulo_modulo   = "Lotes y Materias";
	$this->modulo_anterior = null;
	$this->titulo_anterior = 'Producción';

	#***************************************************************************
	# Produccion -> START
	#***************************************************************************


	$data = $this->getProducto();
	$this->producto_descripcion = '<option value=""></option>';
	for ($i=0; $i < count($data); $i++) { $this->producto_descripcion .= '<option value="'.$data[$i]['clave'].'">'.$data[$i]['nombre'].'</option>'; }

	// Fecha de posible vencimiento del producto
	$date = new DateTime();
	$date->add(new DateInterval('P45D'));
	$this->vencimiento = $date->format('d/m/Y') . "\n";

