
<?php

/*$vari = "Fecha: 20 de septiembre de 2012
COMPONENTE 
DESARROLLO
Nombre de la UA
I. Sociedad actual y naturaleza
Unidad I
Impacto de las actividades humanas sobre el medioambiente
Carga horaria / Tiempo estimado de estudio
15 horas
Introducción
El hombre se sirve de la naturaleza para diversos fines, pero su escaso conocimiento sobre la misma lo ha llevado a abusar de ella. Las actividades productivas que el ser humano realiza transforman su entorno. En los últimos 30 años el crecimiento económico y demográfico ha sido muy acelerado y ha trastornado el medioambiente. ";

if(strpos($vari,"Unidad I")!==false)
 echo "Unidad I";
else
 echo "No coincide en nada";

*/
require_once("exportador.php");
require_once("Objetivos.php");
$exp = new Exportador();
$malo = new Objetivos();
  
  if(file_exists('componente general.doc'))
  {
    echo "<br>Componente general encontrado<br>";
	$exp->exportar("componente general.doc");
    $malo->getPresentacionGeneral("","componente general.html",""); //digitalizamos el contenido que esta en el "txt"	
	//unlink("componente general.html");
  }


/*$filename = "componente_u1.doc";
 
// Make sure the file is valid
if(!file_exists($filename) ) {
    die("The file '{$filename}' does not exist.");
}
if(filesize($filename) == 0) {
    die("The file is empty.");
}
 
// Let the browser know it's getting a word document
header("Content-Type; application/msword");
header("Content-Disposition: attachment; filename=". basename($filename));
header("Content-Length: ". filesize($filename));
header("Content-Transfer-Encoding: binary");
 
// Send the file
readfile($filename);

*/
/*if (! function_exists('pcntl_fork')) die('PCNTL functions not available on this PHP installation');

for ($x = 1; $x < 5; $x++) {
   switch ($pid = pcntl_fork()) {
      case -1:
         // @fail
         die('Fork failed');
         break;

      case 0:
         // @child: Include() misbehaving code here
         print "FORK: Child #{$x} preparing to nuke...\n";
         generate_fatal_error(); // Undefined function
         break;

      default:
         // @parent
         print "FORK: Parent, letting the child run amok...\n";
         pcntl_waitpid($pid, $status);
         break;
   }
}

print "Done! :^)\n\n"; */



?>