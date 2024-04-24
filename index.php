<?php
require_once 'global/parameters.php';
require_once CONFIG .'autoload.php';
require_once CONFIG . 'database.php';
require_once HELPERS. 'utils.php';

if (isset($_GET['controller'])) {
    $nombre_controlador = $_GET['controller'] . 'Controller';
} elseif (!isset($_GET['controller']) && !isset($_GET['action'])) {
    $nombre_controlador = DEFAULT_CONTROLLER;
} else {
    echo 'errores1';
    exit();
}

if (class_exists($nombre_controlador)) {
    $controlador = new $nombre_controlador();

    if (isset($_GET['action']) && method_exists($controlador, $_GET['action'])) {
        $action = $_GET['action'];
        $controlador->$action();
    } elseif (!isset($_GET['controller']) && !isset($_GET['action'])) {
        $action_default = DEFAULT_METHOD;
        $controlador->$action_default();
    } else {
        echo 'errores2';
    }
} else {
    echo 'errores3';
}