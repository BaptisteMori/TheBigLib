<?php
session_start();

set_include_path("./src");

require_once("Router.php");
require_once("lib/DataBase.php");
require_once("model/ScriptStorageMysql.php");

/*
 * Stockage
 */
$database=new DataBase();
$scriptStorage= new ScriptStorageMysql($database);


$router = new Router();
$router->main();
?>
