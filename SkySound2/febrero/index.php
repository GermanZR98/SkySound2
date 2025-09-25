<?php

require_once "config/Config.php";

// Initialize application configuration
Config::init();

$mod = $_GET["mod"] ?? Config::DEFAULT_MODULE;
$ope = $_GET["ope"] ?? Config::DEFAULT_OPERATION;

// Validate module and operation to prevent directory traversal
if (!preg_match('/^[a-zA-Z]+$/', $mod) || !preg_match('/^[a-zA-Z]+$/', $ope)) {
    die("Error: Invalid parameters");
}

$controllerFile = "controlador/$mod.controller.php";

if (!file_exists($controllerFile)) {
    die("Error: Controller not found");
}

require_once $controllerFile;

// Convert to proper class name (first letter uppercase)
$className = "Controller" . ucfirst($mod);

if (!class_exists($className)) {
    die("Error: Controller class not found");
}

$controller = new $className();

if (method_exists($controller, $ope)) {
    $controller->$ope();
} else {
    die("Error: Operation not found");
}

?>