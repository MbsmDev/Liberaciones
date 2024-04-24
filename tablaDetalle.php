<?php

//require_once('metodos/operaBapis.php');

include_once(FUNCTIONS . '/getHeaderPC.php');

$codigo_liberacion = $_GET['codigo_liberacion'];
$numPedido = $_GET['numPedido'];
$grpLiberacion = $_GET['grpLiberacion'];

echo($codigo_liberacion);
echo($numPedido);
echo($grpLiberacion);

//$response=getItems($codigo_liberacion,$numPedido, $grpLiberacion);

//var_dump($response);
//echo json_encode(array('dataItems'=>$response));
//return new JsonResponse(array('dataItems'=>$response));

?>