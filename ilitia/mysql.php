<?php

class Mysql extends Nucleo {

	public $conexion;
	public $id_insertado;
	public $mysql_error;
	public $omitirEnBlanco;

#==============================================================================
#						Conexion a la base de datos
#==============================================================================

	function conexion( $SERVER = NULL, $USER = NULL, $PW = NULL, $DB = NULL ) {

		$this->conexion = new mysqli( ($SERVER!=NULL?$SERVER:MySQL_S), ($USER!=NULL?$USER:MySQL_U), ($PW!=NULL?$PW:MySQL_P) );
		if( $this->conexion->connect_error ) {

			exit('Error conectando a la base de datos!');

		} else {

			mysqli_report( MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT );
			$this->conexion->select_db(( $DB != NULL ?  $DB : MySQL_DB ));
			$this->conexion->set_charset('utf8');

		}
	}

	function execInsert( $data, $values, $table ) {

		$val      = '( ';
		$datos    = '( ';
		$dataType = '';

		for ($i=0; $i < count($values); $i++) {

			$val .= $values[$i] . ', ';
			if($data[$i][1] === 'NULL') {  $datos .= 'NULL, '; }
			else {
				$datos      .= '?, '; 
				$dataType   .= $data[$i][1];
				$valores[$i] = $data[$i][0];
			}

		}

		$val    = trim($val, ', ');
		$datos  = trim($datos, ', ');
		$val    = $val . ' )';
		$datos .= ' )';
		$qry = "INSERT INTO {$table} {$val} VALUES {$datos}";
		return $this->execPrepare( $qry, $dataType, $valores );

	}

	function execPrepare( $qry, $dataType, $valores ) {

		$error = '';
		$resultado = '';
		try {

			$stmt = $this->conexion->prepare( $qry );
			$stmt->bind_param( $dataType,...$valores );
			$resultado = $stmt->execute();
			$stmt->close();

		} catch ( mysqli_sql_exception $e ) { $error = array('message' => $e->getMessage(), 'code' => $e->getCode() ); }

		if( $resultado ) { return array( 'insert' => true, 'mysql' => '' );
		} else { return array( 'insert' => false, 'mysql' => $error ); }

	}

	function execMysql( $qry ) {

		if( !$this->conexion->query( $qry ) ) {

			return array( 'insert' => false, 'mysql' => mysqli_error($this->conexion) );

		} else { return array( 'insert' => true, 'mysql' => $this->conexion->affected_rows ); }

	}

	function execPrepareTransaction( $qry, $bind_param ) {

		$error = '';
		$resultado = true;

		try {

			$this->conexion->autocommit( FALSE ); //turn on transactions

			for ($i=0; $i < count( $qry ); $i++) {
				
				$stmt[$i] = $this->conexion->prepare( $qry[$i]['sql'] );
				$stmt[$i]->bind_param($bind_param[$i]['type'],...$bind_param[$i]['data']);
			}

			for ($i=0; $i < count( $stmt ); $i++) { 
				$stmt[$i]->execute();
			}

			for ($i=0; $i < count( $stmt ); $i++) { 
				$stmt[$i]->close();
			}

			$this->conexion->autocommit( TRUE ); //turn off transactions + commit queued queries

		} catch ( mysqli_sql_exception $e ) {

			$resultado = false;
			$this->conexion->rollback();
			$error = array('message' => $e->getMessage(), 'code' => $e->getCode() ); 
		
		}

		if( $resultado ) { return array( 'insert' => true, 'mysql' => '' );
		} else { return array( 'insert' => false, 'mysql' => $error ); }
	}

	function execTransaction( $qry ) {

		$insertado = true;
		$this->conexion->begin_transaction();
		for ( $i=0; $i < count($qry); $i++ ) {
			if( !$this->conexion->query( $qry[$i]['sql'] ) ) {
				$insertado = false;
			}
		}

		if( $insertado ) { 

			$this->conexion->commit(); 
		 	return array( 'insert' => $insertado, 'mysql' => $this->conexion->affected_rows );

		} else { 

			$this->conexion->rollback();
		 	return array( 'insert' => $insertado, 'mysql' => mysqli_error($this->conexion) );
		}

	}

