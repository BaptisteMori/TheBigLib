<?php

require_once("view/View.php");
require_once("control/Controller.php");


class Router{
  public function main($scriptStorage,$authorStorage){
    try{
      $view = new View($this);
      $control = new Controller($view,$scriptStorage,$authorStorage);

      if(!key_exists('PATH_INFO',$_SERVER)) {
        $view->makeHomePage();
      }else{
        if ($_SERVER['PATH_INFO']==='/script/new'){
          $control->newScript();
        }elseif ($_SERVER['PATH_INFO']==='/script/save') {
          $control->saveNewScript($_POST);
        } else if ($_SERVER['PATH_INFO'] === '/createaccount') {
          $control->newAccount();
        } else if ($_SERVER['PATH_INFO'] === '/createdaccount') {
          $control->saveNewAccount($_POST);
        } else if ($_SERVER['PATH_INFO'] === '/login') {
          $control->login();
        } else if ($_SERVER['PATH_INFO'] === '/login_verification') {
          $control->loginVerification($_POST);
        } else if ($_SERVER['PATH_INFO'] === '/logout') {
          $control->logout();
        } else if ($_SERVER['PATH_INFO'] === '/myprofile') {
          $control->profil();
        } else if ($_SERVER['PATH_INFO'] === '/apropos') {
          $control->apropos();
        }
      }
      $view->render();
    } catch (Exception $e){
      $view->makeDebugPage($e);
      $view->render();
    }
  }

  public function getUrl(){
    return "http://thebiglib/thebiglib.php";
  }

  public function getUrlSaveScript(){
    return $this->getUrl()."/script/save";
  }

  public function getAuthorCreationUrl() {
    return $this->getUrl()."/createaccount";
  }

  public function getAuthorCreatedUrl() {
    return $this->getUrl()."/createdaccount";
  }

  public function getConnexionUrl() {
    return $this->getUrl()."/login";
  }

  public function getLoginVerificationUrl() {
    return $this->getUrl()."/login_verification";
  }

  public function getDeconnexionUrl() {
    return $this->getUrl()."/logout";
  }

  public function getProfilUrl() {
    return $this->getUrl()."/myprofile";
  }

  public function getAProposUrl() {
    return $this->getUrl()."/apropos";
  }
}
