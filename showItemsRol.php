<?php

require_once "conexion.php";
$con = conexion();

$idRol = $_GET['idRol'];

$sql = "SELECT DISTINCT rol,transaccion,UPPER(descripcion) as descripcion FROM `temp_load` WHERE rol = '$idRol'";

$result = mysqli_query($con, $sql);

$emparray = array();
while ($row = mysqli_fetch_assoc($result)) {
    $emparray[] = $row;
}
//var_dump($response);
echo json_encode($emparray);

//echo json_encode(array('dataItemsCM' => $result));
