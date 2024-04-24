<?php
function conexion()
{
    $servidor = "localhost";
    $usuario = "root";
    $password = "";
    $db = "liberacionessap";
    $conexion = mysqli_connect($servidor, $usuario, $password, $db);

    return $conexion;
}

if (conexion()) {
    //echo "Conexion Exitosa";
} else {
    echo "no conectado";
}
