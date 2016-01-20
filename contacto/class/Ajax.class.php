<?php

require_once 'Procesa.class.php';
// Capturo variables Ajax

if ( !empty( $_POST["accion"] ) ){ 
     $accion  = $_POST["accion"];
   
    // Traer Municipio
    if( $accion == 'traerMunicipio'){

        $idEstado = $_POST['idestado'];
        $traigo    = new Procesa();
        $traigo  = $traigo->consultoMunicipio($idEstado);
        
        $salidaJson = json_encode($traigo);
        print $salidaJson;
    }
    
    // Traer Ciudad
    if( $accion == 'traerCiudad'){
        $idMunicipio = $_POST['idmunicipio'];
        $traigo    = new Procesa();
        $traigo  = $traigo->consultoLocalidad($idMunicipio);

        $salidaJson = json_encode($traigo);
        print $salidaJson;

    }

} 