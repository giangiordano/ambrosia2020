<?php ( $this->isLog() ? '' : $this->redirect('?login') );

$this->Vista("null");

if( isset($_GET['getMateria']) ) {

    $resultado = $this->getMateria( $_GET );
    echo json_encode( $resultado );

}

if( isset($_GET['add_proveedor']) ) {

    $resultado = $this->addProveedor( $_POST );
    if( $resultado['insert'] == 1 ) {

        $data = $this->getProveedores();
        $this->proveedor = '<option value=""></option>';
        for ($i=0; $i < count($data); $i++) { $this->proveedor .= '<option value="'.$data[$i]['clave'].'">'.$data[$i]['nombre'].'</option>'; }

        echo json_encode( array('mensaje' => 'Proveedor agregado con Exito!', 
                                'insert' => true, 
                                'tipo' => 'success', 
                                'titulo' => 'Exito',
                                'proveedores' => $this->proveedor ));

    } else {

        echo json_encode( array('mensaje' => ($resultado['mysql']['code'] == 1062 ? 'El proveedor ya existe' : $resultado['mysql']['message']),
                                'insert' => false,
                                'tipo' => 'error', 
                                'titulo' => 'Error' ));
    }

}

if( isset($_GET['add_materia']) ) {

    $resultado = $this->addMateria( $_POST );
    if( $resultado['insert'] == 1 ) {

        echo json_encode( array('mensaje' => 'Materia prima agregada con Exito!', 
                                'insert' => true, 
                                'tipo' => 'success', 
                                'titulo' => 'Exito' ));

    } else {

        echo json_encode( array('mensaje' => ($resultado['mysql']['code'] == 1062 ? 'Codigo barra duplicado' : $resultado['mysql']['message']), 
                                'insert' => false,
                                'tipo' => 'error', 
                                'titulo' => 'Error' ));
    }

}

if( isset($_GET['materia_estado']) ) {

    $resultado = $this->setMateriaEstado( $_POST );
    if( $resultado['insert'] == 1 ) {

        echo json_encode( array('mensaje' => 'Estado materia prima modificado con exito!', 
                                'insert' => true, 
                                'tipo' => 'success', 
                                'titulo' => 'Exito' ));

    } else {

        echo json_encode( array('mensaje' => ($resultado['mysql']['code'] == 1452 ? 'Estado invalido, revisar parametros' : $resultado['mysql']['message']),
                                'insert' => false,
                                'tipo' => 'error', 
                                'titulo' => 'Error' ));
    }

}

