<?php
require_once("model/script.php");
require_once("model/ScriptBuilder.php");
require_once("model/AuthorBuilder.php");


class Controller{
  private $view;

  public function __construct(View $view,$scriptStorage,$authorStorage){
    $this->view = $view;
    $this->scriptStorage=$scriptStorage;
    $this->authorStorage=$authorStorage;
  }

  public function newAccount() {
    $this->view->makeAuthorCreationPage(new AuthorBuilder(null,$this->authorStorage));
  }

  public function saveNewAccount(array $data) {
    $authorBuilder = new AuthorBuilder($data,$this->authorStorage);
    if ($authorBuilder->isValid()) {
      $author = $authorBuilder->createAuthor();
      $a = $this->authorStorage->create($author);
      $this->view->makeDebugPage($a);
    } else {
      $_SESSION['currentNewAuthor']=$authorBuilder->getData();
      $this->view->makeAuthorCreationPage($authorBuilder);
    }
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
