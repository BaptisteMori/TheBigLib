<?php

require_once("view/View.php");
require_once("control/Controller.php");


class Router{
  public function main($scriptStorage){
    try{
      $view = new View($this);
      $control = new Controller($view,$scriptStorage);

      if(!key_exists('PATH_INFO',$_SERVER)) {
        $view->makeHomePage();
      }else{
        if ($_SERVER['PATH_INFO']==='/script/new'){
          $control->newScript();
        }elseif ($_SERVER['PATH_INFO']==='/script/save') {
          $control->saveNewScript($_POST);
        }
      }
      $view->render();
    } catch (Exception $e){
      $view->makeDebugPage($e);
      $view->render();
    }
  }

  public function getUrl(){
    return "http://thebiglib/thebiglib.php/";
  }

  public function getUrlSaveScript(){
    return $this->getUrl()."action/save";
  }
}
