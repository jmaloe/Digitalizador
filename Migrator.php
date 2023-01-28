<?php
/* Nombre de la aplicacion: "Migrator"
   Version: 2014.07.04
   Autor: Jesus Malo Escobar
   e-mail: dic.malo@gmail.com
*/
require_once("Migrador.php");
//require_once("exportador.php");

class Migrator extends Migrador
{

function iniciar($ruta_mat)
{

 //$exp = new Exportador();
 $dirDestino=$_REQUEST['dirdestino'];
 //$componente=$_REQUEST["componente"]; //puede ser componente o nivel
 //$tema = "Tema";
 //$archivo=NULL;
 
  if(file_exists("$ruta_mat/presentacion.html"))
  {
    $this->rrmdir($dirDestino);
    echo "<br>presentacion.html encontrada<br>";
	 mkdir($dirDestino,0777); //creamos el directorio principal donde se guardara de acuerdo a la estructura
	//$exp->exportar($archivo);	
	/*PRESENTACION*/ 	
    $this->getPresentacion("$ruta_mat/","presentacion.html", $dirDestino."/", "presentacion.html"); //digitalizamos el contenido que esta en el "html"	
	/*REFERENCIAS*/
	$this->getPresentacion("$ruta_mat/","referencias.html", $dirDestino."/","referencias.html");
	/*FORMA DE TRABAJO*/
	$this->getPresentacion("$ruta_mat/","forma.html", $dirDestino."/", "formatrabajo.html");
	//unlink("$ruta_mat/componente general.html");
  }
  
  $xUnidad=1;
  while(file_exists("$ruta_mat/u".$xUnidad."/presentacion.html")) //identificar todos los componentes por unidad
  {
   
   $this->setUnidad($xUnidad); //indicamos de que unidad son los recursos que irán en la carpeta "recursos"
    echo "<br><br>Migrando......<br>";
    echo "<b>Unidad ".$xUnidad."</b>";
	 mkdir($dirDestino."/u$xUnidad",0777); //crear directorio para las unidades
	 mkdir($dirDestino."/u$xUnidad/recursos",0777); //crear directorio para los recursos
	/*PRESENTACION POR UNIDAD: uX/index.html*/
	$this->getPresentacion("$ruta_mat/u".$xUnidad."/","presentacion.html", $dirDestino."/u".$xUnidad."/", "index.html");
	//unlink("$ruta_mat/unidad $xUnidad/".$componente."_u".$xUnidad.".html");
   
   $xTema=1;
    while(file_exists("$ruta_mat/u$xUnidad/tema$xTema/presentacion.html"))
    {
     echo "<br><br>** Tema ".$xTema."**";	 
	  mkdir($dirDestino."/u$xUnidad/tema$xTema",0777); //crear directorio
	 /*PRESENTACION POR TEMA: uX/temaX/index.html*/
	 /*si hay parcial lo copiamos a la nueva plantilla*/
	 if(file_exists("$ruta_mat/u$xUnidad/tema$xTema/parcial.html")){
	  echo "Examen parcial encontrado";	 
		if(!copy("$ruta_mat/u$xUnidad/tema$xTema/parcial.html",$dirDestino."/u$xUnidad/tema$xTema/parcial.html"))
		 echo "Error al copiar $ruta_mat/u$xUnidad/tema$xTema/parcial.html"; 
	 }
	 if(file_exists("$ruta_mat/u$xUnidad/tema$xTema/final.html")){
	  echo "Examen final encontrado";	 
		if(!copy("$ruta_mat/u$xUnidad/tema$xTema/final.html",$dirDestino."/u$xUnidad/tema$xTema/final.html"))
		 echo "Error al copiar $ruta_mat/u$xUnidad/tema$xTema/final.html"; 
	 }
	 $this->setTema($xTema);
	 $this->getPresentacion("$ruta_mat/u$xUnidad/tema$xTema/","presentacion.html", $dirDestino."/u$xUnidad/tema$xTema/", "index.html");
	 $nAct=1;
	 while(file_exists("$ruta_mat/u$xUnidad/tema".$xTema."/tema_".$xTema."_act".$nAct.".html"))
	 {
	   $this->setActividad($nAct);
	   /*ACTIVIDADES : tema_1_act1.html*/
	   $this->getPresentacion("$ruta_mat/u".$xUnidad."/tema".$xTema."/","tema_".$xTema."_act".$nAct.".html", $dirDestino."/u".$xUnidad."/tema".$xTema."/","tema_".$xTema."_act".$nAct.".html");
	   $nAct++;
     }
	 $this->setActividad(0); //indicamos que no estamos migrando actividades
	 /*AUTOEVALUACIONES: autoevaluacion.html*/
	 $this->getPresentacion("$ruta_mat/u".$xUnidad."/tema".$xTema."/","autoevaluacion.html", $dirDestino."/u".$xUnidad."/tema".$xTema."/", "autoevaluacion.html");
	  $this->getPresentacion("$ruta_mat/u".$xUnidad."/tema".$xTema."/","autoevaluacion.html", $dirDestino."/u".$xUnidad."/tema".$xTema."/", "autoevaluacion_blank.html");
	 /*copiamos la autoevaluación a autoevaluacion_blank para uso TEMPORAL*/
	 /*if(!copy("$ruta_mat/u".$xUnidad."/tema".$xTema."/autoevaluacion.html",$dirDestino."/u".$xUnidad."/tema".$xTema."/autoevaluacion_blank.html"))
	 {
	  echo "No se pudo copiar la autoevaluación";
	 }*/
	 //unlink("$ruta_mat/unidad $xUnidad/tema $xTema/".$componente."_u".$xUnidad."t".$xTema.".html");
	 $xTema++;	    
    }        
   $xUnidad++;   
  }
 }
 
 function full_copy( $source, $target ) {
   if ( is_dir( $source ) ) {
        @mkdir( $target );
        $d = dir( $source );
        while ( FALSE !== ( $entry = $d->read() ) ) {
            if ( $entry == '.' || $entry == '..' ) {
                continue;
            }
            $Entry = $source . '/' . $entry; 
            if ( is_dir( $Entry ) ) {
                full_copy( $Entry, $target . '/' . $entry );
                continue;
            }
            copy( $Entry, $target . '/' . $entry );
        }
 
        $d->close();
    }else {
        copy( $source, $target );
    }
 }
 
}
?>