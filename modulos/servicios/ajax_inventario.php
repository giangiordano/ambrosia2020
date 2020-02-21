<?php ( $this->isLog() ? '' : $this->redirect('?login') );

$this->Vista("null");

if( isset($_GET['add_product']) ) { 

    $resultado = $this->addProduct( $_POST );
    if( $resultado['insert'] ) {

        echo json_encode( array('mensaje' => 'Producto agregado con Exito!', 
                                'insert' => $resultado['insert'], 
                                'tipo' => 'success', 
                                'titulo' => 'Exito') );

    } else {

        echo json_encode( array('mensaje' => 'No se pudo actualizar el inventario, contacte a Soporte', 
                                'insert' => $resultado['insert'], 
                                'tipo' => 'error', 
                                'titulo' => 'Error') );
    }

 }

 if( isset($_GET['tabla_inventario']) ) {

 $aColumns = array( 'DP.descripcion', 'P.lote', 'COUNT( EP.idestado_producto ) as cantidad', 'P.fecha_ingreso', 'P.fecha_vencimiento' );
    $aColumnsName = array( 'descripcion', 'lote', 'cantidad', 'fecha_ingreso', 'fecha_vencimiento');
    $aColumnsSearch = array( 'DP.descripcion', 'P.lote' );
        
    /* Indexed column (used for fast and accurate table cardinality) */
    $sIndexColumn = "P.fecha_ingreso";
        
    /* DB table to use */
    $sTable = " producto P JOIN descripcion_producto DP 
                    ON (P.descripcion_producto_iddescripcion_producto = DP.iddescripcion_producto) 
                JOIN almacen A 
                    ON (P.almacen_idalmacen = A.idalmacen) 
                JOIN estado_producto EP 
                    ON (EP.idestado_producto = P.estado_producto_idestado_producto)
                GROUP BY P.lote, P.fecha_ingreso, P.fecha_vencimiento, DP.descripcion ";
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
    $sOrder = "ORDER BY {$sIndexColumn} ASC";

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