	function getPrepareData( $qry, $dataType, $valores, $allField = false ) {

		$stmt = $this->conexion->prepare( $qry );
		$stmt->bind_param($dataType,...$valores);
		$stmt->execute();

		if ( $result = $stmt->get_result() ) {

			if($result->num_rows > 0) {

				$akey = 0;
				while($row = ($allField?$result->fetch_assoc():$result->fetch_row())) {
					$keys = array_keys($row);
					if($allField){
						$index = $akey++;
					} else {

						if(isset($row[$keys[0]]))
							$index = $row[$keys[0]];
						//unset($row[0]);
					}

					if ( $allField ) {
						foreach ($row as $key => $value) {
							$rec[$key] = $value;
						}
					}else { $rec = $row[1]; }
					$data[$index] = $rec;
				}
			} else { return false; }
		    $stmt->close();
		} else {
			error_log('['.$this->hora().']['.$this->getIp().']['.MODULO.' getData]:'.$qry.'['.$this->conexion->error.']'."", 3, MYSQL_LOG);
			return false;
		}
		return $data;
	}

	function getData( $qry, $allField = false ) {

		if ($result = $this->conexion->query($qry))
		{

			if($result->num_rows > 0)
			{
				$akey = 0;
				while($row = ($allField?$result->fetch_assoc():$result->fetch_row()))
				{
					$keys = array_keys($row);
					if($allField){
						$index = $akey++;
					}else{
						if(isset($row[$keys[0]]))
							$index = $row[$keys[0]];
						//unset($row[0]);
					}

					if($allField)
					{
						foreach ($row as $key => $value) {
							$rec[$key] = $value;
						}
					}else
					{
						$rec = $row[1];
					}
					$data[$index] = $rec;
				}
			}else
			{
				return false;
			}
		    $result->close();
		}else
		{
			error_log('['.$this->hora().']['.$this->getIp().']['.MODULO.' getData]:'.$qry.'['.$this->conexion->error.']'."", 3, MYSQL_LOG);
			return false;
		}
		return $data;
	}

	// Funciones del sistema

	function login( $username, $pw ) {

		$pw = md5(SECURITY_SALT . $pw);
		$valores = array( $username, $pw );
		$sql = "SELECT * FROM
				persona P 
				JOIN perfil F ON (P.idpersona = F.persona_idpersona)
				JOIN rol R ON (R.idrol = F.rol_idrol)
				WHERE F.usuario = ? AND F.password = ?
				LIMIT 1 ";
		$dataType = 'ss';

		if( $user = $this->getPrepareData( $sql, $dataType, $valores, true ) ) {

			$this->sessionNew( $user );
			$sql = "UPDATE perfil SET last_sing = DATE(NOW()), ip_last_sing = '". $this->getIp() ."' WHERE idperfil = ". $this->sessionGet('idperfil');

			if( $this->conexion->query($sql) === TRUE ) {
				return true;

			} else {

				error_log('['.$this->hora().']['.MODULO.' login]:'.$sql.'['.$this->conexion->error.']', 3, CORE_LOG);
				return false;
			}

		} else {

			return false;
		}
	}

	function nuevoCliente( $cliente ) {

		if( $cliente['crsfkey'] === $this->sessionGet('crsfkey') ) {
			
			$sql[0]['sql'] = "INSERT INTO `persona` (`idpersona`, `nombres`, `apellidos`, `documento`, `email`, `telefono`, `direccion`, `municipio_idmunicipio`) VALUES (NULL, ?, ?, ?, ?, ?, ?, ?)";
			$sql[1]['sql'] = "INSERT INTO `cliente` (`idclientes`, `credito`, `avatar`, `idtokencliente`, `persona_idpersona`, `latitude`, `longitude`, `accuracy`) VALUES (NULL, '0', '/img/avatar/default.png', ?, LAST_INSERT_ID(), ?, ?, ?)";

			$crsfkey = md5( $this->getIp().time().$cliente['nombres'] );
			$data1 = array ($cliente['nombres'], $cliente['apellidos'], $cliente['documento'], $cliente['email'], $cliente['telefono'], $cliente['direccion'], $cliente['municipio']);
			$data2  = array( $crsfkey, $cliente['latitude'], $cliente['longitude'], $cliente['accurency'] );

			$bind_param = array(array( 'type' => 'ssssssi', 'data' => $data1 ),
								array( 'type' => 'ssss', 'data' => $data2 ));

			return $this->execPrepareTransaction( $sql, $bind_param );

		} else { return array( 'tokenValid:' => false, 'sms' => 'Token Invalido' ); }
	}

