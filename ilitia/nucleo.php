<?php

# CLASE: NUCLEO DE ILITIA V1.0
# AUTOR: GIANFRANCO GIORDANO
# FECHA: 25 / 12 / 2016

class Nucleo
{

	var $somosclick;

	#=====================================================================
	#							funcion Set
	#=====================================================================

	function set($key,$value)
	{
		$somosclick[$key] = $value;
	}

	#=====================================================================
	#							funcion Get
	#=====================================================================

	function get($key)
	{
		return $somosclick[$key];
	}

	#=====================================================================
	#				funcion ver: carga modulo y vista
	#=====================================================================

	public function ver($args)
	{
		$this->cargarModulo();
		
		if(isset($this->vista) AND $this->vista == "null")
		{
			$this->Vista();

		}else{

			include(ESTRUCTURA);
		}

	}

	#=====================================================================
	#				cargarModulo: define el modulo del sistema
	#=====================================================================

	public function cargarModulo()
	{
		
		$flag = false;
		$keys = array_keys($_GET);
		$vals = array_values($_GET);

		if( count($_GET) > 0 )
		{
			$indice = $keys[0];
			if(is_file(MODULOS.$indice.'.php'))
			{
				define("MODULO",$indice);
				include(MODULOS.$indice.'.php');
				$flag = true;
				unset($_GET[$indice]);

			}elseif(is_file('veflat/'.MODULOS.$indice.'.php')){

				define("MODULO",$indice);
				include(MODULOS.$indice.'.php');
				$flag = true;
				unset($_GET[$indice]);
			}

		}elseif(count($_GET) == 0){

			if( NEED_LOGIN == true ) {

				if( $this->isLog() ){

					define("MODULO","inicio");
					$flag = true;
					include( INDEX_MODULO );

				}else{

					define("MODULO","login");
					$flag = true;
					include( LOGIN );

				}

			} else {

				define("MODULO","login");
				$flag = true;
				include( INDEX_MODULO );
			}
		}

		if(!$flag) {
			
			define("MODULO","404");
			include(MODULOS.'404.php');
		}
	}

	#=====================================================================
	#				Vista: define la Vista del sistema
	#=====================================================================

	public function Vista( $arg = "" ) {

		if ( $arg != "" ) {

			$this->vista = $arg;

		} elseif ( isset($this->vista) ) {

			if( is_file(VISTAS.$this->vista.'.php') ) {

				include(VISTAS.$this->vista.'.php');

			} else { echo "Error al cargar la vista establecida, el archivo no existe."; }

		} else {

			if(is_file(VISTAS.MODULO.'.php')) {

				if(is_file(VISTAS.MODULO.'.php')) {

					include(VISTAS.MODULO.'.php');

				} else { echo "Error al cargar la vista(default), el archivo no existe."; }

			} else { echo "Error al cargar vista, defina en el modulo: \$this->Vista(\"file\") en ".MODULO; }
		}
	}
}
