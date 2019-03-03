<?php

require_once("Router.php");

class View {

  private $router;
  private $content;
  private $title;
  private $menu;

  public function __construct(Router $router){
    $this->router=$router;
    $this->content=null;
    $this->title=null;
  }

  public function render(){
    $content=$this->content;
    $title=$this->title;
    $menu=$this->menu;
    include("template.php");
  }

  public function makeHomePage(){
    $this->content = "Salut salut";
    $this->title = "<h1>The BigLib</h1>";
    $this->makeMenu("accueil");
  }

  public function makeMenu($page) {
    $this->menu = "<nav>
                      <ul>
                        <li><a href=\"\">Logo</a></li>
                        <li><a href=\"\">Auteurs</a></li>
                      </ul>
                      <ul>
                        <li><form action=\"index.php\" method=\"post\">
                          <input type=\"text\" name=\"search\" value=\"\" placeholder=\"Bare de racherche\">
                          <input type=\"submit\" value=\"rechercher\">
                        </form></li>
                      </ul>
                      <ul id=\"right\">
                        <li><a href=\"\">Mon Profil</a></li>
                        <li><a href=\"\">Connexion</a></li>
                        <li><a href=\"\">Inscription</a></li>
                        <li><a href=\"\">À propos</a></li>
                      </ul>
                   </nav>";
  }

  public function makeDebugPage($e){
    $this->title = 'Debug';
    $this->content = '<pre>'.var_export($e,true).'</pre>';
  }
}