	function getMunicipios( $id_departamento ) {

		$sql = "SELECT idMunicipio as clave, municipio as nombre 
				FROM `municipio` 
				WHERE departamento_idDepartamento = ?";
		$valores = array( $id_departamento );
		$dataType = 'i';

		return $this->getPrepareData( $sql, $dataType, $valores, true );
	}

	function getDepartamentos() {

		$sql = "SELECT idDepartamento as clave, departamento as nombre 
				FROM `departamento` ";
		return $this->getData($sql, true);
	}

	function getProductos() {

		$sql = "SELECT iddescripcion_producto as clave, descripcion as nombre 
				FROM `descripcion_producto`";
		return $this->getData($sql, true);
	}

	function getProveedores() {

		$sql = "SELECT idproveedor as clave, nombre 
				FROM `proveedor` ORDER BY nombre ASC";
		return $this->getData($sql, true);
	}

	function getMateriaPrima() {
		
		$sql = "SELECT idmateria_prima as clave, nombre FROM `materia_prima` ORDER BY nombre ASC";
		return $this->getData($sql, true);

	}

	function getMateria( $id ) {

		$sql = "SELECT id_materia_prima_ingresada, marca, lote_proveedor, fecha_ingreso, fecha_vencimiento, tipo_presentacion, codigobarra, 
		PS.nombres, PS.apellidos, PS.telefono as 'tlfEncargado', PR.avatar as 'avatar', P.nombre as 'proveedor', P.direccion as 'proveedorDireccion', 
		P.telefono as 'telefonoProveedor', P.NIT as 'NITProveedor', MP.nombre as 'materiaPrima', EM.idestado_materia_prima as 'id_estado', EM.descripcion as 'estado'
		FROM materia_prima_ingresada MPI 
		JOIN proveedor P 
			ON ( P.idproveedor = MPI.proveedor_idproveedor ) 
		JOIN materia_prima MP 
			ON ( MP.idmateria_prima = MPI.materia_prima_idmateria_prima ) 
		JOIN estado_materia_prima EM 
			ON ( EM.idestado_materia_prima = MPI.estado_materia_prima_idestado_materia_prima ) 
		JOIN perfil PR 
			ON ( PR.idperfil = MPI.perfil_idperfil ) 
		JOIN persona PS 
			ON (PR.persona_idpersona = PS.idpersona) 
		WHERE MPI.id_materia_prima_ingresada = ?";

		$valores = array( $id['id_materia'] );
		$dataType = 'i';

		return $this->getPrepareData( $sql, $dataType, $valores, true );

	}

	function addMateria( $materia ) {

		if( $materia['crsfkey'] === $this->sessionGet('crsfkey') ) {

			$sessionId = $this->sessionGet('idperfil');
			$estado_materia_prima = 1;
			$ven = explode( '/', $materia['vencimiento'] );
			$vencimiento = $ven[2].'-'.$ven[1].'-'.$ven[0];

			

			$data = array(

						array(0, 'NULL'), array($materia['marca'], 's'), array($materia['lote'], 's'),
						array( $date, 's'), array( $vencimiento, 's'), array( $materia['cantidad'].$materia['tipo_gramos'], 's'),
						array( $materia['codigo'], 's'), array( $sessionId, 'i'), array( $materia['proveedor'], 'i'), 
						array( $materia['materia_prima'], 'i'), array( $estado_materia_prima, 'i'),
				);

			$values = array(
							'id_materia_prima_ingresada', 'marca', 'lote_proveedor', 
							'fecha_ingreso', 'fecha_vencimiento', 'tipo_presentacion', 
							'codigobarra', 'perfil_idperfil', 'proveedor_idproveedor', 
							'materia_prima_idmateria_prima', 'estado_materia_prima_idestado_materia_prima'
					);


			$table = 'materia_prima_ingresada';

			return $this->execInsert($data, $values, $table);

		} else { return array( 'tokenValid:' => false, 'sms' => 'Token Invalido' ); }

	}

