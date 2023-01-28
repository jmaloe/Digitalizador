/**************************************** *
 *   CODIGO FUENTE POR ALEXANDER ORELLANA *
 *                                        *
 *          alex_ore@msn.com              *
 *                                        *  
 *****************************************/
var enableVAT = false;
var scroll;
var scrollLeft;
var auxRuta2;
var aux = 0;
var lengthscroll;
var cambioPosicionMenudonw = - 1;
var cambioPosicionMenudonwAux = -1;
var cambioDeBanner = true;//VARIABLE QUE DEFINE SI SE VOLVERÁ AL BANNER PRINCIPAL
 var unidadComptenecia;
var URL = "http://www.cv.unach.mx/plataformamoodle";
var isActive=true;

$(window).scroll(function() {	
    scroll = Math.max($('body').scrollTop(), $('html,body').scrollTop());				
    if(lengthscroll<=0){	
        if (scroll > 120 )
        {
            $("#signUp").addClass("fixed");		
            $("#ocultar").addClass("ocultarUp");		
            $("#spacer").addClass("spacer");	
            $("#menu-lateral").addClass("menu-lateral-static");							
        }
        else {
            $("#signUp").removeClass("fixed");   			
            $("#ocultar").removeClass("ocultarUp");
            $("#ocultar").removeClass("ocultarDown");
            $("#spacer").removeClass("spacer");
            $("#menu-lateral").removeClass("menu-lateral-static");
            if($('div#ocultar').css('top')=="0px"){		        
                $("#signUp").slideDown(300);				  
                $('div#ocultar').css( {
                    'top': '62px'
                } );						 	 
            }
        }
	 
    }										
});//FIN DEL EVENTO SCROLL		   		   
//EVENTO 
		   
		   
		   
$(window).resize(function() {
    $('body').scrollLeft(1),  $('html,body').scrollLeft(1);					
    $('body').scrollLeft(4),  $('html,body').scrollLeft(4);
    $('body').scrollLeft(7),  $('html,body').scrollLeft(7);
    $('body').scrollLeft(10),  $('html,body').scrollLeft(10);              				 			
	
    lengthscroll = Math.max($('body').scrollLeft(), $('html,body').scrollLeft()) ;				           
    if(lengthscroll>0){					 
        $("#signUp").removeClass("fixed");   			
        $("#ocultar").removeClass("ocultarUp");
        $("#ocultar").removeClass("ocultarDown");
        $("#spacer").removeClass("spacer");
        $("#menu-lateral").removeClass("menu-lateral-static");
    }
				 						 
});		   		   		   

var lengthMenu = new Array(10) ;



var tolptip;

