<?php

//activo para que php me muestre los errores
ini_set('display_errors', true);
error_reporting(E_ALL);

require_once 'class/Procesa.class.php';

if ( !empty( $_GET["tipo"] ) ){
    
    $tipoForm = $_GET["tipo"];
    
}else{
    
    $tipoForm = 'Contacto';
    
}


// Detecto si esta llengando algo por $_POST, estos serán los campos desde el form

if ( !empty($_POST) ){

    $procesa    = new Procesa();
    // Compruebo que los campos mandatorios no vayan sin responder
    $compruebo  = $procesa->comprueboCampos($_POST,['Nombres','Email','Telefono','Comentarios']);

    // Si compruebo devuelve null significa que los datos enviados son correctos
    // Si no guardo la respuesta y la imprimo.

    if ( $compruebo == NULL ){

        // Si todos los datos obligatorios han sido introducidos proceso la información
        $comprueboDatos = $procesa->datos($_POST);

        // Luego de procesado los datos, si recibo un confirma quiere decir que todo esta ok y procedo
        // a redirigir a una pagina de agradecimiento.
        if ( $comprueboDatos['tipo'] == 'confirma'){

            header("Location: gracias.php"); /* Redirect browser */
            exit();

        } else {

            // Respuesta despues de envio de email y almacenamiento en BD
            $respuestaTipo = $comprueboDatos['tipo'];
            $respuestaMsg  = "Al parecer ha habido un error con el mensaje, por favor intenta nuevamente.";
        }


    }else{

        // Si existe algún dato sin introducir, imprimo un mensaje de error
        $respuestaTipo  = $compruebo['tipo'];
        $respuestaMsg   = $compruebo['mensaje'];

    }

}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Motocom | Refacciones y accesorios para motocicletas</title>
    <link rel="stylesheet" href="css/style.min.css">
    <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">
    <link href='http://fonts.googleapis.com/css?family=Oswald:700' rel='stylesheet' type='text/css'>
    <link href='http://fonts.googleapis.com/css?family=Roboto+Condensed' rel='stylesheet' type='text/css'>
    <script>
        (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
        (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
        m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
        })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

        ga('create', 'UA-66021212-1', 'auto');
        ga('send', 'pageview');
    </script>
