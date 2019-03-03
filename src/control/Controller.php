<?php
require_once("model/ScriptBuilder.php");


class Controller{
  private $view;

  public function __construct(View $view,$scriptStorage){
    $this->view = $view;
    $this->scriptStorage=$scriptStorage;
  }


  public function newScript(){
    $this->view->makeScriptCreationPage(new ScriptBuilder(null,$this->scriptStorage));
  }
}
