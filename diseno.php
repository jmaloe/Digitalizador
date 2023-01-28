<html>
<head>
 <style type='text/css'>
  #consola{color:#009900; font-size:15px; font-family:Arial; background:#000000; text-align:left;overflow:scroll;padding:5px 5px 5px 5px; height:550px;}
  #contenedor{text-align:left;background:#fff;border:1px solid #ccc;-webkit-box-shadow:rgba(0,0,0,0.2) 0px 0px 5px;-moz-box-shadow:rgba(0,0,0,0.2) 0px 0px 5px;-o-box-shadow:rgba(0,0,0,0.2) 0px 0px 5px;box-shadow:rgba(0,0,0,0.2) 0px 0px 5px}
  #contenedor{margin:0 auto 10px auto;width:545px; padding:5px 5px 5px 5px}
 </style>
</head>
<div id="contenedor" align="center" style="width:640px">
<form name='conso' method='post'>
<hr />
<table>
 <tr><td><b>Materia:</b></td><td><input type='text' name='mat' value='materia' size="50px"></td></tr>
 <tr><td><b>Estructura</b></td></tr>
 <tr><td><input type="radio" name="tipoMat" value="Modular" checked>Modular</td></tr>
 <tr><td><input type="radio" name="tipoMat" value="Objetivos">Objetivos</td></tr>
 <tr><td><input type='submit' onClick='submit()' value='Iniciar proceso'></td></tr>
</table>
 <hr />
 <div id="consola">
   <?php 
    if(isset($_REQUEST["tipoMat"]))
	 echo $_REQUEST["tipoMat"];
   ?>
 </div>
 </form>
</div> 
</html>