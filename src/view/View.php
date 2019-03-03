<?php

require_once("Router.php");
require_once("model/ScriptBuilder.php");
require_once("model/AuthorBuilder.php");


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
                      ";
                      if (key_exists("account",$_SESSION)) {
                        $this->menu .= "<li><a href=\"\">Mon Profil</a></li>
                                        <li><a href=\"\">Déconnexion</a></li>";
                      } else {
                        $this->menu .= "<li><a href=\"\">Connexion</a></li>
                                        <li><a href=\"\">Inscription</a></li>";
                      }
                      $this->menu .= "<li><a href=\"\">À propos</a></li>
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
    foreach($scriptBuilder->getLanguages() as $value){
      $selected="";
      if($value===$language){ $selected ="selected";}
      $strLanguages.="<option value=\"".$value."\" ".$selected.">".$value."</option>";
    }

    $this->content = "
    <form action=\"".$this->router->getUrlSaveScript()."\" method=\"POST\">
      <label>Nom :</label><input type=\"text\" name=\"".$scriptBuilder::NAME_REF."\" value=\"".$name."\">
      <label>Description :</label><textarea name=\"".$scriptBuilder::DESCRIPTION_REF."\">".$description."</textarea>
      <label>Langage :</label><select name=\"".$scriptBuilder::LANGUAGE_REF."\"> ".$strLanguages."</select>
      <input type=\"submit\" value=\"enregistrer\">
    </form>
    ";
  }

  public function makeAuthorCreationPage(AuthorBuilder $authorBuilder) {
    $data = $authorBuilder->getData();
    $name="";
    $password="";
    $email="";
    $description=$data[$authorBuilder::DESCRIPTION_REF];
    if ($data!=null) {
      if ($data[$authorBuilder::NAME_REF]!="") {
        $name=$data[$authorBuilder::NAME_REF];
      }
      if ($data[$authorBuilder::PASSWORD_REF]!="") {
        $password=$data[$authorBuilder::PASSWORD_REF];
      }
      if ($data[$authorBuilder::EMAIL_REF]!="") {
        $email=$data[$authorBuilder::EMAIL_REF];
      }
    }

    $this->content = "<form action=\"".$this->router->getAuthorCreationUrl()."\"method=\"post\">
                        <label>Nom :<input type=\"text\" name=\"".$authorBuilder::NAME_REF."\" value=\"".$name."\" /></label>
                        <label>Mot de passe :<input type=\"password\" name=\"".$authorBuilder::PASSWORD_REF."\" value=\"".$password."\" /></label>
                        <label>Email :<input type=\"email\" name=\"".$authorBuilder::EMAIL_REF."\" value=\"".$email."\" /></label>
                        <label>Description :<textarea name=\"".$authorBuilder::DESCRIPTION_REF."\"/>".$description."</textarea></label>
                        <input type=\"submit\" value=\"Créer un compte\" />
                      </form>
    ";
  }

  public function makeDebugPage($e){
    $this->title = 'Debug';
    $this->content = '<pre>'.var_export($e,true).'</pre>';
  }
}
