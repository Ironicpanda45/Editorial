<?php
$servidor = "fdb1034.awardspace.net";
$usuario = "4667275_votacion";
$contrasena = "contrasena2004";
$base_de_datos = "4667275_votacion";

$conexion = new mysqli($servidor, $usuario, $contrasena, $base_de_datos);

if ($conexion->connect_error) {
    die("La conexión falló: " . $conexion->connect_error);
}
?>