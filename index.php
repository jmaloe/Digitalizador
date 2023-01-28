<?php 
/* Nombre de la aplicacion: "digitalizador"
   Version: 2012.10.03
   Autor: Jesus Malo Escobar
   e-mail: dic.malo@gmail.com
*/
require_once("exportador.php");
require_once("digitalizador.php");
require_once("Objetivos.php");
require_once("ObjetivosIngles.php");
require_once("Modular.php");
require_once("Migrator.php");
require_once("Migrador.php");
 /*if(@chdir('materia')) //entra en contradiccion con el file_exists y no permite avanzar
 { 
  echo "directorio disponible<br>";
 }*/
?>
<head>
 <script src="jquery-1.9.1.min.js"></script>
 <style type='text/css'> 
 #consola{color:#009900; font-size:15px; font-family:Arial; background:#000000; text-align:left;overflow:scroll;padding:5px 5px 5px 5px; height:550px;-webkit-border-radius:12px;overflow:auto}
 #contenedor{text-align:left;background:#fff;border:1px solid #ccc;-webkit-box-shadow:rgba(0,0,0,0.2) 0px 0px 5px;-moz-box-shadow:rgba(0,0,0,0.2) 0px 0px 5px;-o-box-shadow:rgba(0,0,0,0.2) 0px 0px 5px;box-shadow:rgba(0,0,0,0.2) 0px 0px 5px}
 #contenedor{margin:0 auto 10px auto;width:545px; padding:5px 5px 5px 5px}
 </style>
</head>
<body background="background-pagina.jpg"> 
<div id="contenedor" align="center" style="width:640px;background:url(background-formulario.jpg)">
<form name='conso' method='post'>
<hr />
<table width="635" border="0" cellpadding="1" cellspacing="6">
 <tr>
  <td>
   <b>Directorio origen:</b>
  </td>
  <td>
   <input type='text' style="color:#666666" name='mat' placeholder='Ruta de la materia, ej. C:/materia/' size="70%" value="<?php if(isset($_REQUEST['mat'])) echo $_REQUEST['mat']; ?>" required>
  </td>
 </tr>
 <tr>
  <td>
   <b>Directorio destino:</b>
  </td>
  <td>
   <input type='text' style="color:#666666" name='dirdestino' placeholder='ó nombre de la materia' size="70%" value="<?php if(isset($_REQUEST['mat'])) echo $_REQUEST['dirdestino']; ?>" required>
  </td>
 </tr>
 <tr>
 <td><b><span style="color:red">Migrar materia</span></b></td>
 <td><input type="checkbox" id="migrar" name="migrar" value="migrar"></td>
 </tr>
 <tr>
  <td>
   <b>Estructura:</b>
  </td>
  <td>
   <input type="radio" name="tipoMat" id="idmod" value="Modular" size="20px"><label for="idmod">Modular - Competencias</label>&nbsp;&nbsp;&nbsp;|&nbsp;
   <input type="radio" name="tipoMat" id="idobjs" value="Objetivos" checked><label for="idobjs">Objetivos</label>
  </td>
 </tr>
 <tr>
  <td>Nom. del componente:</td>
  <td>
   <input type="text" name="componente" placeholder="Nivel, componente, etc." style="color:#666666" value="<?php if(isset($_REQUEST['mat'])) echo $_REQUEST['componente']; ?>" required>
  </td>
 </tr>
 <tr>
  <td>
   <input type="checkbox" id="enIngles" name="enIngles" value="enIngles"><label for="enIngles">Materia en Ingl&eacute;s</label>
  </td>
 </tr>    
 <tr>
  <td>
   <input type='submit' value='Generar HTMLs'>
  </td>
 </tr>
</table>
 <hr />
<div id='consola'>
 <?php 
  if(isset($_REQUEST['mat']))
  {
  echo "<label style='color:#0000FF'>Hora de inicio:".date('H:i:s, jS F Y')."</label>"; 
    $ruta_mat = $_REQUEST['mat'];
   if(isset($_REQUEST["migrar"]))
   {
     $migracion = new Migrator();
	 $migracion->iniciar($ruta_mat);
   }
   else
   {
	if($_REQUEST["tipoMat"]=="Modular")
	{
	 $mod = new Modular();
	 $mod->iniciar($ruta_mat); //generamos de acuerdo a la estructura modular o por competencias
	}
	else
	{
	 $obj=NULL;
	 if(isset($_REQUEST["enIngles"]))
	  $obj = new ObjetivosIngles();
	 else 
	  $obj = new Objetivos();	 
     $obj->iniciar($ruta_mat); //generamos en base a la estructura por objetivos o de unidad academica
	}
   }
  echo "<br><label style='color:#0000FF'>Hora de termino:".date('H:i:s, jS F Y')."</label>";
  }
  else
  {
   echo "<p align='justify'>Antes de procesar los archivos verifique el nombre de los <b>directorios</b>(<i>'unidad 1', 'tema 1', etc. || 'uc1', 'Subcompetencia 1', etc.</i>) y de los formatos en <b>Word</b> (<i>'Nivel general.docx', 'Nivel UC.docx', 'Nivel_sub1.docx', etc. || 'componente general.docx', 'componente_u1.docx', 'componente_u1t1.docx', etc.</i>), para que puedan ser procesados correctamente.</p>";
   echo "<div align='center'><img src='unach.png' width=65% height=65%/></div>";
  }
 ?>   
</div>
</form>
<label style="color:#666666; font-size:11px">Digitalizador v.2014.05 <br>By: Jesus Malo Escobar <br> e-mail: dic.malo@gmail.com </label>
</div>
</body>