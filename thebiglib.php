<?php
session_start();

set_include_path("./src");

require_once("Router.php");
require_once("lib/DataBase.php");
require_once("model/ScriptStorageMysql.php");

/*
 * Stockage
 */
$pdo=new DataBase();
$scriptStorage= new ScriptStorageMysql($pdo->getDB());


$router = new Router();
$router->main($scriptStorage);
?>