$(document).ready(function($) {	

tolptip=function (){
$("body a[title]").tooltip({
          // use div.tooltip as our tooltip
          tip: '#tooltip',

          // use the fade effect instead of the default
          effect: 'fade',

          // make fadeOutSpeed similar to the browser's default
          fadeOutSpeed: 10,

          // the time before the tooltip is shown
          predelay: 100,

          // tweak the position
          position: "bottom right",
		  		  		  
          offset: [-3, -5]
      });
}
	tolptip();					   
//		$("body").niceScroll();				   
//	 $("html").niceScroll();					   
    $('body').scrollLeft(10),  $('html,body').scrollLeft(10);
    lengthscroll = Math.max($('body').scrollLeft(), $('html,body').scrollLeft()) ;
    //$('ul li a[title]').hover( function () {console.log("Dentro del tolp tips");} );									
	
    //POSICIONA LOS ELEMENTOS DEL MENU LATERAL	
    $primerelementoMenuLateral = $('#menu-lateral ul li').first();			  	  
    $primerelementoMenuLateral.css( {
        "margin-top": "-5px" //135
    } );
    //FIN DEL MARGEN DEL MENU LATERAL
	  
    /*************** PARTE QUE REALIZA EL MOVIMIENTO DEL MENÚ ***********///////////	  
    contador = 0;//CONTADOR PARA MOVER LO ELEMENTOS DEL MENÚ SUBCOMPETENCIAS.
    contador2 = 0;
    var widthBarra =0;
    var auxContador;
	  
    $('#2 li').each(function(index, element) {

        if(index%2===0)
            widthBarra += parseInt($(element).css("width"));			
        auxContador = index;
							
    });	  
	
	
    if(widthBarra>530){		  
        $('.contentnav2').animate( 
        {   
            width : '-=57px'
        },0);		  		 		 		 		 
        $('#mover-menu').css('display','block');		  		  
    }
	  
    $('a#adelante').click(function(){	
        widthBarra = 0;
        $('#2 li').each(function(index, element) {
        
            if(index%2===0){
                widthBarra += parseInt($(element).css("width"));			
            }
            auxContador = index;
							
        });	  
			 
        if(widthBarra>480){			  	  	
            var width = $('ul#2 li').eq(contador).css("width"); 		       				   
            $('ul#2 li').eq(contador).toggle("fast").animate( {
                "width" : "0px",
                left: width
            });	
            contador+=2;			   	
            lengthMenu[contador2] = width;
            contador2++; 	
		   
        }	  	  
	  	  
    });	  	  	
	  
	  
    $('a#atras').click(function(){			  	  		   	   		  
        if(contador!=0) {
            contador-=2;
            contador2--;
            var left = $('ul#2 li').eq(contador).css("left");			  			  
            $('ul#2 li').eq(contador).toggle(100).animate( 
            {
                "left" : "0px",
                "width" : lengthMenu[contador2],
                right : lengthMenu[contador2]
            },100);											 
        }
    });
	  	  
    $('a#adelante').mousedown(
        function () { 
            $('a#adelante img').attr('src', 'public/images/botons/fwd2.png'); 
        }	 
        );		  	  
    $('a#adelante').mouseup(
        function () { 
            $('a#adelante img').attr('src', 'public/images/botons/fwd1.png'); 
        }	 
        );		  	  
    $('a#atras').mousedown(
        function () { 
            $('a#atras img').attr('src', 'public/images/botons/rew2.png'); 
        }	 
        );		  	  
    $('a#atras').mouseup(
        function () { 
            $('a#atras img').attr('src', 'public/images/botons/rew1.png'); 
        }	 
        );
	  
	  
	  
	  
    /***************************************************************************************************/  
	  

		
    //PLUG IN DE EFECTO DE MENÚ
    $("#2,#nav").lavaLamp(
    {
        fx: "backout",
        speed: 700,
        click: function(event, menuItem) {
            return false;
        }
    }
    ); 
			
						   
    var toLoad = 'presentacion.html';//CARGA POR DEFAULT LA PAGINA PRINCIPAL
    loadContent(toLoad);
			
   // window.location.hash = toLoad;

		
    /**********FUNCION DE CARGAR CONTENIDO****/
    $('#nav li a').click(function(){								  
        var toLoad = $(this).attr('href');					
        cargando(); 					
        loadContent(toLoad);		 
        return false;		
    });
				
			
    function cargando(){
    	$('#load').remove();		
		$('#cargado').append('<div id="load">CARGANDO... </div>');		
		$('#load').fadeIn('normal');
    }	
		
		
    function loadContent(toLoad) {
        $('#content').load(toLoad,'',function(responseText, textStatus, XMLHttpRequest) {
            switch (XMLHttpRequest.status){
                case 200:
                    hideLoader();					
                    break;
                case 404:					
                    $('#content').html("<div id='error'></div> ");
                    hideLoader();
                    break;
                default:																						
                    hideLoader();
                    break;
            }		
        });
		 
        if( $("#signUp").css("top") == "0px"){
            $(window).scrollTop(148);
        }				 		
    }
		
    function hideLoader() {
        $('#load').fadeOut('normal');
    }		
		
    $('#menuPie li a').click(function(){								  
        var toLoad = $(this).attr('href');				
		$('#ruta').text( auxRuta2 +" / "+ $(this).attr("title"));				
        cargando();
        loadContent();
        loadContent(toLoad)			 
        return false;		
    });
			
	//FUNCION QUE GENEREA LA RUTA DE NAVEGACION PARA LAS HERRAMIENTAS 		
	cargarHerramientas = function (id){
		
		$primerelementoMenuLateral.animate ({
											"margin-top": "-5px"		  
													  },1000);		
		var herramientas = Array('chat','foro','tareas','avisos','calificaciones','asesor','contactos');
		var i=0;
         //$('#menu-lateral ul li').removeClass("removeMenuLateral");
		 
		   $('#menu-lateral ul li').each(function(index, element) {	
		         if(index>1)								      
			      $(element).toggleClass("removeMenuLateral");	   			   
          });
	
		
		 $('#menu-lateral ul li a').each(function(index, element) {									      
				   if(index>1)
				   {
					  $(element).attr('href',"herramientas/"+herramientas[i]+".html");  
					  i++;
				   }				   
          });	  
		 
		 
		}			
				
				
				
    $('#2 li a').bind('click',	    	  	  	  
        function (event)
        {			   
           var toLoad = $(this).attr('href');	
//		    console.log(toLoad.indexOf("=")); 		   
//		    console.log(toLoad.substring(toLoad.indexOf("=")+1,toLoad.length)); 
		   
		    
            cargando();   
            loadContent();				
            loadContent(toLoad);			
            unidadComptenecia= $(this).attr("rel");		   			
			
			cargarHerramientas(unidadComptenecia);//FUNCION QUE GENEREA LA RUTA DE NAVEGACION PARA LAS HERRAMIENTAS 
			
			var slave = $(this).text();//PONE LA RUTA DE NAVEGACION
        	var ruta =  $("#ruta").text(); 		 	
    	   $("#ruta").text($("#ruta").text()+" / "+slave);
				  		  			 			   		  		 															
			if(unidadComptenecia>0)		
		    cambioDeBanner = false;
																		
            var subcompetencia = unidad[unidadComptenecia-1].length;			
            var html ="";			  
            for( i=0;i<subcompetencia;i++)
            {	  
				 
                html += "<li><a href='u"+unidadComptenecia+"/tema"+(i+1)+"/presentacion.html' title= 'Tema "+(i+1)+ 
                "' onclick= 'return cargarunida("+unidad[unidadComptenecia-1][i]+","+(i+1)+","+unidadComptenecia+")'>TEMA"+(i+1)+"</a></li>" + 
                " <li class='diagonales'></li>";				 				 
            }
            $('#contentnav2 #2').html(html);	
			tolptip();	
			
			document.getElementById("barra1").innerHTML = "<li><a href='index.html' title ='Regresar al nivel general' target='_self'><span class=\"md-titulo\">N</span><span class=\"md-texto\">IVEL GENERAL</span></a></li>";
			
    $("#nav").html( "<li><a href='u"+unidadComptenecia+"/presentacion.html' ><span class=\"md-titulo\">N</span><span class=\"md-texto\">ivel unidad</span></a></li> <li class='diagonales1'></li>"/*+
	                "<li><a href='uc"+unidadComptenecia+"/productofinal.html' >Producto final</a></li><li class='diagonales1'></li>" +
                    "<li><a href='uc"+unidadComptenecia+"/referencias.html' >Referencias</a></li> <li class='diagonales1'></li>"+
                    "<li><a href='uc"+unidadComptenecia+"/calendario.html' >Calendario</a><li class='diagonales1'></li></li>"*/);		
													
    document.getElementById("uc").innerHTML = "<span class=\"md-titulo\">T</span><span class=\"md-texto\">EMAS</span>";
             var auxRuta = $("#ruta").text();
	          cargarElSegundoEvento(auxRuta);
             
				 tolptip();		 																			 						 				 		 				 
            return false;
        });		  		 	
		
		
			
		function cargarElSegundoEvento(auxRuta){															 
            $('#2 li a').click(function () {
			    var slave = $(this).text();		 
                var toLoad = $(this).attr('href');
                cargando();   
                loadContent();	
			//	window.location.hash = $(this).attr('href').substr(0 , $(this).attr('href').length-0);
                loadContent(toLoad);				
     			$("#ruta").text(auxRuta +" / Tema "+ slave.substr(-1,1));		
				auxRuta2 =  $("#ruta").text();				 				 
				return false;	 
            });
				 
			 $('#nav li a').click(function () {		
    			var slave = $(this).text();		 			 
                var toLoad = $(this).attr('href');
                cargando();   
                loadContent();					
                loadContent(toLoad);	
				$("#ruta").text(auxRuta +" / "+slave);		
				auxRuta2 =  $("#ruta").text();	
				 $("#menuPie").css({
            "visibility":"hidden"
        });			
		$("#ocultaPie").removeClass("ocultarDown");
		$("#ocultaPie").removeClass("ocultarUp");
				return false;	 
            }); 	 
		   		 				 				 
            $("#2,#nav").lavaLamp(
            {
                fx: "backout",
                speed: 700,
                click: function(event, menuItem) {
                    return false;
                }
            }
            ); 
		}
				
    $("div#ocultar").click( function (){					
        var posicion = $('div#ocultar').css("top");		    
        if(posicion  > "57px" )
        {
            $("#signUp").slideUp(700);
            $('div#ocultar').animate(
            {
                top: '-=62'
            },750, function () {
				     $('div#ocultar').removeClass('ocultarUp').addClass("ocultarDown");	
				});//.removeClass('ocultarUp').addClass("ocultarDown");		  
			//$('div#ocultar').removeClass('ocultarUp').addClass("ocultarDown");
        }else if(posicion < "-1px"  || posicion == "0px"){
           $("#signUp").slideDown(700);
           $('div#ocultar').animate(
            {
                top: '+=62'				
          
            },600,function () {
				$('div#ocultar').removeClass("ocultarDown").addClass("ocultarUp");
				}
			);//.removeClass("ocultarDown");//.addClass("ocultarUp");
		  
      
        }	  	 		 
    });	
	 
	 
    //EVENTO PARA CAMBIO DE APARIENCIA EN EL MENU DOWN  					
    $('#menuPie ul li a').click( function (){
		
		
        if(cambioPosicionMenudonwAux  != -1)
        {
            $('#menuPie ul li').eq(cambioPosicionMenudonwAux).removeClass('sombra2');
            $('#menuPie ul li').eq(cambioPosicionMenudonwAux).addClass('menuinferior');
        }
		          										    						   
        cambioPosicionMenudonw=$(this).attr('rel')	  
        $('#menuPie ul li').eq(cambioPosicionMenudonw).removeClass('menuinferior');  			
        $('#menuPie ul li').eq(cambioPosicionMenudonw).addClass('sombra2');
		
        cambioPosicionMenudonwAux =  cambioPosicionMenudonw;	   			  			
        if( $("#signUp").css("top") == "0px"){
            $(window).scrollTop(170);
        }							 						
    });	
	 
    $("#ocultaPie").click(function () 	 
    {
        $("#menuPie").slideToggle(500);
        $("#ocultaPie").toggleClass("ocultarDown").toggleClass("ocultarUp");		
    }) ;
	 
/*	 
	 $('#menuPie ul li').hover (function(){
										   
									$(this).css({
          'background':'url(public/images/botones/trans-01.png) no-repeat',
		  'margin-top': '-20px',
		  'text-align':'center',
		  'color':'#4D4D4D',
		  'padding-left':'0px',
		  'padding-top':'8px',	 													 
								});																		
										   },function(){
											  
											if(isActive){
											   $(this).css({										   
												  'background':'url(public/images/botones/boton-05.png) no-repeat', 	
												  'margin-top': '-15px',
												  'padding-top':'2px' 						                                              	                              						});
											}
				});
	 */
    var count;				
    $('#2 li a').hover( function(e){        	
        count = $(this).attr('rel');
        if(count!=0){
            showImage(parseInt(count)-1);			
        }
    }, function(e){});
		
		
    $('#2').hover( function(e){        	
		
        }, function(e){					
            if(cambioDeBanner){			 				 				 
                $(currentImage).fadeOut(350, function() {					 
                    $(this).css({
                        'display':'none',
                        'z-index':1
                    })
                });				 				 
            }
        });						
});
  		
