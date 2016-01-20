<?php

class Email{

	private $destinatario;					// A quien va dirijido el email
    private $cc;		          			// Enviar copia
    private $bcc;       					// Enviar copia oculta
	private $responderA;					// Respondo
	private $nombreEnvia;					// Nombre que aparecerá del que envía
	private $asunto;						// Asunto
	private $cabecera;						// Cabeceras del mensaje para ser reconocido como email
	private $cabeceraCliente;				// Cabeceras del mensaje para ser reconocido como email
	private $mensajeEmpresa;				// Mensaje que se recibirá en la empresa
	private $mensajeCliente;				// Mensaje que recibirá el Cliente.


    function __construct($destinatario,$cc,$bcc){

		$this->destinatario = $destinatario;
        $this->cc  = $cc;
        $this->bcc = $bcc;
        

	}

	/*
	 *  Método para el envio del email
	 */

	function envio($responderA, $nombreEnvia ,$asunto, $datos){
        
		$this->responderA	= $responderA;
		$this->asunto 	  	= $asunto;
		$this->nombreEnvia	= $nombreEnvia;

		// Creo las cabeceras para el mensaje a la empresa
		$this->cabecera  = "From:       $this->nombreEnvia < $this->responderA >\r\n";
        $this->cabecera .= "to:         $this->destinatario \r\n";
        $this->cabecera  = "Cc:         $this->cc \r\n";
        $this->cabecera  = "Bcc:        $this->bcc \r\n";
        $this->cabecera  = "Subject:    $this->bcc \r\n";
		$this->cabecera .= "Reply-To:   $this->responderA \r\n";		
		$this->cabecera .= "MIME-Version: 1.0\r\n";
		$this->cabecera .= "Content-Type: text/html; charset=UTF-8\r\n";


		$this->mensajeEmpresa  = "<div style='background:#f0f0f0; border-top:1px solid #777; box-shadow:0 -2px 2px #999; -webkit-box-shadow:0 -2px 2px #999; width:90%;margin:0 auto;'>";
		$this->mensajeEmpresa .= "<span style='font-size: 90%; margin:0; background:#fcfcfc; padding:1em 2em 1em 0.6em; color:#888888; display:inline-block;'>";
		$this->mensajeEmpresa .= $this->asunto;
		$this->mensajeEmpresa .= "</span><div style='display:block;height:20px;'></div>";
		$this->mensajeEmpresa .= "<table cellpadding='0' cellspacing='0' style='width:auto; margin: 0.2em 2em 2em; font-size: 100%;'>";

		foreach ($datos as $key => $value) {

			if ( ($key != 'Navegador') && ($key != 'Navegador-ver') && ($key != 'OS') && ($key != 'Formulario') ){
				$this->mensajeEmpresa .= "<tr>";
				$this->mensajeEmpresa .= "<td style='padding: 0.3em 1em; border-bottom:1px dotted #ddd; padding-right:2em; color:#888; width:1%;'>";
				$this->mensajeEmpresa .= $key;
				$this->mensajeEmpresa .= "</td>";
				$this->mensajeEmpresa .= "<td style='padding: 0.3em 1em; border-bottom:1px dotted #ddd; padding-left:0; color:#333;'>";
				$this->mensajeEmpresa .= $value;
				$this->mensajeEmpresa .= "</td>";
				$this->mensajeEmpresa .= "</tr>";
			}	
			
		}
		$this->mensajeEmpresa .= "</table></div>";

        $this->asunto = "Mensaje desde la pagina web de: ".$datos["Nombre"]." ".$datos["Apellido"];

		// Envío el menasaje al encargado de la empresa
		// Si el envio fue exitoso entonces mando un email al cliente
		if(mail($this->destinatario, $this->asunto, $this->mensajeEmpresa, $this->cabecera)){

			// Modifico el asunto adaptado al cliente
			$this->asunto = "Tu mensaje enviado a ".$this->nombreEnvia." ha sido recibido";

			// Creo el mensaje de confirmación que recibirá el cliente.
            $this->mensajeCliente = "Hola ".$datos["Nombre"]." ".$datos["Apellido"]." hemos recibido tu mensaje, uno de nuestros asesores te contactar&aacute; a la brevedad. <br><br><hr style='border:1px solid black;'><br><br>";

			// Le mando copia del mensaje con los datos que el envió
			$this->mensajeCliente .= $this->mensajeEmpresa;

			// Creo las cabeceras para el mensaje al cliente
			$this->cabeceraCliente  = "From: $this->nombreEnvia < $this->responderA >\r\n";
			$this->cabeceraCliente .= "Reply-To: $this->responderA \r\n";
			$this->cabeceraCliente .= "Bcc: ". $datos["Email"]."\r\n";
			$this->cabeceraCliente .= "MIME-Version: 1.0\r\n";
			$this->cabeceraCliente .= "Content-Type: text/html; charset=UTF-8\r\n";

			if(mail($datos["Email"], $this->asunto, $this->mensajeCliente, $this->cabeceraCliente)){

				return true;

			}

		}else{

			return false;
		}
	}

}