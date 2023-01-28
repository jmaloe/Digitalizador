<?php
/* Nombre de la aplicacion: "digitalizador"
   Version: 2012.10.03
   Autor: Jesus Malo Escobar
   e-mail: dic.malo@gmail.com
*/
date_default_timezone_set('America/Mexico_City');
class Digitalizador
{

var $unidad="1";

/*GENERA PRESENTACIONES, ACTIVIDADES Y AUTOEVALUACIONES*/
function getPresentacion($dirOrigen, $nombreArchivo, $dirDestino, $archDest, $identificador, $omisores, $tema)
{
$lectura = fopen($dirOrigen.$nombreArchivo,"r");
$escritura = NULL;
 $dividir=false;
 if($archDest=="Actividades")
  $dividir=true;
 if(!$lectura)
 {
   echo "<p>RECURSO NO DISPONIBLE :-P</p>";	
  return;
 }
   echo "<br>-> <i>$archDest</i>";
   $cadena="";
   $char="";
   $texto='<!DOCTYPE HTML>
<html>
 <head>
  <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1"/>
  <title>Documento sin t&iacute;tulo</title>
  <link rel="stylesheet" href="../../public/css/txt-style.css" type="text/css"/>
 </head>
<body id="page" class="chrome">
<div id="content">
';
   if($dividir)
   {
	 $texto=NULL;	 
   }
   else
    $escritura=fopen($dirDestino.$archDest,"w");
	
   $guardar=false;            
   $titulo=false;   
   $primerTit=false;
   $flagIdent=false;
   $contActs=1;
   $bfinEt=false; //buscar cierre '>' de la etiqueta para quitar codigo basura
   $glosario=false;
   $cA=""; //caracter anterior
   $cAA=""; //antes del anterior
 try
 {
    while(!feof($lectura))
	{
	 $cAA=$cA;
	 $cA=$char;     
	 $char = fgetc($lectura); //obtenemos caracter por caracter	 	  
	   
	   if($char==">" & $bfinEt)
	    $bfinEt=false;
	   if(!$bfinEt) //verificar si no se esta intentando quitar codigo basura de las etiquetas
	   {
		//eliminando codigo basura   
	   if($cA.$char=="<s" | $cA.$char=="<!" | $cA.$char=="<t" | $cA.$char=="<v" | $cAA.$cA.$char=="</v") 
	    $bfinEt=true;
	   else if ($cA.$char=="<p" | $cA.$char=="<i" | $cA.$char=="<b" | $cAA.$cA.$char=="<li" | $cAA.$cA.$char=="<ul" | $cAA.$cA.$char=="<ol" | $cAA.$cA.$char=="<h1") /*quitamos código basura dentro de estas etiquetas*/
	   {
	     if($cA.$char=="<p")
		  $cadena="<p class='contenido0'"; //aplicamos al parrafo la clase indicada
		 else
          $cadena.=$char;
	    $bfinEt=true;
	   }
       else if($cAA.$cA.$char=="/p>" | $cAA.$cA.$char=="ul>" | $cAA.$cA.$char=="ol>" | $cAA.$cA.$char=="li>" | $cAA.$cA.$char=="h1>")
	   {
	    $cadena.=">".chr(10); //chr(10) es salto de linea
		$cadena = str_replace("  "," ",$cadena); //quitar espacio doble para poder comparar bien
		       
		 if($titulo)
		 {
		  $titulo=false;
		  //$cadena=$cadena."<hr />";
		 }
		 if($primerTit)
		 {
		   $guardar=false;
		   $primerTit=false;
		   $cadena=str_replace("contenido0","tituloContenido0",$cadena);		   
		   $texto.=$cadena."<br>".chr(10);		   
		 }
		 //QUITAR CODIGO BASURA
		 $cadena = $this->reemplazarCE($cadena);
		 /*----Buscar palabras claves que indican guardar cierto contenido*/
		 for($cont=0; $cont<count($identificador);$cont++)
		 {
		  if(strpos($cadena,$identificador[$cont])!==false) //identificador encontrado
		  {
		  
		    $guardar=true;			
			$cadena=str_replace("contenido0","tituloContenido0",$cadena);
			
			 if($identificador[$cont]=="<b>Glosario" | $identificador[$cont]=="<b>Glossary")
			  $glosario=true;
 		    else 
			  $glosario=false;
			  
			 if($dividir)
			 {
			      if($texto!="") //guardamos y creamos el libro si ya hay contenido
		          {
		           $texto.=$this->getPie();
				   //$texto = $this->reemplazarCE($texto);
				   $texto = $this->iconsRecursos($texto);
	               fwrite($escritura, $texto); //GUARDAMOS TODO
		           fclose($escritura);
				   $texto=$this->getEncabezadoActs(); //codigo de encabezado html para un nuevo archivo		           
		           $escritura = fopen($dirDestino.$tema."_act".$contActs.".html","w"); //creamos el archivo html
		           $contActs++;
 		          }
		          else
			      {
			       $texto=$this->getEncabezadoActs();
		           $escritura = fopen($dirDestino.$tema."_act".$contActs.".html","w"); //creamos el archivo html
		           $contActs++; 
			      }
				   echo "<br>&nbsp;&nbsp;-> <i>".$dirDestino.$tema."_act".($contActs-1).".html</i>";
			 }

			 if($cont==0) //titulo principal
			 {
			  $guardar=false;
			  $primerTit=true; //identificamos el primer titulo, despues
			 }
			 else if(!$primerTit)
			   $texto.=$cadena."<hr />".chr(10);
			$flagIdent=true;
			$titulo=true;
		  }
	     }
		 /*----Buscar los textos claves que omiten guardar cierto contenido*/
		 for($cont=0; $cont<count($omisores);$cont++)
		 {
		  if(strpos($cadena,$omisores[$cont])!==false) //identificador encontrado
		  {
			$guardar=false;
			  if($dividir)
			  {
			     if($texto!="" & $escritura!=NULL) //guardamos y creamos el libro si ya hay contenido
		         {
		           $texto.= $this->getPie();
				   $texto = $this->reemplazarCE($texto);
				   $texto = $this->iconsRecursos($texto);
	               fwrite($escritura, $texto); //GUARDAMOS TODO		           
		           $texto="";		           
 		         }
			  }
		  }
	     }
		
		//if($char!=chr(10))
		 if(!$flagIdent)
		 {
		  if($guardar)
		  {		    
			if($glosario)
			{
			  $cadena=str_replace("<p class='contenido0'","<p class='referencia'",$cadena);
			  if(strpos($cadena,"Fuente:")!==false | strpos($cadena,"Source:")!==false)
			    $cadena=str_replace("<p class='referencia'","<p class='referencia Estilo3'",$cadena);
			}
  	       $texto.=$cadena;
		  }
		 }
		 //else
		 // $texto.="<hr />";
		$cadena="";
		$flagIdent=false;
	   }
	   else
	   {
	     if($char!=chr(10) && $char!=chr(13))
		 {
	       $cadena.=$char; //guardamos caracter por caracter hasta componer una palabra
		 }
	   }
	  }//fin si $bfinEt
	} //fin WHILE
	if(!$dividir)
	{
	  if($archDest=="autoevaluacion.html")
	  {
	   $texto.=$this->getPieAutoevaluacion();
	  }
	  else if($archDest=="preliminar.html" | $archDest=="integradora.html")
	  {
	   $texto.=$this->getPie();
	  }
	  else
       $texto.=chr(10)."</div>".chr(10)."</body>".chr(10)."</html>";
	 $texto = $this->reemplazarCE($texto); //caracteres extraños
	 fwrite($escritura,$texto); //GUARDAMOS TODO
	}
	fclose($lectura);
	fclose($escritura);
	//Mostramos los mensajes hasta el momento enviados en el DIV "consola"
    flush();
    ob_flush();
	echo "<script>document.getElementById('contenedor').scrollTop = 9999999;</script>";
    //
  }catch(Exception $ee){ echo "<scrip>alert('".$ee->getMessage()."')</scrip>";}
 } //fin funcion

