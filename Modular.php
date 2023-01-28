<?php
require_once("digitalizador.php");
require_once("exportador.php");

class Modular extends Digitalizador
{

function iniciar($ruta_mod)
{

 $exp = new Exportador();
 $dirDestino=$_REQUEST['dirdestino'];
 $componente=$_REQUEST["componente"]; //puede ser componente o nivel
 $archivo=NULL;
 
  if(($archivo=$exp->existe("$ruta_mod/$componente general"))!=NULL)
  {
    $this->rrmdir($dirDestino); //si la carpeta ya existe la removemos
    echo "<br>Componente nivel general encontrado<br>";
	 mkdir($dirDestino,0777);
	$exp->exportar($archivo);
    $this->getPresentacionGeneral("$ruta_mod/","$componente general.html", $dirDestino."/"); //digitalizamos el contenido que esta en el "html"	
	//unlink("$ruta_mod/componente general.html");
  }
  
 $xUnidadComp=1;
 //echo "$ruta_mod/uc".$xUnidadComp."/".$componente."_UC";
 while(($archivo=$exp->existe("$ruta_mod/uc".$xUnidadComp."/".$componente."_UC"))!=NULL) //identificar todos los componentes por Subcompetencia
  {
	
    echo "<br>----------------------------";
    echo "<br><b>Unidad de competencia $xUnidadComp</b><br>";
	 mkdir($dirDestino."/uc$xUnidadComp",0777); //crear la carpeta para la UC	 
	$exp->exportar($archivo);
	$this->getPresentacionXUnidad("$ruta_mod/uc$xUnidadComp/",$componente."_UC.html", $dirDestino."/uc$xUnidadComp/"); //digitalizams el contenido que esta en el "html"
	$this->getReferencias("$ruta_mod/uc$xUnidadComp/",$componente."_UC.html", $dirDestino."/uc".$xUnidadComp."/");
	//unlink("$ruta_mod/uc$xUnidadComp/Nivel_UC.html");
   
   $xSubComp=1;
    while(($archivo=$exp->existe("$ruta_mod/uc$xUnidadComp/Subcompetencia $xSubComp/".$componente."_sub".$xSubComp))!=NULL)
    {
	 $this->setUnidad("c".$xUnidadComp."/sub".$xSubComp); //para preparar los links	
     echo "<br><br>->Subcompetencia ".$xSubComp;
	  mkdir($dirDestino."/uc$xUnidadComp/sub$xSubComp",0777);
	 $exp->exportar($archivo);
	 $this->getPresentacionXSubComp("$ruta_mod/uc$xUnidadComp/Subcompetencia $xSubComp/",$componente."_sub".$xSubComp.".html", $dirDestino."/uc$xUnidadComp/sub$xSubComp/");
	 $this->getPreliminar("$ruta_mod/uc$xUnidadComp/Subcompetencia $xSubComp/",$componente."_sub".$xSubComp.".html", $dirDestino."/uc$xUnidadComp/sub$xSubComp/");
	  $this->getActividades("$ruta_mod/uc$xUnidadComp/Subcompetencia $xSubComp/",$componente."_sub".$xSubComp.".html", $xSubComp, $dirDestino."/uc$xUnidadComp/sub$xSubComp/");
	 $this->getIntegradora("$ruta_mod/uc$xUnidadComp/Subcompetencia $xSubComp/",$componente."_sub".$xSubComp.".html", $dirDestino."/uc$xUnidadComp/sub$xSubComp/");
	 $this->getAutoevaluaciones("$ruta_mod/uc$xUnidadComp/Subcompetencia $xSubComp/",$componente."_sub".$xSubComp.".html", $dirDestino."/uc$xUnidadComp/sub$xSubComp/");
	 mkdir($dirDestino."/uc$xUnidadComp/sub$xSubComp/recursos",0777); //crear carpeta para colocar los recursos
	 //unlink("$ruta_mod/uc$xUnidadComp/Subcompetencia $xSubComp/componente_u".$xUnidadComp."t".$xSubComp.".html");
	 $xSubComp++;
    }
   $xUnidadComp++;
  }
}

function getPresentacionGeneral($directorio, $nombreArchivo, $dirDestino)
{
 $identificador = array("#SinTitulo#","Propósito","Carga horaria","Forma de trabajo","Producto final","Subcompetencias");
 $omisores = array("Referencias básicas","</body>"); 
 $this->getPresentacion($directorio, $nombreArchivo, $dirDestino, "presentacion.html", $identificador, $omisores, 0);
}

function getPresentacionXUnidad($directorio, $nombreArchivo, $dirDestino)
{
 $identificador = array("#SinTitulo#","Propósito","Carga horaria","Forma de trabajo","Producto final","Subcompetencias");
 $omisores = array("Referencias básicas","</body>");
 $this->getPresentacion($directorio, $nombreArchivo, $dirDestino, "presentacion.html", $identificador, $omisores, 0); 
}

function getPresentacionXSubComp($directorio, $nombreArchivo, $dirDestino)
{
 $identificador = array("Nombre de la subcompetencia","Descripción de la subcompetencia","Carga horaria","Criterios de evaluación","Evidencia de aprendizaje");
 $omisores = array("Referencias","Actividad de aprendizaje","</body>");
 $this->getPresentacion($directorio, $nombreArchivo, $dirDestino, "presentacion.html", $identificador, $omisores, 0); 
}

function getReferencias($dirOrigen, $nombreArchivo, $dirDestino)
{
 $identificador = array("#SinTitulo#","Referencias","<b>Fuentes de consulta obligatoria","<b>Referencias biblio");
 $omisores = array("Subcompetencias","</body>");
 $this->getPresentacion($dirOrigen, $nombreArchivo, $dirDestino, "referencias.html", $identificador, $omisores, 0);
}

function getPreliminar($directorio, $nombreArchivo, $dirDestino)
{
  $identificador = array("#SinTitulo#","Actividad preliminar", $dirDestino);
  $omisores = array("Actividad de aprendizaje","<b>Actividades de aprendizaje","</body>");
  $this->getPresentacion($directorio, $nombreArchivo, $dirDestino, "preliminar.html", $identificador, $omisores, 0);
}

function getActividades($directorio, $nombreArchivo, $sub, $dirDestino)
{
  $identificador = array("#SinTitulo#","Actividad de aprendizaje");
  $omisores = array("Actividad integradora","</body>");
  $this->getPresentacion($directorio, $nombreArchivo, $dirDestino, "Actividades", $identificador, $omisores, "sub_".$sub);
}

function getIntegradora($directorio, $nombreArchivo, $dirDestino)
{
  $identificador = array("#SinTitulo#","Actividad integradora");
  $omisores = array("<b>Autoevaluación","<b>Autoevaluacion","</body>");
  $this->getPresentacion($directorio, $nombreArchivo, $dirDestino, "integradora.html", $identificador, $omisores, 0);
}

function getAutoevaluaciones($directorio, $nombreArchivo, $dirDestino)
{
  $identificador = array("#SinTitulo#","<b>Autoevaluación","<b>Autoevaluacion");
  $omisores = array("</body>");
  $this->getPresentacion($directorio, $nombreArchivo, $dirDestino, "autoevaluacion.html",$identificador, $omisores, 0);
}
}
?>