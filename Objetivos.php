<?php
/* Nombre de la aplicacion: "digitalizador"
   Version: 2012.10.03
   Autor: Jesus Malo Escobar
   e-mail: dic.malo@gmail.com
*/
require_once("digitalizador.php");
require_once("exportador.php");

class Objetivos extends Digitalizador
{

function iniciar($ruta_mat)
{

 $exp = new Exportador();
 $dirDestino=$_REQUEST['dirdestino'];
 $componente=$_REQUEST["componente"]; //puede ser componente o nivel
 $tema = "Tema";
 $archivo=NULL;
 
  if(($archivo=$exp->existe("$ruta_mat/$componente general"))!=NULL)
  {  
    $this->rrmdir($dirDestino);
    echo "<br>Componente general encontrado<br>";
	 mkdir($dirDestino,0777); //creamos el directorio principal donde se guardara de acuerdo a la estructura
	$exp->exportar($archivo);	 	
    $this->getPresentacionGeneral("$ruta_mat/","$componente general.html", $dirDestino."/"); //digitalizamos el contenido que esta en el "html"	
	$this->getReferencias("$ruta_mat/","$componente general.html", $dirDestino."/");
	$this->getFormaTrabajo("$ruta_mat/","$componente general.html", $dirDestino."/");
	//unlink("$ruta_mat/componente general.html");
  }
  
  $xUnidad=1;
  while(($archivo=$exp->existe("$ruta_mat/unidad $xUnidad/".$componente."_u".$xUnidad))!=NULL) //identificar todos los componentes por unidad
  {
   
   $this->setUnidad($xUnidad); //indicamos de que unidad son los recursos que irán en la carpeta "recursos"
    echo "<br>----------------------------";
    echo "<br><b>".$componente."_u$xUnidad</b><br>";
	 mkdir($dirDestino."/u$xUnidad",0777); //crear directorio para las unidades
	 mkdir($dirDestino."/u$xUnidad/recursos",0777); //crear directorio para los recursos
	$exp->exportar($archivo);	
	$this->getPresentacionXUnidad("$ruta_mat/unidad $xUnidad/","".$componente."_u".$xUnidad.".html", $dirDestino."/u$xUnidad/"); 
	//unlink("$ruta_mat/unidad $xUnidad/".$componente."_u".$xUnidad.".html");
   
   $xTema=1;
    while(($archivo=$exp->existe("$ruta_mat/unidad $xUnidad/tema $xTema/".$componente."_u".$xUnidad."t".$xTema))!=NULL)
    {
     echo "<br><br>**".$componente."_u".$xUnidad."t".$xTema."**";
	  mkdir($dirDestino."/u$xUnidad/tema$xTema",0777); //crear directorio
	 $exp->exportar($archivo);
	 $this->getPresentacionXTema("$ruta_mat/unidad $xUnidad/tema $xTema/","".$componente."_u".$xUnidad."t".$xTema.".html", $dirDestino."/u$xUnidad/tema$xTema/");
	 $this->getActividades("$ruta_mat/unidad $xUnidad/tema $xTema/","".$componente."_u".$xUnidad."t".$xTema.".html", $xTema, $dirDestino."/u$xUnidad/tema$xTema/");
	 $this->getAutoevaluaciones("$ruta_mat/unidad $xUnidad/tema $xTema/","".$componente."_u".$xUnidad."t".$xTema.".html", $dirDestino."/u$xUnidad/tema$xTema/");
	 //unlink("$ruta_mat/unidad $xUnidad/tema $xTema/".$componente."_u".$xUnidad."t".$xTema.".html");
	 $xTema++;	    
    }        
   $xUnidad++;   
  }
}

function getPresentacionGeneral($dirOrigen, $nombreArchivo, $dirDestino)
{
 $identificador = array("<b>Título","<b>Titulo","<b>Introducción","estimado de estudio","<b>Propósito Gen","<b>Objetivo general","<b>Competencia específica","<b>Unidades","<b>Forma de trabajo");
 $omisores = array("<b>Diagrama conceptual","<b>Fuentes de consulta","<b>Criterios de acredita","</body>"); 
 $this->getPresentacion($dirOrigen, $nombreArchivo, $dirDestino, "presentacion.html", $identificador, $omisores, 0);
}

function getReferencias($dirOrigen, $nombreArchivo, $dirDestino)
{
 $identificador = array("#SinTitulo#","<b>Fuentes de consulta obligatoria","<b>Referencias biblio");
 $omisores = array("Forma de trabajo","</body>");
 $this->getPresentacion($dirOrigen, $nombreArchivo, $dirDestino, "referencias.html", $identificador, $omisores, 0);
}

function getFormaTrabajo($dirOrigen, $nombreArchivo, $dirDestino)
{
 $identificador = array("#SinTitulo#","<b>Forma de trabajo");
 $omisores = array("<b>Criterios de acreditación","</body>");
 $this->getPresentacion($dirOrigen, $nombreArchivo, $dirDestino, "forma.html", $identificador, $omisores, 0);
}

function getPresentacionXUnidad($dirOrigen, $nombreArchivo, $dirDestino)
{
 $identificador = array("<b>Unidad","<b>Carga horaria","<b>Carga Horaria","<b>Introducción","<b>Propósito particular","<b>Objetivo","<b>Resultados de aprendizaje","<b>Temario","<b>Glosario","<b>Evaluación final","<b>Resumen de la unidad");
 $omisores = array("</body>");
 $this->getPresentacion($dirOrigen, $nombreArchivo, $dirDestino, "presentacion.html", $identificador, $omisores, 0); 
}

function getPresentacionXTema($dirOrigen, $nombreArchivo, $dirDestino)
{
 $identificador = array("<b>Título","<b>Titulo","<b>Carga horaria","<b>Carga Horaria","<b>Resultado de aprendizaje","<b>Objetivo particular","<b>Objetivos particulares","<b>Objetivo","<b>Contenido /","<b>Contenido/","<b>Evidencias","<b>Fuentes de");
 $omisores = array("<b>ACTIVIDADES","</body>");
 $this->getPresentacion($dirOrigen, $nombreArchivo, $dirDestino, "presentacion.html", $identificador, $omisores, 0); 
}

function getActividades($dirOrigen, $nombreArchivo, $tema, $dirDestino)
{
  $identificador = array("#SinTitulo#","Actividad de aprendizaje");
  $omisores = array("Autoevaluación","</body>");
  $this->getPresentacion($dirOrigen, $nombreArchivo, $dirDestino, "Actividades", $identificador, $omisores, "tema_".$tema);
}

function getAutoevaluaciones($dirOrigen, $nombreArchivo, $dirDestino)
{
  $identificador = array("#SinTitulo#","Autoevaluación","autoevaluación");
  $omisores = array("Examen final","</body>");
  $this->getPresentacion($dirOrigen, $nombreArchivo, $dirDestino, "autoevaluacion.html",$identificador, $omisores, 0);
}
}
?>