<?php

require_once 'Conexion.class.php';
class Db{

	function insertar($formulario, $ip, $datos){

		$tabla1 = 'contacto_envio';
		$tabla2 = 'contacto_dato';


		$db = new Conexion();
		$db = $db->conecta();

		$query = "INSERT INTO $tabla1 (form,ip) VALUES (:form, :ip)";

		//Preparo la inserción de la tabla de envios y la ejecuto
		$result = $db->prepare($query);
		if ($result->execute(array(":form" => $formulario, ":ip" => $ip))) {

			// Si todo va bien, entonces inserto cada campo en su propia tabla
			// Obtengo el id que acabo de insertar y lo amarro a la siguiente tabla
			$id = $db->lastInsertId('id');
			foreach ($datos as $campo => $valor) {

				$query = "INSERT INTO $tabla2 (envio_id, campo, valor) VALUES (:id, :campo, :valor)";
				$result = $db->prepare($query);

				// Ejecuto inserción en la segunda tabla
				$result->execute( array(":id" => $id, ":campo" => $campo, ":valor"=>$valor) );
			}
			return true;

		} else {

		    return false;
		}

	//cierro la conexión
	$db = null;

	}
    
    function consultoEstado(){
        
        $tabla = 'estados';
        
        $db = new Conexion();
        $db = $db->conecta();
        
        $query = "SELECT idestados, estado FROM $tabla";        
        $result = $db->prepare($query);
        
        if ( $result->execute() ){
            
            // Meto todos los datos en un array
            $row = $result->fetchAll();
            
            // Envio el resultado
            return $row;
            
        }else{
            
            return false;
            
        }
        
        //cierro la conexión
        $db = null;
    }
    
    function consultoMunicipio($idEstado){
        
        $tabla = 'municipios';
        
        $db = new Conexion();
        $db = $db->conecta();

        $query = "SELECT idmunicipios,municipio FROM $tabla WHERE idestado= $idEstado";        
        $result = $db->prepare($query);
        
        if ( $result->execute() ){

            // Meto todos los datos en un array
            $row = $result->fetchAll();

            // Envio el resultado
            return $row;

        }else{

            return false;

        }

        //cierro la conexión
        $db = null;
        
    }

    function consultoLocalidad($idMunicipio){

        $tabla = 'localidades';

        $db = new Conexion();
        $db = $db->conecta();

        $query = "SELECT idlocalidades, localidad FROM $tabla WHERE idmunicipio= $idMunicipio";        
        $result = $db->prepare($query);

        if ( $result->execute() ){

            // Meto todos los datos en un array
            $row = $result->fetchAll();

            // Envio el resultado
            return $row;

        }else{

            return false;

        }

        //cierro la conexión
        $db = null;

    }

}
