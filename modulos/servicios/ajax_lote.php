<?php ( $this->isLog() ? '' : $this->redirect('?login') );

$this->Vista("null");

if( isset($_GET['add_lote']) ) {

    $resultado = $this->addLote( $_POST );
    if( $resultado['insert'] == 1 ) {

        echo json_encode( array('mensaje' => 'Lote creado con Exito!', 
                                'insert' => true, 
                                'tipo' => 'success', 
                                'titulo' => 'Exito' ));

    } else {

        echo json_encode( array('mensaje' => ($resultado['mysql']['code'] == 1062 ? 'Lote Duplicado' : $resultado['mysql']['message']), 
                                'insert' => false,
                                'tipo' => 'error', 
                                'titulo' => 'Error' ));
    }

}
