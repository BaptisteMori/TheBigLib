<?php

require_once("view/View.php");
require_once("view/ScriptView.php");
require_once("control/Controller.php");
require_once("control/ScriptController.php");



class Router{

  private $control;

  public function main($scriptStorage,$authorStorage){
    try{
      $view = new View($this);
      $scriptView = new ScriptView($this);
      $this->control = new Controller($view,$scriptStorage,$authorStorage);
      $scriptControl = new ScriptController($view,$scriptStorage,$authorStorage);

      if(!key_exists('PATH_INFO',$_SERVER)) {
        $this->control->homePage();
      }else{
        $route=$_SERVER['PATH_INFO'];
        $splitRoute=explode('/',$route);
        $a=array_shift($splitRoute);

        if ($route==='/'){
          $this->control->homePage();
        }
        /*
         * Route pour les scripts
         */
        elseif ($route==='/script'){
          $scriptControl->indexScript();
        }elseif ($route==='/script/new'){
          $scriptControl->newScript();
        }elseif ($route==='/script/save') {
          $scriptControl->saveNewScript($_POST,$_FILES);
        }
        // /script/{id}
        elseif (sizeof($splitRoute)>=2 && $splitRoute[0]==='script' && preg_match('/^[0-9]*$/i',$splitRoute[1])){
          $scriptControl->showScript($splitRoute[1]);
        }
        // /script/{id}/edit
        elseif (sizeof($splitRoute)>=3 && $splitRoute[0]==='script' && preg_match('/^[0-9]*$/i',$splitRoute[1]) && $splitRoute[0]==='edit'){
          $scriptControl->editScript($id);
        }
        // /script/{id}/delete
        elseif (sizeof($splitRoute)>=3 && $splitRoute[0]==='script' && preg_match('/^[0-9]*$/i',$splitRoute[1]) && $splitRoute[0]==='delete'){
          $scriptControl->deleteScript($id);
        }
        // /script/{id}/deleteConfirm
        elseif (sizeof($splitRoute)>=3 && $splitRoute[0]==='script' && preg_match('/^[0-9]*$/i',$splitRoute[1]) && $splitRoute[0]==='deleteComfirm'){
          $scriptControl->deleteComfirmScript($_POST);
        }
        /*
         * Route pour les Users
         */
         else if ($_SERVER['PATH_INFO'] === '/createaccount') {
          $this->control->newAccount();
        } else if ($_SERVER['PATH_INFO'] === '/createdaccount') {
          $this->control->saveNewAccount($_POST);
        } else if ($_SERVER['PATH_INFO'] === '/login') {
          $this->control->login();
        } else if ($_SERVER['PATH_INFO'] === '/loginverification') {
          $this->control->loginVerification($_POST);
        } else if ($_SERVER['PATH_INFO'] === '/logout') {
          $this->control->logout();
        } else if ($_SERVER['PATH_INFO'] === '/myprofile') {
          $this->control->profil();
        } else if ($_SERVER['PATH_INFO'] === '/apropos') {
          $this->control->apropos();
        } else if ($_SERVER['PATH_INFO'] === '/edit') {
          $this->control->editProfile();
        } else if ($_SERVER['PATH_INFO'] === '/modifyaccount') {
          $this->control->modifyAccount($_POST);
        }
      }
      $view->render();
    } catch (Exception $e){
      $view->makeDebugPage($e);
      $view->render();
    }
  }

  public function getController() {
    return $this->control;
  }

  public function getUrl(){
    return "http://thebiglib/thebiglib.php";
  }

  public function getUrlIndexScript(){
    return $this->getUrl()."/script";
  }

  public function getUrlNewScript(){
    return $this->getUrlIndexScript()."/new";
  }

  public function getUrlSaveScript(){
    return $this->getUrlIndexScript()."/save";
  }

  public function getUrlShowScript($id){
    return $this->getUrlIndexScript()."/".$id;
  }

  public function getUrlDeleteScript($id){
    return $this->getUrlShowScript($id)."/delete";
  }

  public function getUrlDeleteComfirm($id){
    return $this->getUrlDeleteScript($id)."Confirm";
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
    return $this->getUrl()."/loginverification";
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

  public function getModifyUrl() {
    return $this->getUrl()."/edit";
  }

  public function getModificationValidationUrl() {
    return $this->getUrl()."/modifyaccount";
  }
}
