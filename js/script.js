/**
 * Desarrollo de Asteksoft.com
 * Tomado de la web
 */


$(document).ready(function(){
    
    //Dinamizar el alto de las imagenes del home
    var imgHome     = $('.opc').find('.img');
    var anchoImg    = imgHome.width();
    
    // Factor para obtener el alto relativo
    var factor = 0.775193798;
    var alto = anchoImg * factor;
    
    // Modifico el alto dinamicamente
    imgHome.css('height',alto);    
 /*   
    //Dinamizo el alto de las imagenes de la pagina de catálogos
    var imgCat      = $('.catalogos').find('img');
    var anchoImgCat = imgCat.width();
    
    // Factor para obtener el alto relativo
    var factor  = 0.772222222;
    var altoCat = anchoImgCat * factor;
    
    // Modifico el alto dinamicamente
    //imgCat.css('height',altoCat);
    
    
   */ 
    
    // Cache the Window object
    $window = $(window);
    
    
    /****************************************************************
     * Efecto de los botones del menú principal Home, nosotros, etc..
     ****************************************************************/

    
    $('#menu a').click(function(){
        //elimino color a todos los botones, y agrego color desactivado
        $('#menu a').removeClass('bot-activo');
        $('#menu a').addClass('bot-normal');
        
        //Al boton que presioné le dejo el color de activo :D
        $(this).addClass('bot-activo');
        
        
    });
    
    /****************************************************************
     * Efecto de suavidad al precionar los botones
     ****************************************************************/
    
    // Selecciono todos los enlaces que serán scrolldown a excepción del ultimo que es el enlace de contacto
    $('#menu a:not(:last-child)').click(function(e){
        // Prevenir comportamiento predeterminado del enlace
        //e.preventDefault();
        
        // Obtengo el id del elemento en el que debo posicionarme
        var strAncla = $(this).attr('href');
        
        // Utilizo body y html ya que dependiendo del navegador uno u otro no funciona
        $('body,html').stop(true,true).animate({
            
            // Realizo la animación del ancla
            scrollTop: $(strAncla).offset().top
        },1000);
        
    });        
    
    
    /****************************************************************
     * Coloreo los subtitulos al hacer hover en el boton de categoria
     ****************************************************************/
    $('.opc .img').hover(function(){

        $(this).children('.subtitulo').toggleClass('verde');
        
    });

    
    
    /****************************************************************
     * Animación en el movimiento entre paginas usando la barra scroll
     ****************************************************************/

    $('section[data-type="background"]').each(function(){
        var $bgobj = $(this); // assigning the object

        $(window).scroll(function() {

            // Scroll the background at var speed
            // the yPos is a negative value because we're scrolling it UP!								
            var yPos = -($window.scrollTop() / $bgobj.data('speed')); 

            // Put together our final background position
            var coords = '50% '+ yPos + 'px';

            // Move the background
            $bgobj.css({ backgroundPosition: coords });

        }); // window scroll Ends

    });	

    
    /****************************************************************
     * Botones de Accesorios, Refacciones, Consumibles, Llantas
     ****************************************************************/
    
    
    $('#opciones .opc .encierra').hover(function(e){
        // Prevenir comportamiento predeterminado del enlace
        e.preventDefault();

        // Obtengo el id del elemento en el que debo posicionarme
        var boton = $(this).children('ul');
        //boton.toggleClass('muestro');
        
        if(boton.hasClass('oculto')){
            boton.removeClass('oculto');
            setTimeout(function(){
                boton.removeClass('ocultodevista');
            }, 100 );
        }else{
            boton.addClass('ocultodevista');
            boton.one('transitionend', function(e){
                boton.addClass('oculto');
            });
            
        }
        
        
    });

    /****************************************************************
     * Boton para bajar a la siguiente página
     ****************************************************************/
    $('section footer i.fa-angle-down').click(function(e){
        
        // Mi ancla va a ser el boton que se encuentre activo
        var $anchor = $('#menu a.bot-activo:not(:last-child)');
        
        // Elimino la clase activo al elemento en el que estoy y le pongo a este bot-normal
        $($anchor).removeClass('bot-activo').addClass('bot-normal');
        
        // Le agrego al siguiente elemento la clase activo
        $($anchor).next().eq(0).addClass('bot-activo');
        
        $('html, body').stop().animate({
            scrollTop: $($anchor.next().attr('href')).offset().top
        }, 1500);
        
    });
    
    /****************************************************************
     * Boton para subir al home
     ****************************************************************/
    $('section footer i.fa-angle-up').click(function(e){
        $("html, body").animate({ scrollTop: 0 }, 1500);
        // Quito activo al enlace actual
        $('#menu a.bot-activo').removeClass('bot-activo').addClass('bot-normal');
        // Pinto de activo el primer enlace
        $('#menu a.bot-normal:first-child').addClass('bot-activo');
        
        return false;
    });
    

}); 