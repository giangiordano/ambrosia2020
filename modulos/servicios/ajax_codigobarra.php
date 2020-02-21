<?php ( $this->isLog() ? '' : $this->redirect('?login') );
$this->Vista("null");

if( isset($_GET['buscarMateria']) ) {
    $resultado = $this->buscarMateria( $_POST );
    echo json_encode($resultado);
}

if( isset($_GET['buscar_ingredientes']) ) {

    $resultado = $this->buscarIngredientes( $_POST );
    $table = '';
    $found = true;

    if(is_array($resultado)) {

        for ($i=0; $i < count($resultado); $i++) {
            $table .= '<tr class="hand"><th scope="row">'. $resultado[$i]['clave'] .'</th><td>'.$resultado[$i]['nombre_ingrediente'].'</td><td>'.$resultado[$i]['marca'].'</td><td>'. $resultado[$i]['lote_proveedor'] .'</td><td>'.$resultado[$i]['fecha_vencimiento'].'</td><td>'.$resultado[$i]['presentacion'].'</td><td>'.$resultado[$i]['estado'].'</td></tr>';
        }

    } else {

        $table .= '<tr class="hand"><th scope="row"></th><td></td><td></td><td></td><td></td><td></td><td></td></tr>';
        $found = false;

    }

    if($found) {

        echo json_encode( array('table' => $table, 'found' => $found) );

    } else {

         echo json_encode( array('mensaje' => 'No se pudo conseguir el ingrediente!',
                                'table' => $table,
                                'found' => $found, 
                                'tipo' => 'error', 
                                'titulo' => 'Error') );
    }
}

