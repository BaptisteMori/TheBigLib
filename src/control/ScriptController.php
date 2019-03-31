<?php
require_once("model/script.php");
require_once("control/Controller.php");
require_once("model/ScriptBuilder.php");
require_once("model/AuthorBuilder.php");
require_once("model/ScriptStorageFile.php");


class ScriptController extends Controller{
  private $view;

  public function __construct($view,$scriptStorage,$authorStorage){
    $this->view = $view;
    $this->scriptStorage=$scriptStorage;
    $this->authorStorage=$authorStorage;
    $this->storageFile=new ScriptStorageFile();
    //$this->control=new Controller($view,$scriptStorage,$authorStorage);
  }

  /*
   * Ajouter
   * /script/new
   */
  public function newScript(){
    if ($this->accessVerify()){
      $this->view->makeScriptCreationEditPage(new ScriptBuilder(null,$this->scriptStorage));
    }
  }

  /*
   * save
   * /script/save
   */
   public function saveNewScript(array $data,array $file){
     if ($this->accessVerify()){
       $scriptBuilder=new ScriptBuilder($data,$this->scriptStorage);
       if($scriptBuilder->isValid()){
         $filename = $this->storageFile->makeName($data[ScriptBuilder::NAME_REF]);
         if ($file[ScriptBuilder::FILE_REF]['error']==null || $file[ScriptBuilder::FILE_REF]['error']==""){
           $move=$this->storageFile->store($filename,$file[ScriptBuilder::FILE_REF]);
           if ($move){
             echo "bonjour";
             $scriptBuilder->setUrl($this->storageFile::PATH_REF.$filename);
             $scriptBuilder->setAuthor($_SESSION['account']['id']);
             $script=$scriptBuilder->createScript();
             $a=$this->scriptStorage->create($script);

             header('Location: '.$this->view->getRouter()->getUrlIndexScript());
           }
           $this->view->makeScriptCreationEditPage($scriptBuilder,"une Erreur c'est produie lors du déplacement du fichier");
         }else{
           $this->view->makeScriptCreationEditPage($scriptBuilder,$file[ScriptBuilder::FILE_REF]['error']);
         }
       }else{
         $_SESSION['currentNewScript']=$scriptBuilder->getData();
         $this->view->makeScriptCreationEditPage($scriptBuilder);
       }
     }
   }

  /*
   * afficher tous les scripts
   * /script/
   */
  public function indexScript(){
    $allScript = $this->scriptStorage->readAll();
    $tabScript = array();
    for ($i=0; $i < sizeof($allScript); $i++) {
      $tabScript[$i]=new ScriptBuilder($allScript[$i],$this->scriptStorage);
    }
    $this->view->makeIndexPage($tabScript);
  }


  /*
   * regarder
   * /script/{id}
   */
  public function showScript($id){
    if ($this->accessVerify()){
      $script=$this->scriptStorage->read($id);
      $this->view->makeShowScriptPage($script);
    }else{

    }
  }


  public function deleteScript($id){
    $data=$this->scriptStorage->read($id);
    $this->view->makeConfirmDeletePage(new ScriptBuilder($data,$this->scriptStorage));
  }

  /*
   * Supprimer
   * /script/{id}/deleteComfirm
   */
  public function deleteComfirmScript($id,$confirm){
    if ($confirm==="comfirmer"){
      if ($this->accessVerify()){
        $script = $this->scriptStorage->read($id);
        if ($_SESSION['account']['id']===$script->getAuthor()){
          $this->scriptStorage()->delete($id);
        }else{
          $error="Ce script ne vous appartient pas";
          $this->makeErrorPage($error);
        }
      }
    }else{
      header('Location: '.$this->view->router->getUrlIndexScript());
    }
  }

  /*
   * editer
   * /script/{id}/edit
   */
  public function editScript($id){
    if ($this->accessVerify()){
      $script = $this->scriptStorage->read($id);
      if ($_SESSION['account']['id']===$script->getAuthor()){
        $this->view->makeEditPage(new SciptBuilder($script).createScript());
      }else{
        $error="Ce script ne vous appartient pas";
        $this->makeErrorPage($error);
      }
    }
  }
}
