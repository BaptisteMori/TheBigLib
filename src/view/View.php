<?php

require_once("Router.php");
require_once("model/ScriptBuilder.php");


class View {

  private $router;
  private $content;
  private $title;
  private $menu;

  public function __construct(Router $router){
    $this->router=$router;
    $this->content=null;
    $this->title=null;
    $this->makeMenu("accueil");
  }

  public function render(){
    $content=$this->content;
    $title=$this->title;
    $menu=$this->menu;
    include("template.php");
  }

  public function makeHomePage(){
    $this->content = "Salut salut";
  }

  public function makeMenu($page) {
    $this->menu = "<nav>
                      <ul>
                        <li><h4><a href=\"\">The BigLib</a></h4></li>
                        <li><a href=\"\">Auteurs</a></li>
                      </ul>
                      <ul>
                        <li><form action=\"index.php\" method=\"post\">
                          <input type=\"text\" name=\"search\" value=\"\" placeholder=\"Rechercher\">
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

  public function makeScriptCreationPage(ScriptBuilder $scriptBuilder){
    $name="";
    $description="";
    $language="";
    if ($scriptBuilder->getData()!=null){
      if($scriptBuilder->getData()[$scriptBuilder::NAME_REF]!=""){
        $name=$scriptBuilder->getData()[$scriptBuilder::NAME_REF];
      }

      if($scriptBuilder->getData()[$scriptBuilder::DESCRIPTION_REF]!=""){
        $description=$scriptBuilder->getData()[$scriptBuilder::DESCRIPTION_REF];
      }

      if($scriptBuilder->getData()[$scriptBuilder::LANGUAGE_REF]!=""){
        $language=$scriptBuilder->getData()[$scriptBuilder::LANGUAGE_REF];
      }

    }
    $strLanguages="";
    foreach($scriptBuilder->getLanguages() as $value){ $strLanguages.="<option value=\"".$value."\">".$value."</option>"; };

    $this->content = "
    <form action=\"".$this->router->getUrlSaveScript()."\" method=\"POST\">
      <label>Nom :</label><input type=\"text\" name=\"".$scriptBuilder::NAME_REF."\" value=\"".$name."\">
      <label>Description :</label><input type=\"textarea\" name=\"".$scriptBuilder::DESCRIPTION_REF."\" value=\"".$description."\">
      <label>Langage :</label><select name=\"".$scriptBuilder::LANGUAGE_REF."\"> ".$strLanguages."</select>
      <input type=\"submit\" value=\"enregistrer\">
    </form>
    ";
  }

  public function makeDebugPage($e){
    $this->title = 'Debug';
    $this->content = '<pre>'.var_export($e,true).'</pre>';
  }
}
