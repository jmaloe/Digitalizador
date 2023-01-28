<?php
  $rutaDOC = "ruta/archivo.doc";
  $rutaDOC = str_replace(".docx",".html",$rutaDOC); //.doc a .html
  $rutaDOC = str_replace(".doc",".html",$rutaDOC); //.doc a .html
  echo $rutaDOC;
?>