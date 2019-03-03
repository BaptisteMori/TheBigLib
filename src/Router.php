<?php

require_once("view/View.php");
require_once("control/Controller.php");


class Router{
  public function main($scriptStorage){
    try{
      $view = new View($this);
      $control = new Controller($view,$scriptStorage);

      $view->makeHomePage();

      $view->render();
    } catch (Exception $e){
      $view->makeDebugPage($e);
      $view->render();
    }
  }

  public function getUrl(){
    return "http://thebiglib/";
  }
}