 function reemplazarCE($c)  //reenplazar caracteres extraños...
 {
	$c = str_replace("&nbsp;"," ",$c); //quitar	 
    $c = str_replace("  "," ",$c); //los espacios dobles los hacemos unos solo
	$c = str_replace("</td>","",$c); //quitar
	$c = str_replace("<h1>","<p class='contenido0'>",$c); //reemplazar	
	$c = str_replace("</li>","</p></li>",$c); //cierre correctod de li
	$c = str_replace("</h1>","</p>",$c); //reemplazar
   	$c = str_replace("<>","",$c); //llaves sobrantes de <span ...>
	$c = str_replace("</span>","",$c); //quitar
	$c = str_replace("<o:p>","",$c); //quitar
	$c = str_replace("</o:p>","",$c); //quitar
	$c = str_replace("<sup>","",$c); //quitar
	$c = str_replace("</sup>","",$c); //quitar
	
	$c = str_replace("<p class='contenido0'><b> </b></p>","",$c); //quitar
	$c = str_replace("<p class='contenido0'> </p>","",$c); //quitar espacios
	$c = str_replace("<p class='contenido0'>  </p>","",$c); //quitar espacios
	//$c = str_replace("<p class='contenido0'> </p>","",$c); //quitar espacios
	$c = str_replace("<p class='contenido0'></p>","",$c); //quitar espacios
	$c = str_replace("<p class='contenido0'><b></b></p>","",$c); //quitar espacios		
	$c = str_replace("<b></b>","",$c); //quitar
	$c = str_replace("<b> </b>","",$c); //quitar
	$c = str_replace("<li>","<li class='contenido0'><p class='lista'>",$c); //ajustamos la lista
	$c = str_replace("<li><p class='lista'><p class='lista'>","<li class='contenido0'><p class='lista'>",$c); //eliminar duplicidad en autoevaluaciones
	$c = str_replace("</p></p></li>","</p></li>",$c); //detalle en autoevaluaciones
	$c = str_replace("</st1:PersonName>","",$c); //quitar	
	 return $c;
 }
 