var aux2 = 0;
var aux = 0;
function cargarunida(acts,subcompetencia,UC){	
    $("#ocultaPie").addClass("ocultarDown");  
    //		$("#ocultaPie").addClass("ocultarUp");  
    if(cambioPosicionMenudonwAux  != -1){
        $('#menuPie ul li').eq(cambioPosicionMenudonwAux).removeClass('sombra2');
        $('#menuPie ul li').eq(cambioPosicionMenudonwAux).addClass('menuinferior');
    }
		 
    cambioPosicionMenudonwAux = -1;
		 
		  
    if(acts>0){//SI ACTS ES IGUAL A 0 NO MOSTRAR NIGUN SUBMENU DE LAS ACTIVIDADES
        aux = acts*23;			  
        $('#menuPie li').each(function(idx, el) {	 				 
            $(el).addClass("remove").animate(
            {
                marginLeft: "+="+aux2+"px",
                marginRight:  "-="+aux2+"px"
            }, 200).animate(
            {
                marginLeft: "-="+aux+"px",
                marginRight: "+="+aux+"px"			
            }, 200);	;	
        });
				  		  
        $('#menuPie  li').eq(0).removeClass("remove");//EL RPINCIPIO DEL MENÚ
		
		/*$('#menuPie  li').eq(1).removeClass("remove");
        /*$('#menuPie li a').eq(0).attr({
            href: 'uc'+UC+'/sub'+ subcompetencia+'/preliminar.html',
            title: 'Actividad Preliminar' 
        });*/	 	     					
														  												
        for(var i=1;i<=acts;i++){
            $('#menuPie  li').eq(i+1).removeClass("remove");
			$('#menuPie li a').eq(i).attr({
                href: 'u'+UC+'/tema'+ subcompetencia+'/tema_'+ subcompetencia+'_act'+i+'.html',
                title: 'Actividad ' + i
            });																																	
        }		
		  
		    		  		  	
        //este bloque fue modificado por: Jaime Toledo Peña
		//es para la activacion de los examen final o parcial si los hay
		if(subcompetencia==unidad[UC -1].length)
		{
				aExamen=unidadexamen[UC].split(",");
				if(aExamen[0]==1)
				{
					$('#menuPie li a').eq(8).attr({
						href: 'u'+UC+'/tema'+ subcompetencia+'/parcial.html',
						title: 'Examen parcial'
					});	
					$('#menuPie li').eq(9).removeClass("remove");
				}
				if(aExamen[1]==1)
				{
					$('#menuPie li a').eq(9).attr({
						href: 'u'+UC+'/tema'+ subcompetencia+'/final.html',
						title: 'Examen final'
					});	
					$('#menuPie li').eq(10).removeClass("remove");
				}
				$('#menuPie li a').eq(10).attr({
						href: 'u'+UC+'/tema'+ subcompetencia+'/autoevaluacion.html',
						title: 'Autoevaluación'
				});		
						
				$('#menuPie li').eq(11).removeClass("remove");
				$('#menuPie li').eq(12).removeClass("remove");
			
		    
		}else{
			$('#menuPie li a').eq(10).attr({
						href: 'u'+UC+'/tema'+ subcompetencia+'/autoevaluacion.html',
						title: 'Autoevaluación'
			});		
			$('#menuPie li').eq(11).removeClass("remove");
			$('#menuPie li').eq(12).removeClass("remove");
		}
		//termina el bloque de los examenes parciales o finales
		
		
		tolptip();								
        $("#menuPie").css({
            "visibility":"visible"
        });
		 
        aux2 = aux;	
    }else{
		   
        $('#menuPie li').each(function(idx, el) {		 				 
            $(el).addClass("remove");		 				 				 
        });
		  
        $("#menuPie").css({
            "visibility":"hidden"
        });
    }
tolptip();	

    //		event.preventDefault(); evita que no se genere ninguna axion despues del click
    return false;				
}




