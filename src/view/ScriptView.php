<?php

require_once("Router.php");
require_once("model/ScriptBuilder.php");
require_once("model/AuthorBuilder.php");
require_once("view/View.php");
//require_once("model/Script.php");

class ScriptView {

  private $router;
  private $content;
  private $title;
  private $menu;

  public function __construct(Router $router){
    $this->router=$router;
    $this->content=null;
    $this->title=null;
    $this->view=new View($this->router);
    $this->view->makeMenu("accueil");
  }

  public function render(){
    $content=$this->content;
    $title=$this->title;
    $menu=$this->menu;
    include("template.php");
  }


  public function makeScriptCard($sb){
    $script=$sb->getData();
    $this->content="<div class='card'>
                    <h1>".$script[ScriptBuilder::NAME_REF]."</h1>
                    <h3>".$script[ScriptBuilder::AUTHOR_REF]."</h3>
                    <p class='ligth-grey'>".$script[ScriptBuilder::LANGUAGE_REF]."</p>
                    <hr>
                    <p>".$script[ScriptBuilder::DESCRIPTION_REF]."</p>
                    <hr>
                    <a href='script/".$script["id"]."'>Voir plus</a>
                  </div>";
  }

  public function makeIndexPage($scripts){
    foreach ($scripts as $script) {
      $this->content.=$this->makeScriptCard($script);
    }
  }

  public function makeScriptForm($script){

  }

  public function makeConfirmDeletePage($script){
    $this->content="<form method='POST' action='".$this->view->getUrlDeleteComfirm($script->data['id'])."'>
                      <input type='submit' value='comfirmer'>
                      <input type='submit' value='annuler'>
                    </form>";
  }

  public function makeEditPage(Script $script){
    $this->content="<section>".$this->makeScriptForm($script)."</section>";
  }




  public function makeErrorPage($error){
    $this->content="<span>".$error."<span><a href='".$this->router->getUrl().">Retour à l'accueil</a>' ";
  }

}
