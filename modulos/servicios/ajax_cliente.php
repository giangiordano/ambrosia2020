<?php ( $this->isLog() ? '' : $this->redirect('?login') );

$this->Vista("null");


// Crear cliente nuevo
if ( isset($_GET['crear_cliente']) ) { 

    $resultado = $this->nuevoCliente( $_POST );
    if( $resultado['insert'] == 1 ) {

        echo json_encode( array('mensaje' => 'Cliente creado con exito!', 
                                'insert' => true, 
                                'tipo' => 'success', 
                                'titulo' => 'Exito' ));

    } else {

        echo json_encode( array('mensaje' => ($resultado['mysql']['code'] == 1062 ? 'Documento duplicado' : $resultado['mysql']['message']), 
                                'insert' => false,
                                'tipo' => 'error', 
                                'titulo' => 'Error' ));
    }

}

 // Actualizar cliente
if ( isset($_GET['actualizar_cliente']) ) {  }

// Eliminar cliente
if ( isset($_GET['eliminar_cliente']) ) {  }

// Todos los Clientes
if ( isset($_GET['tabla_cliente']) ) { 

    $aColumns = array( 'P.nombres', 'P.apellidos', 'P.documento', 'P.email', 'P.direccion', 'P.telefono', 'P.idpersona' );
    $aColumnsName = array( 'nombres', 'apellidos', 'documento', 'email', 'direccion', 'telefono', 'idpersona' );
    $aColumnsSearch = array( 'P.nombres', 'P.apellidos' );
        
    /* Indexed column (used for fast and accurate table cardinality) */
    $sIndexColumn = "nombres";
        
    /* DB table to use */
    $sTable = " cliente C JOIN persona P 
                ON (P.idpersona = C.persona_idpersona) ";
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
    $sOrder = "ORDER BY nombres DESC";

    /*
        * Filtering
        */
    $sWhere = " ";
    if ( isset($_GET['sSearch']) && $_GET['sSearch'] != "" ) {

        $sWhere .= " WHERE (";
        for ( $i=0 ; $i < count($aColumnsSearch) ; $i++ )
        {
            if ( isset($_GET['bSearchable_'.$i]) && $_GET['bSearchable_'.$i] == "true" )
            {
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
    //echo $sQuery;
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