function cargarunidad(id){   
    document.getElementById("barra1").innerHTML = "<li><a href='index.html'  target='_self' class='textos'>NIVEL DE MÓDULO</a></li>";
    $("#nav").html( "<li><a href='#' onclick = \"return loadContent('UC"+id+"/presentacion.html #content');\" title ='Unidad de competencia'>UNIDAD DE COMPETENCIA</a></li> <li class='diagonales1'></li><li><a href='UC"+id+"/productofinal.html'> PRODUCTO FINAL</a></li> <li class='diagonales1'></li>" +
        "<li><a href='UC"+id+"/referencias.html'> REFERENCIAS</a></li> <li class='diagonales1'></li>"+
        "<li><a href='UC"+id+"/calendario.html'> CALENDARIO</a><li class='diagonales1'></li></li>");		
													
    document.getElementById("uc").innerHTML = "SUBCOMPETENCIAS";
}


var currentImage;
var currentIndex = -1;
var interval;
var flag = 1;
function showImage(index){
    if(index < $('#banner img').length){
        var indexImage = $('#banner img')[index];
			
        if(currentImage){   
            if(currentImage != indexImage ){
                $(currentImage).css('z-index',2);               							
                $(currentImage).fadeOut(350, function() {					 
                    $(this).css({
                        'display':'none',
                        'z-index':1
                    })
                });
				
            }
        }
        $(indexImage).css({
            'display':'block', 
            'opacity':3
			
        });
        currentImage = indexImage;
        currentIndex = index;
    }
}
	
