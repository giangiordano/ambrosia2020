<?php ( $this->isLog() ? '' : $this->redirect('?login') );

$this->Vista("null");

    if( isset($_GET['getMunicipios']) ) {

        $datos = $this->getMunicipios($_GET['id_depart']);
        $html = '<option value=""></option>';
        for ($i=0; $i < count($datos); $i++) { $html .= '<option value="'.$datos[$i]['clave'].'">'.$datos[$i]['nombre'].'</option>'; }
        $res = array('html' => $html, 'res' => true);
        echo json_encode($res);

    }

