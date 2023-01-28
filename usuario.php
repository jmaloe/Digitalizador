<?php
require_once("../../config.php"); //ruta principal de moodle

$myUserID = $USER->id;
$myUserName = $USER->username;
$myCourse = $COURSE->title;
echo "ID:".$myUserID." Nombre:".$myUserName." Curso:".$myCourse;
//echo "Hola $USER->id"; //(Recupera el id de usuario)
//echo "Hola $USER->username"; //(recupera el nombre de usuario)
?>