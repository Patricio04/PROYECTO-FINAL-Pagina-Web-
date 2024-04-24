<?php
$servidor ="localhost";
$baseDeDatos="webSite";
$usuario="root";
$contrasenia="";

try{
$conexio= new PDO("mysql:host=$servidor;dbname=$baseDeDatos",$usuario,$contrasenia);
echo ("Conexcion Exitosa");
}catch(Exception $error){

echo $error->getMessage();

}

?>