</head>
<body>
   <div class="barra"></div>
   <div class="barra2">
        <a href="/index.html"><img src="img/logo.png" alt="logo" class="logo"></a>
        <ul>
            <li class="youtube"><a href="https://www.youtube.com/channel/UCRuFsaby4P-lSOR3FhWGYvQ" target="_blank"><i class="fa fa-youtube fa-3x"></i></a></li>
            <li class="twitter"><a href="http://twitter.com/motocomsa" target="_blank"><i class="fa fa-twitter fa-3x"></i></a></li>
            <li class="facebook"><a href="http://www.facebook.com/motocomsa" target="_blank"><i class="fa fa-facebook fa-3x"></i></a></li>
            <li class="regresa"><a href="/index.html"><i class="fa fa-history fa-3x"></i></a></li>
        </ul>
        <div class="clearfix"></div>
    </div>

    <div class="encierro">
        <div class="msg <?php if (isset($respuestaTipo)){ echo $respuestaTipo; }?>">
            <?php
                if ( isset($respuestaMsg) ){
                    echo $respuestaMsg;
                }
            ?>
            <span class="exit">X</span>
        </div>
        <div class="presenta">
            
            <?php 
                
                if( $tipoForm == "Ser Distribuidor"){
                   
                    print "<h1>FORMA PARTE <br>DE NUESTRA RED <br>DE DISTRIBUIDORES</h1>";
                    
                }else{ 
            ?>
                <h1>REFACCIONES<br> Y ACCESORIOS PARA MOTOCICLETAS</h1>
                
            <?php 
                }
            ?>
            <div class="tel">
                <span class="ico"><i class="fa fa-phone"></i></span>
                <h4>TELÉFONO:</h4><p class="telPhone"> +52 55 2620 3956 <br> +52 55 2620 1031</p>
            </div>
            <div class="ubi">
                <span class="ico"><i class="fa fa-map-marker"></i></span>
                <h4>UBICACIÓN:</h4>
                <p>
                    <a href="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3756.6342744473864!2d-99.19213068456042!3d19.68560243764154!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x85d21fdf67c60d7d%3A0xca14747f8ea49d6!2sCurtidores+38%2C+Industrial+Xhala%2C+54714+Cuautitl%C3%A1n+Izcalli%2C+M%C3%A9x.%2C+M%C3%A9xico!5e0!3m2!1ses-419!2sgt!4v1444427459016" target="_blank">
                Curtidores 38 <br>Parque Industrial Xhala,<br>Cuautitl&aacute;n, Izcalli 54714.
                </a>
                </p>
            </div>
        </div>
        <div class="formulario">
            <h4>Contáctenos:</h4>
            <form action="" method="post" id="contacto">
                <input type="text" name="Nombre" placeholder="Ingresa ambos nombres" autofocus tabindex="1" required autocomplete='off' value="<?php  if ( isset($respuestaTipo) == 'error' ){ if( isset($_POST['Nombre'])){ echo $_POST['Nombre']; } }?>">
                <input type="text" name="Apellido" placeholder="Ingresa ambos apellidos" autofocus tabindex="2" required autocomplete='off' value="<?php  if ( isset($respuestaTipo) == 'error' ){ if( isset($_POST['Apellido'])){ echo $_POST['Apellido']; } }?>">
                <input type="email" name="Email" placeholder="Correo electrónico" tabindex="3" required autocomplete='off' value="<?php   if ( isset($respuestaTipo) == 'error' ){ if( isset($_POST['Email'])){ echo $_POST['Email'];} }?>">
                <input type="tel" name="Telefono" pattern="[0-9 ]*" placeholder="Ej: 52 55 2620 3956" tabindex="4" required autocomplete='off' value="<?php   if ( isset($respuestaTipo) == 'error' ){ if( isset($_POST['Telefono'])){ echo $_POST['Telefono'];} }?>">
                
                <select name="Estado" id="Estado" tabindex="5" required>
                    <option value="">¿Estado de la república de donde escribes?</option>
                    <?php
                        $procesa    = new Procesa();
                        $traigo  = $procesa->consultoEstado();
                        foreach ($traigo as $opcion){
                            print "<option idEstado='".$opcion['idestados']."' value='".$opcion['estado']."'>".$opcion['estado']."</option>\n";    
                    }                     
                    ?>
                </select>
                <select name="Municipio" id="Municipio" tabindex="6" disabled required>
                    <option value="">Selecciona el municipio</option>
                </select>
                <select name="Ciudad" id="Ciudad" tabindex="7" disabled required>
                    <option value="">Selecciona la ciudad</option>
                </select>
                <textarea name="Comentarios" placeholder="¿Deseas agregar algún comentario?" tabindex="8" required><?php    if ( isset($respuestaTipo) == 'error' ){ if( isset($_POST['Comentarios'])){ echo $_POST['Comentarios'];} }?></textarea>
                <input type="submit" id="submit" value="Enviar formulario" tabindex="9">
                <input type="hidden" name="Formulario" value="<?php print $tipoForm; ?>">
            </form>
        </div>
    </div>
    <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
    <script type="text/javascript">
        $(document).ready(function(){
            $("span.exit").click(function(){
                $(this).parent("div.error").hide();
            });

            var ancho = $(document).width();
            if (ancho < 870){
                $(".telPhone").replaceWith("<p><a href='tel:52 55 2620 3956'>52 55 2620 3956</a><br><a href='tel:52 55 2620 1031'>52 55 2620 1031</a></p>");
            }
            
            // Ajax para municipios
            $('#Estado').change(function(){
                
                var id = $('option:selected', this).attr('idEstado');
                
                // Limpio el select y le agrego el mensaje de acción
                $('#Municipio').html('');
                $('#Municipio').append('<option value="">Selecciona el municipio</option>');
                
                $.ajax({
                    data:   'accion=traerMunicipio'+'&idestado='+id,
                    url:    'class/Ajax.class.php',
                    type:   'post',
                    dataType: 'json',
                    contentType: "application/x-www-form-urlencoded;charset=UTF-8",
                    beforeSend: function (xhr) {            	
                        try{
                            //con esto compongo los acentos y agregue una linea al php header
                            xhr.overrideMimeType('text/html; charset=UTF-8');
                            //	$("#resultado").html("Procesando, espere por favor...").css("padding","3px").show();
                        }catch(e){                	
                        }
                    },
                    success:  function (response) {          
                        
                        for(var i=0;i<response.length;i++){
                            $('#Municipio').append('<option idMunicipio="'+response[i]['idmunicipios']+'" value="'+response[i]['municipio']+'">'+response[i]['municipio']+'</option>');
                        }
                        // Habilito el Select
                        $('#Municipio').prop('disabled',false);
                    }
                });
                
            });
            
            // Ajax para ciudades
            $('#Municipio').change(function(){
                
                var id = $('option:selected', this).attr('idMunicipio');
                
                $('#Ciudad').html('');
                $('#Ciudad').append('<option value="">Selecciona la ciudad</option>');
                
                // Como Alejandro pidio que no funcionen ciudades, si es Distrito federal osea value 9 entonces.
                // Detecto si es Distrito Federal.
                
                var estadoSelec = $('#Estado').val();
                if ( estadoSelec != 'Distrito Federal'){
                
                    $.ajax({
                        data:   'accion=traerCiudad'+'&idmunicipio='+id,
                        url:    'class/Ajax.class.php',
                        type:   'post',
                        dataType: 'json',
                        contentType: "application/x-www-form-urlencoded;charset=UTF-8",
                        beforeSend: function (xhr) {            	
                            try{
                                //con esto compongo los acentos y agregue una linea al php header
                                xhr.overrideMimeType('text/html; charset=UTF-8');
                                //	$("#resultado").html("Procesando, espere por favor...").css("padding","3px").show();
                            }catch(e){                	
                            }
                        },
                        success:  function (response) {          

                            for(var i=0;i<response.length;i++){
                                $('#Ciudad').append('<option value="'+response[i]['idlocalidades']+'">'+response[i]['localidad']+'</option>');
                            }
                            // Habilito el Select
                            $('#Ciudad').prop('disabled',false);
                        }                    
                    });
                }else{
                    // Si se seleccionó estado == 9, osea Distrito Federal
                    // Quito la obligatoriedad de llenar el campo y muestro un mensaje de que no hay necesidad
                    // de seleccionar
                    
                    var campo = $('#Ciudad');
                    
                    // Limpio el campo
                    campo.html('');
                    
                    // Agrego mensaje al campo
                    campo.append('<option value="0">No hay dato a seleccionar...</option>');
                    
                }
            });  
            
        });

    </script>
</body>
</html>