function hidenImage(index){
    var indexImage = $('#banner img')[index];				
    $(indexImage).css('z-index',2);
    $(indexImage).fadeOut(350, function() {					 
        $(this).css({
            'display':'none',
            'z-index':1
        })
    });
}
function verefecto(){
    $("#1, #2, #3").lavaLamp({
        fx: "backout",
        speed: 700,
        click: function(event, menuItem) {
            return false;
        }
    });
	
}

function menuDown() {
    console.log("Clien para formar menu");
	
}

function video(){		 		 
$(function() {
    // install flowplayer into flowplayer container
   var palyer;	
   var idvideo;					
    // set up button action. it will fire our overlay
	var altoPantalla;
	$("img.video").click( function (){
		       idvideo = $(this).attr("id")
			   $("a#player"+idvideo).css("display","block"); 
		       player = "player"+idvideo;
			    altoPantalla = screen.height;
					     
					
		  }
	 )	
    $("img[rel]").overlay
	(
	{
        // use the Apple effect for overlay		
		
       // effect: 'apple',
		mask: 'black',
		fixed: false,
		left :'50%',
		top:'-15px;',
		
		
        // when overlay is opened, load our player
        onLoad: function() {
			player = $f(player, "recursos/flowplayer-3.2.7.swf");					
			if(altoPantalla>750)
			$('body').css("overflow","hidden");	
			
            player.load();
        },
        // when overlay is closed, unload our player
        onClose: function() {
			$("a#player"+idvideo).css("display","none");
			$('body').css("overflow","auto");			
            player.unload();
        }
    }
	
	);
});
}
	
	
	$(function() {   		   		   		   
    // if the function argument is given to overlay,
    // it is assumed to be the onBeforeLoad event listener
    $("#menu-lateral ul li a[rel]").overlay({
        mask: 'black',
        effect: 'apple',
        onBeforeLoad: function() {
			$('body').css("overflow","hidden");	
            // grab wrapper element inside content
            var wrap = this.getOverlay().find(".contentWrap");
            // load the page specified in the trigger
            wrap.load(this.getTrigger().attr("href"));
        },
		
		 onClose: function() {
			$('body').css("overflow","auto");	 
		 }
    });
	
	 $("#usuario  a[rel]").overlay({
        mask: 'black',
        effect: 'apple',
        onBeforeLoad: function() {
			$('body').css("overflow","hidden");	
            // grab wrapper element inside content
            var wrap = this.getOverlay().find(".contentWrap");
            // load the page specified in the trigger
            wrap.load(this.getTrigger().attr("href"));
        },
		
		 onClose: function() {
			$('body').css("overflow","auto");	 
		 }
    });
	
	
});



$.tools.overlay.addEffect("img[rel]", function(css, done) {
 
    // use Overlay API to gain access to crucial elements
    var conf = this.getConf(),
    overlay = this.getOverlay();
 
    // determine initial position for the overlay
    if (conf.fixed)  {
        css.position = 'fixed';
    } else {
        css.top += $(window).scrollTop();
        css.left += $(window).scrollLeft();
        css.position = 'absolute';
    }
 
    // position the overlay and show it
    overlay.css(css).show();
 
    // begin animating with our custom easing
    overlay.animate(
        { top: '+=55',  opacity: 1,  width: '+=20'}, 400, 'drop', done
    );
 
    /* closing animation */
}, function(done) {
    this.getOverlay().animate(
        {top:'-=55', opacity:0, width:'-=20'}, 300, 'drop',
        function() {
            $(this).hide();
            done.call();
        });
});
    /*
    function showNext(){
        var len = $('#bigPic img').length;
        var next = currentIndex < (len-1) ? currentIndex + 1 : 0;
        showImage(next);
    }
    
   */

