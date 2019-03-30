<?php

require_once("Router.php");
require_once("model/ScriptBuilder.php");
require_once("model/AuthorBuilder.php");


class View {

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
    $this->makeMenu("accueil");
  }

  public function render(){
    $content=$this->content;
    $title=$this->title;
    $menu=$this->menu;
    $stylesheet=$this->stylesheet;
    include("template.php");
  }

  public function makeHomePage(){
    $this->content = "<section><article id=\"login\">";
    if (key_exists('account',$_SESSION)) {
      $this->content .= "<h3>Bienvenue ".$_SESSION['account']['name']." !</h3>
                      <a href=\"".$this->router->getProfilUrl()."\">Mon profil</a>
                      </article>";
    } else {
      $this->content .= $this->makeLoginForm().
                        "<a href=\"".$this->router->getAuthorCreationUrl()."\">Créer un compte</a>
                        </article>";
    }
    $this->content .= "<article id=\"presentation\">
              <h3>TheBigLib, c'est quoi ?</h3>
              <p>TheBigLib est un site communautaire sur lequel n'importe qui peut déposer ses scripts, sous condition d'être connecté.
              Les scripts peuvent être des méthodes, des classes, des interfaces ou de simples lignes de codes. Le but est que chaque script
              puisse être utilisé librement par n'importe quel visiteur !</p>
              <a href=\"".$this->router->getAProposUrl()."\">En savoir plus</a>
            </article>
          </section>

          <section id=\"scripts\">
                <h3>Les derniers scripts</h3>
                <article>plusieurs scripts blablablablabla</article>
                <article>plusieurs scripts blablablablabla</article>
                <article>plusieurs scripts blablablablabla</article>
                <article>plusieurs scripts blablablablabla</article>
                <article>plusieurs scripts blablablablabla</article>
                <article>plusieurs scripts blablablablabla</article>
                <br>
                <a href=\"\">Tous les scripts</a>
            </section>";
    $this->stylesheet = "<link rel=\"stylesheet\" href=\"../ressources/accueil.css\">";
  }

  public function makeMenu($page) {
    $this->menu = "<nav>
                      <ul>
                        <li><h4><a href=\"".$this->router->getUrl()."\">The BigLib</a></h4></li>
                        <li><a href=\"\">Auteurs</a></li>
                      </ul>
                      <ul>
                        <li><form action=\"thebiglib.php\" method=\"post\">
                          <input type=\"text\" name=\"search\" value=\"\" placeholder=\"Rechercher\">
                          <input type=\"submit\" value=\"rechercher\">
                        </form></li>
                      </ul>
                      <ul id=\"right\">
                      ";
                      if (key_exists("account",$_SESSION)) {
                        $this->menu .= "<li><a href=\"".$this->router->getProfilurl()."\">Mon Profil</a></li>
                                        <li><a href=\"".$this->router->getDeconnexionUrl()."\">Déconnexion</a></li>";
                      } else {
                        $this->menu .= "<li><a href=\"".$this->router->getConnexionUrl()."\">Connexion</a></li>
                                        <li><a href=\"".$this->router->getAuthorCreationUrl()."\">Inscription</a></li>";
                      }
                      $this->menu .= "<li><a href=\"".$this->router->getAProposUrl()."\">À propos</a></li>
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

    $this->content = "<form action=\"".$this->router->getAuthorCreatedUrl()."\" method=\"post\">
                        <label>Nom :<input type=\"text\" name=\"".$authorBuilder::NAME_REF."\" value=\"".$name."\" /></label>
                        <label>Mot de passe :<input type=\"password\" name=\"".$authorBuilder::PASSWORD_REF."\" value=\"".$password."\" placeholder=\"8 caractères minimum\" /></label>
                        <label>Email :<input type=\"email\" name=\"".$authorBuilder::EMAIL_REF."\" value=\"".$email."\" /></label>
                        <label>Description :<textarea name=\"".$authorBuilder::DESCRIPTION_REF."\">".$description."</textarea></label>
                        <input type=\"submit\" value=\"Créer un compte\" />
                      </form>
    ";
  }

  public function makeLoginPage() {
    $this->content = $this->makeLoginForm();
  }

  public function makeLoginForm() {
    return "<form action=\"".$this->router->getLoginVerificationUrl()."\" method=\"post\">
                        <label>Nom: <input type=\"text\" name=\"nom\" value=\"\"></label>
                        <label>Mot de passe: <input type=\"password\" name=\"mdp\" value=\"\"/></label>
                        <input type=\"submit\" value=\"Se Connecter\" />
                      </form>";
  }

  public function makeProfilePage() {
    $account = $_SESSION['account'];
    $this->content = "<section>
                        <h2>".$account['name']."</h2>
                        <p>Adresse mail: ".$account['email']."</p>
                        <p>Description: <br>".$account['description']."</p>
                        <a href=\"".$this->router->getModifyUrl()."\">Modifier</a>
                      </section>
                      <section id=\"scripts\">

                      </section>";
  }

  public function makeEditProfilePage() {
    $a = $_SESSION['account'];
    $this->content = "<form action=\"".$this->router->getModificationValidationUrl()."\" method=\"post\">
                        <label>Nom :<input type=\"text\" name=\"name\" value=\"".$a['name']."\" /></label>
                        <label>Mot de passe :<input type=\"password\" name=\"password\" placeholder=\"8 caractères minimum\" /></label>
                        <label>Email :<input type=\"email\" name=\"email\" value=\"".$a['email']."\" /></label>
                        <label>Description :<textarea name=\"description\">".$a['description']."</textarea></label>
                        <input type=\"submit\" value=\"Valider\" />
                      </form>";
  }

  public function makeAProposPage() {
    $this->content = "<h2>A Propos</h2>
      Réalisé par
      <p>21606807</p>
      <p>21602052</p>
      <article>
      <h3>Choix du design</h3>
      <p>Nous avons voulu réaliser un site avec des couleurs non conventionnelles qui soient vives afin qu'il soit plus accueillant.</p>
      </article>

      <article>
      <h3>Choix de modélisation</h3>
      <p>Nous avons modélisé un script de façon simple: son auteur, son langage, un titre, une description et un fichier qui contient le script.
      Cela nous semblait être la meilleure façon de représenter un script. Nous avons toutes les informations importantes sans de surplus inutile.
      Un auteur est un utilisateur inscrit au site.</p>
      </article>
    ";

    $this->stylesheet = "<link rel=\"stylesheet\" href=\"../ressources/apropos.css\">";
  }

  public function makeDebugPage($e){
    $this->title = 'Debug';
    $this->content = '<pre>'.var_export($e,true).'</pre>';
  }
}
