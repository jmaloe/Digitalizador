<?php
/*
   Nombre de la aplicacion: "exportador"
   Version: 2012.10.03
   Autor: Jesus Malo Escobar
*/
class Exportador
{  
 function exportar($dirArchivo)
 {
  try
  {
   // convertir un .doc a .html    
   $rutaDOC=realpath($dirArchivo);    
   $rutaHTML=$rutaDOC;
   // indicamos la ruta y nombre del archivo reemplazando .doc o .docx a .html
   $rutaHTML = str_replace(".docx",".html",$rutaHTML); //.docx a .html
   $rutaHTML = str_replace(".doc",".html",$rutaHTML); //.doc a .html
   
    if(!file_exists($rutaHTML)) //si el archivo ya existe no lo creamos nuevamente
    {
     // creamos una instancia de "Word application"
     $word = new COM("word.application") or die("No se pudo instanciar : application object");
     // creamos una instancia de "Word Document object"
     //$wordDocument = new COM("word.document") or die("No se pudo instanciar: document object");
     $word->Visible = 0;
     // abrimos el documento vacío
     $wd = $word->Documents->Open($rutaDOC);   	
     // guardamos el contenido como archivo HTML
     $wd->SaveAs($rutaHTML, 8); //8=HTML, 3=texto plano
     // clean up
     //$wordDocument = NULL;
     $word->Quit();
     $word = NULL;
     echo "<br>Archivo $dirArchivo exportado a .html";
    }
	
  }
  catch(Exception $e)
  {
   echo $e->getMessage();
  }
 }
 
 function existe($rutaDOC)
 {
   if(file_exists($rutaDOC.".doc"))
   {
     return $rutaDOC.".doc";
   }
   else if(file_exists($rutaDOC.".docx"))
   {
     return $rutaDOC.".docx";
   }
   else
   {
    return NULL;
   }
 }
   
}
?>