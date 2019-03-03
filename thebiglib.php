<?php
session_start();

set_include_path("./src");

require_once("Router.php");
require_once("lib/DataBase.php");
require_once("model/ScriptStorageMysql.php");
require_once("model/AuthorStorageMySql.php");

/*
 * Stockage
 */
$pdo=new DataBase();
$scriptStorage= new ScriptStorageMysql($pdo->getDB());
$authorStorage = new AuthorStorageMySql($pdo->getDB());


$router = new Router();
$router->main($scriptStorage,$authorStorage);
?>
