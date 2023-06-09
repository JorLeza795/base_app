<?php
$servidor= "localhost"; //127.0.0.1, o aca puedes poner si tienes servidor comprado
$baseDeDatos= "app";
$usuario= "root";
$contrasenia= "";

try {
    $conexion = new PDO("mysql:host=$servidor; dbname=$baseDeDatos",$usuario,$contrasenia);
} catch (Exception $ex) {
    echo $ex-> getMessage();
}

?>