	function setMateriaEstado( $estado ) {

		$sql = "UPDATE materia_prima_ingresada 
				SET estado_materia_prima_idestado_materia_prima = ? 
				WHERE materia_prima_ingresada.id_materia_prima_ingresada = ?";

		$valores = array( $estado['idestado'], $estado['idmateria'] );
		$dataType = 'ii';

		return $this->execPrepare( $sql, $dataType, $valores );

	}

	function addProveedor( $proveedor ) {

		if( $proveedor['crsfkey'] === $this->sessionGet('crsfkey') ) {

			$data = array(  array( 0, 'NULL' ),
							array( $proveedor['nombre'], 's' ),
							array( $proveedor['direccion'], 's' ),
							array( $proveedor['telefono'], 's' ), 
							array( $proveedor['nit'], 's' ) );
	
			$values = array( 'idproveedor', 'nombre', 'direccion', 'telefono', 'NIT' );
			$table = 'proveedor';
	
			return $this->execInsert( $data, $values, $table );

		} else { return array( 'tokenValid:' => false, 'sms' => 'Token Invalido' ); }
		
	}

	function getProducto() {

		$sql = "SELECT iddescripcion_producto as clave, descripcion as nombre FROM `descripcion_producto` ";
		return $this->getData($sql, true);

	}

	function addLote( $lote ) {

		if( $lote['crsfkey'] === $this->sessionGet('crsfkey') ) {

			$sessionId = $this->sessionGet('idperfil');
			$date = date('Y-m-d');
			$explode = explode( '/', $lote['vencimiento'] );
			$vencimiento = $explode[2].'-'.$explode[1].'-'.$explode[0];

			$data = array(
						array($lote['lote'], 's'), array($lote['materia_prima'], 's'), array($date, 's'),
						array($vencimiento, 's'), array('1', 'i'), array($sessionId, 'i')
				);

			$values = array( 
							'idlote', 'iddescripcion_producto', 'fecha_creacion', 
							'fecha_vencimiento', 'estado_lote_idestado_lote', 'perfil_idperfil' 
					);

			$table = 'lote';

			return $this->execInsert($data, $values, $table);

		} else { return array( 'tokenValid:' => false, 'sms' => 'Token Invalido' ); }

	}

	function buscarMateria( $barra ) {

		$sql = "SELECT * 
				FROM materia_prima_ingresada 
				WHERE codigobarra = ? 
				LIMIT 1";
		$valores = array( $barra['codigo'] );
		$dataType = 's';

		return $this->getPrepareData( $sql, $dataType, $valores, true );

	}

	function buscarIngredientes( $barra ) {

		$sql = "SELECT MPI.id_materia_prima_ingresada as clave, MP.nombre as nombre_ingrediente, marca, lote_proveedor, fecha_vencimiento, CONCAT(tipo_presentacion, unidad_medida) as presentacion, EMP.descripcion as estado
				FROM materia_prima_ingresada MPI 
				JOIN materia_prima MP 
					ON (MPI.materia_prima_idmateria_prima = MP.idmateria_prima)
				JOIN estado_materia_prima EMP 
					ON (EMP.idestado_materia_prima = MPI.estado_materia_prima_idestado_materia_prima)
				WHERE EMP.idestado_materia_prima = 2 AND MPI.codigobarra = ?";
		$valores = array( $barra['codigo'] );
		$dataType = 's';

		return $this->getPrepareData( $sql, $dataType, $valores, true );

	}

}

