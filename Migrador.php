<?php
/* Nombre de la aplicacion: "Migrador.php"
   Version: 2014.07.04
   Autor: Jesus Malo Escobar
   e-mail: dic.malo@gmail.com
*/
date_default_timezone_set('America/Mexico_City');
class Migrador
{

var $unidad=1, $numActividad=0, $numTema=1;

/*GENERA PRESENTACIONES, ACTIVIDADES Y AUTOEVALUACIONES*/
function getPresentacion($dirOrigen, $nombreArchivo, $dirDestino, $archDest)
{
$lectura = fopen($dirOrigen.$nombreArchivo,"r");
$escritura = NULL;
 
 if(!$lectura)
 {
   echo "<p>$nombreArchivo No Existe :-P</p>";	
  return;
 }
   echo "<br>-> <i>$archDest</i>";
   $cadena="";
   $cadenaAux="";
   $char="";
   $primerArticulo=true;
   $pUP=false;
   $texto="";
  if(strpos($archDest,"tema_")!==false)
   $texto = $this->getEncabezadoActs();
  else if($archDest=="autoevaluacion.html")  
	$texto.=$this->getCodigoAutoevaluacion();  	
  else
   $texto = $this->getEncabezado();

   $escritura=fopen($dirDestino.$archDest,"w");

   $cA=""; //caracter anterior
   $cAA=""; //antes del anterior
   $copiarTodo=false;
 try
 {
  if($archDest=="autoevaluacion_blank.html")
  {
	$texto = file_get_contents($dirOrigen.$nombreArchivo);
	$texto = $this->getAutoevaluacionBlank($texto);
  }
  else if($archDest!="autoevaluacion.html")
  {
    while(!feof($lectura))
	{
	 $cAA=$cA;
	 $cA=$char;     
	 $char = fgetc($lectura); //obtenemos caracter por caracter	 
	 	   
     if(!$copiarTodo)
	  if ($cA.$char=="<p")
	   {
		 /*si encontramos la primer etiqueta de parrafo empezamos a copiar todo*/  
		 $cadena = "<";
	     $copiarTodo=true;
	   }
	 if($copiarTodo)
	 {	 
	  $cadena.=$char; //vamos concatenando la cadena
	  if($cA.$char=="<p" | $cA.$char=="<P")
	   $pUP=true; //variable etiqueta p true para buscar fin </p>
       if($cAA.$cA.$char=="/p>" | $cAA.$cA.$char=="/P>")
	   {
		 //cambiamos los tituloUnidad
		 $pUP=false;
         if( strpos($cadena,"tituloUnidad")!==false){
			$cadena = $this->getTitle($cadena);
			$texto.=$cadena.chr(10);
			//$texto.=chr(10)."<article class=\"ar-content\">";
			$cadena="";
		 }
		 //cambiamos los tituloContenido0
		 if( strpos($cadena,"tituloContenido0")!==false){			
		    if(!$primerArticulo) 
			 $texto.=chr(10)."</article>";
			else
			 $primerArticulo=false;//entramos en el primer articulo ponemos false
			//si es actividad copiamos codigo para titulo de actividad
			if($this->numActividad!=0)
			{
			 $cadena = $this->getTitleActivity($cadena);
			 $texto.=$cadena;
			}
			else
			{  
			 $cadena = $this->getHeader($cadena);
			 $texto.=$cadena."<article class=\"ar-content\">";
			}
			//$texto.=$cadena."</article>";
			
			$cadena="";
		 }
		 //cambiamos contenido0 a content
		 if(strpos($cadena,"contenido0")!==false){
			$cadena = str_replace("contenido0","content",$cadena);
			$texto.=$cadena;
			$cadena="";
		 }
		 //reemplazamos referencia por reference
		 if(strpos($cadena,"referencia")!==false){
			$cadena = str_replace("referencia","reference",$cadena);
			$texto.=$cadena.chr(10);
			$cadena="";
		 }
		 if($cadena!="")
		 {
			$texto.=$cadena;
			$cadena=""; 
		 } 		 
	   } //fin if
	   else if($char==">")
	   {		
		 /*eliminar fragmentos no necesarios en ul, ol, iframe, reemplazar <img*/
		 if(strpos($cadena,"<ul")!==false){
		   $cadena = chr(10)."<ul class=\"list\">";
		 }
		 if(strpos($cadena,"<ol")!==false){
		   $cadena = chr(10)."<ol class=\"list\">";
		 }
		 if(strpos($cadena,"<iframe")!==false){
		   $copiando = false;
		   $cadenaAux = "<iframe class='activity' scrolling='auto' src=";
		   $finSrc="'";
		   for($i=0; $i<strlen($cadena); $i++)
		   {
			 if($copiando)
			 {
			   $cadenaAux.=$cadena[$i];
			    if($cadena[$i]==$finSrc)
				{
				 $cadenaAux.=">";
				 $i = 10000; //salimos del for
				}
			 }
             else if($cadena[$i]=="s" & $cadena[$i+1]=="r" & $cadena[$i+2]=="c")
			 {
			  $finSrc = $cadena[$i+4];
              $cadenaAux.=$finSrc;
			  $copiando = true;
			  $i=$i+4;
			 }
		   }//for		   
		   $cadena = $cadenaAux;
		 }//if <iframe	
		 
		 if(strpos($cadena,"<img")!==false){
		   $copiando = false;
		   $cadenaAux = "";
		   $cont_slash=0;
		   
		   for( $cont=0; $cont<strlen($cadena); $cont++)
		   {
		    if($cadena[$cont]=="<" & $cadena[$cont+1]=="i" & $cadena[$cont+2]=="m" & $cadena[$cont+3]=="g")
			{				
			 $cont=strpos($cadena,"<img"); //anotamos la pos de img
			 break;
			}
			else
			 $cadenaAux.=$cadena[$cont];
		   }
		   
		   $cadenaAux.="<span class=\"icon ";
		   
		   for( $xx=$cont ; $xx<strlen($cadena); $xx++)
		   {
			 if($copiando)
			 {
			   if($cadena[$xx]==".") //el (.) indica inicio de extencion .png
				$xx = 10000; //salimos del for
			   else 
				$cadenaAux.=$cadena[$xx]; 
			 }
             else if($cadena[$xx]=="/")
			 {
			  $cont_slash++;
			  if($cont_slash==3)
			   $copiando = true;
			 }
		   }//for	
		   $cadenaAux.="\"></span>";
		   $cadena = $cadenaAux;
		}//if
		 
		 
		 if(!$pUP)
		 {
		   $texto.=$cadena;	 
		   $cadena="";
		 }		   
		
	   }//if ">"
     }//fin si copiarTodo	  
	 
	} //fin WHILE
	$texto=$this->reemplazarCE($texto); //quitamos etiquetas innecesarias 
    $texto.=$this->getPie();
  }
  
	fwrite($escritura,$texto); //GUARDAMOS TODO
	fclose($lectura);
	fclose($escritura);
	//Mostramos los mensajes hasta el momento enviados en el DIV "consola"
    flush();
    ob_flush();
	echo "<script>document.getElementById('contenedor').scrollTop = 9999999;</script>";
    //
  }catch(Exception $ee){ echo "<scrip>alert('".$ee->getMessage()."')</scrip>";}
 } //fin funcion
 
