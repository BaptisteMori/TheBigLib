<?php

require_once("Router.php");

class View {
  private $content;
  private $router;

  public function __construct(Router $router){
    $this->router=$router;
    $this->content=null;
    $this->title=null;
  }

  public function render(){
    $content=$this->content;
    $title=$this->title;
    include("template.php");
  }

  public function makeDebugPage($e){
    $this->title = 'Debug';
    $this->content = '<pre>'.var_export($e,true).'</pre>';
  }
}
