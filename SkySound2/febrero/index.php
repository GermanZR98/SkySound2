<?php

ini_set("display_errors", 1) ;
ini_set("display_startup_errors", 1) ;
error_reporting(E_ALL) ;

$mod = $_GET["mod"]??"usuario";
$ope = $_GET["ope"]??"index";

require_once "controlador/$mod.controller.php";

$nme = "controller$mod";

$cont = new $nme();

if(method_exists($cont,$ope))
         $cont->$ope();
    else
        die("Error");

?>