 function getTitle($cadena){
	$cadena = str_replace("<p","<article",$cadena);
	$cadena = str_replace("tituloUnidad","ar-title",$cadena);
	$cadena = str_replace("p>","article>",$cadena);
	return $cadena;
 }
 
 function getHeader($cadena){
	$cadena = str_replace("<p","<article",$cadena);
	$cadena = str_replace("tituloContenido0","ar-header",$cadena);
	$cadena = str_replace("p>","article>",$cadena);
	$cadenaAux = $cadena; //copiar linea para duplicar y tener ar-movilhd
	$cadenaAux = str_replace("ar-header","ar-movilhd",$cadenaAux);
	$cadena.=$cadenaAux.chr(10); 
	return $cadena;
 }
 
 function getTitleActivity($cadena){
	$cadena = str_replace("<p","<article",$cadena);
	$cadena = str_replace("tituloContenido0","ar-title",$cadena);
	$cadena = str_replace("p>","article>",$cadena);
	return $cadena;
 }

//Quitamos todo el codigo innecesario para exportar
 function reemplazarCE($c)
 {
	$c = str_replace("<p class=\"lista\">","",$c); //quitar
	$c = str_replace('<li class="contenido0">',"<li>",$c); //quitar	
	$c = str_replace("</p></li>","</li>",$c); //quitar
	$c = str_replace("Estilo3","reference",$c); //quitar
	$c = str_replace("reference reference","reference",$c); //quitar
	$c = str_replace("<hr/>","",$c); //quitar
	$c = str_replace("<hr />","",$c); //quitar
	$c = str_replace("<span class=\"icon >\"></span>","<span class=\"ar-video\" ar=\"u".$this->unidad."/recursos/VIDEO\" title=\"TITULO\"></span>",$c); //quitar
	
	$c = str_replace('<div style="margin-left:50px; border:#F00; width:650px;" id="freame" >',"",$c); //quitar div para frame
	$c = str_replace("<div style='margin-left:50px; border:#F00; width:650px;' id='frame'>","",$c); //quitar div para frame
	
   //si estamos migrando actividades quitamos los </div>
    if($this->numActividad>0)
	{
     $c = str_replace("</div>","",$c);
	}
	else
	{
	 $c = str_replace("</div>   
</div>","</article>",$c); //quitar	
	 $c = str_replace("</div>","</article>",$c); 
	}
	/*reemplazamos instrucciones ténicas viejas*/
	$c = $this->inst_subirArchivo($c);
	$c = $this->inst_foro($c);
	$c = $this->inst_textoEnLinea($c);
	return $c;
 }
 
 function inst_subirArchivo($c){
	 /*subir archivo*/
	$c = str_replace("This file must be saved with a name alluding to the subject. To send,  click &quot;Examinar&quot;. Locate and select a file on your computer. Click  &quot;Abrir&quot; and verify that the file name appears in the box. Finally,  click &quot;Subir este archivo&quot;.","This file must be saved with a name alluding to the subject. To send it, click on “Agregar entrega”. Then, drag and drop the file to start loading. Once complete it, click on “Guardar cambios”.",$c); 
	$c = str_replace("Do your activity in a Word or PowerPoint file. This file must be saved with a name alluding to the subject. To send, click &quot;Examinar&quot;. Locate and select a file on your computer. Click &quot;Abrir&quot; and verify that the file name appears in the box. Finally, click &quot;Subir este archivo&quot;.","This file must be saved with a name alluding to the subject. To send it, click on “Agregar entrega”. Then, drag and drop the file to start loading. Once complete it, click on “Guardar cambios”.",$c);
	$c = str_replace("Do your activity in a Word file. This file must be saved with a name alluding to the subject. To send, click &quot;Examinar&quot;. Locate and select a file on your computer. Click &quot;Abrir&quot; and verify that the file name appears in the box. Finally, click &quot;Subir este archivo &quot;.","This file must be saved with a name alluding to the subject. To send it, click on “Agregar entrega”. Then, drag and drop the file to start loading. Once complete it, click on “Guardar cambios”.",$c);
	return $c;
 }
 
 function inst_foro($c){
	/*de uso general*/ 
	$c = str_replace("To participate, click &quot;Colocar  un nuevo tema de discusi&oacute;n aqu&iacute;&quot; in the
window that indicates the subject appear in  &quot;Asunto&quot; and enter your comments;  to submit press &quot;Enviar a  foro&quot;.","To participate, click on “Añadir un nuevo tema de discusión”. In the pop- out that appears indicate the subject in “Asunto”. Write your comment in the box “Mensaje”; to send it, click on “Enviar al foro”.",$c);
	 $c = str_replace("To participate, click &quot;Colocar un nuevo tema de discusión aquí&quot; in the window that indicates the subject appear in &quot;Asunto&quot; and enter your comments; to submit press &quot;Enviar a foro&quot;.","To participate, click on “Añadir un nuevo tema de discusión”. In the pop- out that appears indicate the subject in “Asunto”. Write your comment in the box “Mensaje”; to send it, click on “Enviar al foro”.",$c);
	 /*de uso general con opcion subir archivo*/
	 $c = str_replace("To participate, click &quot;Colocar un Nuevo tema de discussion aquí&quot; in the window that indicates the subject appear in &quot;Asunto&quot; and type your comment. To send your file click &quot;Examinar&quot;. Locate and select your file in the computer. Click &quot;Abrir&quot; and check that your file has been uploaded. Finally, click &quot;Enviar al foro&quot;.","To participate, click on “Añadir un nuevo tema de discusión”. In the pop- out that appears indicate the subject in “Asunto”. Write your comment in the box “Mensaje”. Click inside the box, then, click on “Subir un archivo” and locate and select your file. After that, click on “Abrir”. Set the name of your file in “Guardar como” and click on “Subir este archivo”. Verify your file is inside the white box; if not, repeat the previous step. Finally, click on “Enviar al foro”",$c);	 
	 /*de debate sencillo*/
	 $c = str_replace("To participate click &quot;Responder&quot;. In the window that appears enter your comment, to submit click &quot;Enviar al foro&quot;.","To participate, click on “Responder”. Write your comment in the box “Mensaje”; to send it, click on “Enviar al foro”.",$c);
	 /*debate sencillo con opcion subir archivo*/
	 $c = str_replace("To participate click &quot;Responder&quot;. In the window that appears enter your comment. To send your file click &quot;Examinar&quot;. Locate and select your file on the computer. Click &quot;Abrir&quot; and check that your file has been loaded. Finally, click &quot;Enviar al foro&quot;.","To participate click “Responder”. In the window that appears enter your comment. To send your file click “Examinar”. Locate and select your file on the computer. Click “Abrir” and check that your file has been loaded. Finally, click “Enviar al foro”.",$c);
	 /*cada quien plantea un tema P-R*/
	 $c = str_replace("To participate, click &quot;Colocar un nuevo tema de discusión aquí&quot; in the window that indicates the subject appear in &quot;Asunto&quot; and enter your comments; to submit press &quot;Enviar a foro&quot;.","To participate, click on “Añadir un nuevo tema de discusión”. In the pop- out that appears indicate the subject in “Asunto”. Write your comment in the box “Mensaje”; to send it, click on “Enviar al foro”.",$c);
	return $c; 
 }
 
 function inst_textoEnLinea($c){
   	 $c = str_replace("Click &quot;Editar mi envio&quot;. Write your answer in the box blank appears.  When finished press &quot;Guardar cambios&quot;. In case you want exit the  editor without saving the latest changes, click &quot;Cancelar.&quot;","To add your comment, click on “Agregar entrega”. Write your answer in the box that will appear. When you finish, click on “Guardar cambios”. In case you want exit the editor without saving the latest changes, click on “Cancelar.”",$c);
	return $c;
 }
 
 function iconsRecursos($c) //buscamos una palabra clave y si existe la reemplazamos por el href al icono correspondiente
 {     
   return $c;
 }
  
 function getEncabezado(){
	 return '<!DOCTYPE html>
<html><head><meta charset="utf-8" /><title>Unach virtual</title></head>
<body>
';
 }
 
 function getEncabezadoActs() //el encabezado para los HTMLs de las actividades
 {
   return '<!DOCTYPE html>
<html><head><meta charset="utf-8" /><title>Unach virtual</title></head>
<body>
 ';
 }
 //<article class="ar-title">Learning activity '.$this->numActividad.'</article>
 
 function getPie() //siempre al pie de las actividades, el iframe al recurso en plataforma
 {
   return '
<!-- Generado mediante: Migrator v.2014.07 By: Jesus Malo Escobar e-mail: dic.malo@gmail.com fecha:'.date("d-M-Y H:i:s").' -->';
 }
 
 function getCodigoAutoevaluacion() //siempre al pie del html de Autoevaluaci�n para el flash en swf
 {
  return '<!DOCTYPE html>
<html><head><meta charset="utf-8" /><title>Unach virtual</title></head>
<body> 
	<article class="ar-title">Self-assessment</article>
    <p class="content"></p>
    <figure>
    	<a href="u'.$this->unidad.'/tema'.$this->numTema.'/autoevaluacion_blank.html" target="_blank">
        	<span></span>
            <figcaption>TIPO_AUTOEVALUACION</figcaption>
        </a>
	</figure>
</body>
</html>
  <!-- Generado mediante: Migrator v.2014.07 By: Jesus Malo Escobar e-mail: dic.malo@gmail.com fecha: '.date('d-M-Y H:i:s').' -->';
 }
 
 function getAutoevaluacionBlank($texto)
 {
	$texto = str_replace("<html>
<head>
<meta http-equiv='Content-Type' content='text/html; charset=iso-8859-1'/>
<title>Documento sin t&iacute;tulo</title>
<link rel='stylesheet' href='../../public/css/txt-style.css' type='text/css'/>
</head>
<body id='page' class='chrome'>
<div id='content'>","<!DOCTYPE html>
<html><head><meta charset=\"utf-8\" /><title>Unach virtual</title></head>
<body>",$texto);
	$texto = str_replace("<p class='tituloContenido0'><b>Self- assessment</b></p>","<article class=\"ar-title\" align=\"center\">Self-assessment</article>",$texto);
	$texto = str_replace("<p class='tituloContenido0'><b>Self-assessment</b></p>","<article class=\"ar-title\" align=\"center\">Self-assessment</article>",$texto);	
	$texto = str_replace("<hr />","",$texto);
	$texto = str_replace("<div style='margin-left:50px; border:#F00; width:650px;' id='freame' >","<p align=\"center\">",$texto);
	$texto = str_replace("<div style='margin-left:50px; border:#F00; width:600px;' id='freame' >","<p align=\"center\">",$texto);
	$texto = str_replace("</object>","</object>
	</p>",$texto);
	$texto = str_replace("</div>","",$texto);
	$texto = str_replace("'contenido0'","\"content\"",$texto);
	$texto = str_replace("\"contenido0\"","\"content\"",$texto);
	$texto = str_replace("u".$this->unidad."/","../",$texto); /*indicamos la nueva ruta*/
	return $texto; 
 }
 
 function setUnidad($u)
 {
  $this->unidad = $u; 
  echo  $this->unidad;
 }
 
 function setTema($nt)
 {
  $this->numTema = $nt;
 }
 
 function setActividad($na)
 {
   $this->numActividad = $na;
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