<?php
require_once("model/script.php");
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

  public function saveNewScript(array $data){
    $scriptBuilder=new ScriptBuilder($data,$this->scriptStorage);
    if($scriptBuilder->isValid()){
      $script=$scriptBuilder->createScript();
      $a=$this->scriptStorage->create($script);
      $this->view->makeDebugPage($a);
    }else{
      $_SESSION['currentNewScript']=$scriptBuilder->getData();
      $this->view->makeScriptCreationPage($scriptBuilder);
    }
  }

}