if( isset($_GET['tabla_materias']) ) {

    $aColumns = array( 'MP.nombre', 'MPI.marca', 'MPI.lote_proveedor as lote', 'DATE_FORMAT(MPI.fecha_ingreso, "%d/%m/%Y") as fecha_ingreso', 'DATE_FORMAT(fecha_vencimiento, "%d/%m/%Y") as fecha_vencimiento', 'P.nombre as proveedor', 'E.descripcion as estado', 'MPI.id_materia_prima_ingresada as clave' );
    $aColumnsName = array( 'nombre', 'marca', 'lote', 'fecha_ingreso', 'fecha_vencimiento', 'proveedor', 'estado', 'clave');
    $aColumnsSearch = array( 'MP.nombre', 'MPI.marca', 'MPI.lote_proveedor', 'P.nombre' );
        
    /* Indexed column (used for fast and accurate table cardinality) */
    $sIndexColumn = "MPI.fecha_ingreso";
        
    /* DB table to use */
    $sTable = " materia_prima_ingresada MPI
                JOIN materia_prima MP 
                    ON (MPI.materia_prima_idmateria_prima = MP.idmateria_prima)
                JOIN proveedor P 
                    ON (MPI.proveedor_idproveedor = P.idproveedor)
                JOIN estado_materia_prima E 
                    ON (MPI.estado_materia_prima_idestado_materia_prima = E.idestado_materia_prima)
                JOIN perfil F 
                    ON (MPI.perfil_idperfil = F.idperfil)
                JOIN persona PE 
                    ON (F.persona_idpersona = PE.idpersona) ";
       /*
        * Paging
        */
    $sLimit = "";
    if ( isset( $_GET['iDisplayStart'] ) && $_GET['iDisplayLength'] != '-1' ) {
        $sLimit = "LIMIT ".intval( $_GET['iDisplayStart'] ).", ".
        intval( $_GET['iDisplayLength'] );
    }
        
    /*
        * Ordering
        */
    $sOrder = "ORDER BY {$sIndexColumn} DESC";

    /*
        * Filtering
        */
    $sWhere = "WHERE MPI.estado_materia_prima_idestado_materia_prima != 3 "; // Materias primas terminadas
    if ( isset($_GET['sSearch']) && $_GET['sSearch'] != "" ) {

        $sWhere .= " AND (";
        for ( $i=0 ; $i < count($aColumnsSearch) ; $i++ )
        {
            if ( isset($_GET['bSearchable_'.$i]) && $_GET['bSearchable_'.$i] == "true" ) {
                $sWhere .= $aColumnsSearch[$i]." LIKE '%".$_GET['sSearch']."%' OR ";
            }
        }
        $sWhere = substr_replace( $sWhere, "", -3 );
        $sWhere .= ')';

    }
        
    /* Individual column filtering */
    for ( $i=0 ; $i<count($aColumnsSearch) ; $i++ )
    {
        if ( isset($_GET['bSearchable_'.$i]) && $_GET['bSearchable_'.$i] == "true" && $_GET['sSearch_'.$i] != '' )
        {
            if ( $sWhere == "" )
            {
                $sWhere = "WHERE ";
            }
            else
            {
                $sWhere .= " AND ";
            }
            $sWhere .= $aColumnsSearch[$i]." LIKE '%".$_GET['sSearch_'.$i]."%' ";
        }
    }
        

    /*
        * SQL queries
        * Get data to display
        */
    $sQuery = "
        SELECT SQL_CALC_FOUND_ROWS ".str_replace(" , ", " ", implode(", ", $aColumns))."
        FROM   $sTable
        $sWhere
        $sOrder
        $sLimit
    ";
    // echo $sQuery;
    $rResult = $this->conexion->query($sQuery);
        
    /* Data set length after filtering */
    $sQuery = "
        SELECT FOUND_ROWS()
    ";
    $rResultFilterTotal = $this->conexion->query($sQuery);
    $aResultFilterTotal = mysqli_fetch_array($rResultFilterTotal);
    $iFilteredTotal = $aResultFilterTotal[0];
        
    /* Total data set length */
    $sQuery = "

        SELECT COUNT(*) FROM $sTable $sWhere

    ";
    $rResultTotal = $this->conexion->query($sQuery);
    $aResultTotal = mysqli_fetch_array($rResultTotal);
    $iTotal = $aResultTotal[0];
        
        
    /*
        * Output
        */
    $output = array(
        "sEcho" => intval($_GET['sEcho']),
        "iTotalRecords" => $iTotal,
        "iTotalDisplayRecords" => $iFilteredTotal,
        "aaData" => array()
    );
        
    while ( $aRow = mysqli_fetch_array( $rResult ) )
    {
        $row = array();
        for ( $i=0 ; $i<count($aColumnsName) ; $i++ )
        {
            if ( $aColumnsName[$i] == "version" )
            {
                /* Special output formatting for 'version' column */
                $row[] = ($aRow[ $aColumnsName[$i] ]=="0") ? '-' : $aRow[ $aColumnsName[$i] ];
            }
            else if ( $aColumnsName[$i] != ' ' )
            {
                /* General output */
                $row[] = $aRow[ $aColumnsName[$i] ];
            }
        }
        $output['aaData'][] = $row;
    }
        
    echo json_encode( $output );

 }