 function iconsRecursos($c) //buscamos una palabra clave y si existe la reemplazamos por el href al icono correspondiente
 {
   $icons = Array(array("texto ","libro.png"),
                 array("text ","libro.png"),
				 array("texts ","libro.png"),
                 array("documento ","libro.png"),
				 array("article ","libro.png"),
                 array("lectura ","libro.png"),
				 array("lee ","libro.png"),
				 array("read ","libro.png"),
				 array("foro ","foro.png"),
				 array("forum: ","foro.png"),
				 array("forum ","foro.png"),
				 array("descargar ","descargar.png"),
				 array("download ","descargar.png"),
				 array("subir ","subir.png"),
				 array("audio ","audio.png"),
				 array("wiki ","wiki.png"),
				 array("chat ","chat.png"),
				 array("examen ","examen.png"),
				 array("flash ","flash.png"),
				 array("cuestionario ","cuestionario.png"),
				 array("enviar ","enviar.png")
                 );
	foreach($icons as $icono)
	{
	 $c = str_replace("$icono[0]","$icono[0] <a href='u".$this->unidad."/recursos/.pdf' target='_blank'><img src='public/images/icono/$icono[1]' width='21' height='21' border='0' align='absmiddle'></a>",$c);	  
	}
   $c = str_replace("video ","video <img  id='1' rel='div.overlay' class='video' src='public/images/icono/video.png'  alt='[play al video]' />",$c);   
   return $c;
 }
 
 function getEncabezadoActs() //el encabezado para los HTMLs de las actividades
 {
   return '<!DOCTYPE HTML>
<html>
 <head>
  <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1"/>
   <title>Documento sin t&iacute;tulo</title>
   <link rel="stylesheet" href="../../public/css/txt-style.css" type="text/css"/>
 </head>
<body id="page" class="chrome">
 <div id="content">
 ';
 }
 
 
 function getPie() //siempre al pie de las actividades, el iframe al recurso en plataforma
 {
   return "<div style='margin-left:50px; border:#F00; width:650px;' id='frame'>
 <iframe style='border:6px;' scrolling='Yes' src='URL_AL_RECURSO' title='' frameborder='0' width='650px'  height='500px' ></iframe>
 </div>
</div>
</body>
</html>
<!-- Generado por: Digitalizador v.2014.05 By: Jesus Malo Escobar e-mail: dic.malo@gmail.com fecha:".date('d-M-Y H:i:s')." -->";
 }
 
 function getPieAutoevaluacion() //siempre al pie del html de Autoevaluación para el flash en swf
 {
  return "<div style='margin-left:50px; border:#F00; width:600px;' id='freame' >
   <object classid='clsid:D27CDB6E-AE6D-11cf-96B8-444553540000' codebase='http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=9,0,28,0' width='600' height='750' title='autoevaluacion'>
<param name='movie' value='u".$this->unidad."/recursos/ARCH.swf' />
  <param name='quality' value='high' />
  <embed src='u".$this->unidad."/recursos/ARCH.swf' quality='high' pluginspage='http://www.adobe.com/shockwave/download/download.cgi?P1_Prod_Version=ShockwaveFlash' type='application/x-shockwave-flash' width='600' height='750'></embed>
  </object></div>
 </div>
</body>
</html>
  <!-- Generado por: Digitalizador v.2014.05 By: Jesus Malo Escobar e-mail: dic.malo@gmail.com fecha:".date('d-M-Y H:i:s')." -->";
 }
 
 function setUnidad($u)
 {
  $this->unidad = $u;  
 }
 
 function rrmdir($dir) //si los directorios y subdirectorios ya existen, los eliminamos para colocar nuevamente los HTMLs.
 {
   if (is_dir($dir))
   {
     $objects = scandir($dir);
     foreach ($objects as $object)
	 {
       if ($object != "." && $object != "..")
	   {
         if (filetype($dir."/".$object) == "dir") 
		  $this->rrmdir($dir."/".$object); 
		 else 
		  unlink($dir."/".$object);
       }
     }
     reset($objects);
     rmdir($dir);
   }
 }
 
} //fin clase  
?>