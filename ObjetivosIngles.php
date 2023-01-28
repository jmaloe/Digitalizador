<?php
/* Nombre de la aplicacion: "digitalizador"
   Version: 2012.10.03
   Autor: Jesus Malo Escobar
   e-mail: dic.malo@gmail.com
*/
require_once("digitalizador.php");
require_once("exportador.php");

class ObjetivosIngles extends Digitalizador
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
    echo "<br>Componente general detectado<br>";	
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
   $this->setUnidad($xUnidad);
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
 $identificador = array("<b>Unit","<b>Introduction","Working time","General objective","<b>Competency","<b>Units","Didactic units","<b>Ways of working");
 $omisores = array("<b>Assessment criteria","<b>Conceptual","<b>Mandatory source","<b>Evaluation","</body>"); 
 $this->getPresentacion($dirOrigen, $nombreArchivo, $dirDestino, "presentacion.html", $identificador, $omisores, 0);
}

function getReferencias($dirOrigen, $nombreArchivo, $dirDestino)
{
 $identificador = array("#SinTitulo#","<b>Mandatory source","<b>References");
 $omisores = array("Ways of working","</body>");
 $this->getPresentacion($dirOrigen, $nombreArchivo, $dirDestino, "referencias.html", $identificador, $omisores, 0);
}

function getFormaTrabajo($dirOrigen, $nombreArchivo, $dirDestino)
{
 $identificador = array("#SinTitulo#","<b>Ways of working");
 $omisores = array("<b>Evaluation","</body>");
 $this->getPresentacion($dirOrigen, $nombreArchivo, $dirDestino, "forma.html", $identificador, $omisores, 0);
}

function getPresentacionXUnidad($dirOrigen, $nombreArchivo, $dirDestino)
{
 $identificador=array("<b>Unit","<b>Didactic","<b>Working time","<b>Introduction","<b>Main objective","<b>Learning result","<b>Topic","<b>Glossary","<b>Glosary","<b>Final"/*Final Evaluation*/,"<b>Summary","<b>Thematic");
 $omisores = array("</body>");
 $this->getPresentacion($dirOrigen, $nombreArchivo, $dirDestino, "presentacion.html", $identificador, $omisores, 0); 
}

function getPresentacionXTema($dirOrigen, $nombreArchivo, $dirDestino)
{
 $identificador = array("<b>Title","<b>Titulo","<b>Working","<b>Learning result","<b>Content","<b>Evidence","<b>Source of");
 $omisores = array("<b>ACTIVITIES","</body>");
 $this->getPresentacion($dirOrigen, $nombreArchivo, $dirDestino, "presentacion.html", $identificador, $omisores, 0); 
}

function getActividades($dirOrigen, $nombreArchivo, $tema, $dirDestino)
{
  $identificador = array("#SinTitulo#","<b>Learning activity","<b>Learning Activity");
  $omisores = array("<b>Self-assessment","<b>Self-","</body>");
  $this->getPresentacion($dirOrigen, $nombreArchivo, $dirDestino, "Actividades", $identificador, $omisores, "tema_".$tema);
}

function getAutoevaluaciones($dirOrigen, $nombreArchivo, $dirDestino)
{
  $identificador = array("#SinTitulo#","Self-assessment","Self-");
  $omisores = array("Final Exam","</body>");
  $this->getPresentacion($dirOrigen, $nombreArchivo, $dirDestino, "autoevaluacion.html",$identificador, $omisores, 0);
}

}
?>