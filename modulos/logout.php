<?php 

    $this->Vista("null");
    $this->sessionUnset();
    $this->redirect("?login");
    die();
