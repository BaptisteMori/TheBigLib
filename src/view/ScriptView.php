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
  private $stylesheet;

  public function __construct(Router $router){
    $this->router=$router;
    $this->content=null;
    $this->title=null;
    $this->stylesheet=null;
    $this->view=new View($this->router);
    $this->menu=$this->view->makeMenu("accueil");
  }

  public function render(){
    $content=$this->content;
    $title=$this->title;
    $menu=$this->menu;
    $stylesheet=$this->stylesheet;
    include("template.php");
  }







  public function makeErrorPage($error){
    $this->content="<span>".$error."<span><a href='".$this->router->getUrl().">Retour à l'accueil</a>' ";
  }

}
