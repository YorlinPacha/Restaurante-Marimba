<!-- Conexion a nuestra base de datos -->
<?php

$servidor= "localhost";
$baseDatos= "marimba";
$usuario= "root";
$contrasenia= "";

try{
    $conexion= new PDO("mysql:host=$servidor;dbname=$baseDatos",$usuario,$contrasenia);
    // echo "Conexion exitosa";
}catch(Exception $error){
    echo "Error: ".$error->getMessage();
}

?>