<?php

require_once 'RemoteAddress.class.php';
require_once 'Email.class.php';
require_once 'Db.class.php';

class Procesa{

	public 		$mensaje;						// Bandera temporal para formatear mensaje
	public 		$devuelvoMensaje = array();		// Mensaje con formato de salida, indica si es error o confirmación
	public 		$devuelvoDatos;					// Contenido de salida
	private 	$ip;							// IP del usuario
    private     $formulario;                    // Nombre del formulario, se controla desde el input hidden
	protected   $destinatario;                  // Email del destinatario
    protected   $cc  = '';                      // Email con copia
    protected   $bcc = '';                      // Email con copia oculta


	function __construct(){

		// Obtengo IP del visitante
		$ip = new RemoteAddress();
		$this->ip 			= $ip->getIpAddress();
		$this->destinatario	= "info@motocomsa.com";
        $this->cc           = "osvaldo.mendizabal@motocomsa.com";
        
	}



	/*
	 *  Compruebo que todos los campos obligatorios sean llenados
	 */

	function comprueboCampos($datos,$camposObligatorios = array()){

		$vacios = array();

		// Recorro los campos enviados
		foreach ($datos as $campo => $valor) {

			// Recorro los campos mandatorios
			foreach ($camposObligatorios as $key) {

				// Comparación del campo contra el listado de campos obligatorios
				if( $campo == $key){

					// Elimino espacios en blanco x si los ingresaron
					$valor = trim($valor);

					// Compruebo que el contenido de este campo no sea null o ' '
					if ( $valor == null){

						// Agrego al array vacios los campos que son obligatorios y vienen vacios
						array_push($vacios,$campo);
					}
				}
			}
		}


		// Si $vacios trae información significa que hay campos vacios y envio un mensaje
		if( count($vacios) > 0){

			// Preparo el mensaje de salida
			$this->mensaje = '<p>Los siguientes campos son obligarotios: ';
			foreach ($vacios as $key) {

				$this->mensaje = $this->mensaje .'<strong>'. $key . '</strong>, ';
			}

			$this->mensaje = $this->mensaje.' debes llenarlos para poder continuar</p>';

			return $this->devuelvoMensaje = array('tipo'=>'error','mensaje'=>$this->mensaje);

		// Si no trae vacios significa que todo esta bien y no devuelvo nada
		}else{

			return;

		}

	}


	/*
	 *  Recibo los datos y los proceso, los grabo en la base de datos
     *  y genero el email para enviarselo al receptor de la empresa y el mensaje del cliente.
	 */

	function datos($datos){

		/*
		 * Grabo en la base de datos el contenido
		 */
        
        // Obtengo el dato del tipo de formulario usado, cuando son multiples forms.
        $this->formulario = $datos["Formulario"];        
        
        // Clase de la Base de datos.
        
		$bd 	= new Db();
        $grabo	= $bd->insertar($this->formulario,$this->ip, $datos);

		/*
		 * Si el proceso de grabado estuvo OK genero el email
		 */
		if($grabo){

            $email 	= new Email($this->destinatario,$this->cc,$this->bcc);
            
            $accion = $email->envio($this->destinatario, 'Informacion Motocom', $this->formulario, $datos);

			// Si el envio del mensaje sale bien, entonces devuelvo un tipo de mensaje de confirmación
			if($accion == true){

				return $this->devuelvoMensaje = array('tipo'=>'confirma','mensaje'=>'');

			// Si el envio de email saliera mal entonces devuelvo un tipo de mensaje de error
			}else{

				return $this->devuelvoMensaje = array('tipo'=>'error','mensaje'=>'');
			}
		}else if(!$grabo){
			return $this->devuelvoMensaje = array('tipo'=>'error', 'mensaje'=>'Ha ocurrido un error, trataremos de solucionarlo a la brevedad.');
		}

	}
    
    
    /*
    *  Consulto los datos geograficos
    */
    function consultoEstado(){

        $db         = new Db();
        $consulto   = $db->consultoEstado();
        
        return  $consulto;
    }
    
    function consultoMunicipio($idEstado){
        $db         = new Db();
        $consulto   = $db->consultoMunicipio($idEstado);
        return  $consulto;
    }
    function consultoLocalidad($idMunicipio){
        $db         = new Db();
        $consulto   = $db->consultoLocalidad($idMunicipio);
        return  $consulto;
    }
    

}