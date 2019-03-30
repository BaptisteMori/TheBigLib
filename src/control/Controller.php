<?php
require_once("model/script.php");
require_once("model/ScriptBuilder.php");
require_once("model/AuthorBuilder.php");


class Controller{
  private $view;

  public function __construct(View $view,$scriptStorage,$authorStorage){
    $this->view = $view;
    $this->scriptStorage=$scriptStorage;
    $this->authorStorage=$authorStorage;
  }

  public function newAccount() {
    $this->view->makeAuthorCreationPage(new AuthorBuilder(null,$this->authorStorage));
  }

  public function saveNewAccount(array $data) {
    $authorBuilder = new AuthorBuilder($data,$this->authorStorage);
    if ($authorBuilder->isValid()) {
      $author = $authorBuilder->createAuthor();
      $a = $this->authorStorage->create($author);
      $_SESSION['account'] = $this->authorStorage->read($data['name']);
      header('Location: http://thebiglib/thebiglib.php/myprofile');
    } else {
      $_SESSION['currentNewAuthor']=$authorBuilder->getData();
      $this->view->makeAuthorCreationPage($authorBuilder);
    }
  }

  public function newScript(){
    $this->view->makeScriptCreationPage(new ScriptBuilder(null,$this->scriptStorage));
  }

  public function saveNewScript(array $data){
    $scriptBuilder=new ScriptBuilder($data,$this->scriptStorage);
    if($scriptBuilder->isValid()){
      $script=$scriptBuilder->createScript();
      $a=$this->scriptStorage->create($script);
      $this->view->makeDebugPage($a);
    }else{
      $_SESSION['currentNewScript']=$scriptBuilder->getData();
      $this->view->makeScriptCreationPage($scriptBuilder);
    }
  }

  public function login() {
    $this->view->makeLoginPage();
  }

  public function accessVerify() {
    if (key_exists('account',$_SESSION)) {
      return true;
    } else {
      return false;
    }
  }

  public function loginVerification(array $data) {
    if (key_exists('nom',$data) && key_exists('mdp',$data) && ($data['nom'] !== "")  && ($data['mdp'] !== "")) {
      $a = $this->authorStorage->read($data['nom']);
      if ($a) {
        if (password_verify($data['mdp'],$a['password'])) {
          $_SESSION['account'] = $a;
          header('Location: http://thebiglib/thebiglib.php');
        } else {
          $_SERVER['PATH_INFO'] = '/login';
          $this->login();
          header('Location: http://thebiglib/thebiglib.php/login');
        }
      }
    } else {
      $_SERVER['PATH_INFO'] = '/login';
      $this->login();
      header('Location: http://thebiglib/thebiglib.php/login');
    }
  }

  public function logout() {
    if ($this->accessVerify()) {
      unset($_SESSION['account']);
      header('Location: http://thebiglib/thebiglib.php');
    } else {
      header('Location: http://thebiglib/thebiglib.php/login');
    }
  }

  public function profil() {
    if ($this->accessVerify()) {
      $this->view->makeProfilePage();
    } else {
      header('Location: http://thebiglib/thebiglib.php/login');
    }
  }

  public function apropos() {
    $this->view->makeAProposPage();
  }

  public function editProfile() {
    if ($this->accessVerify()) {
      $this->view->makeEditProfilePage();
    } else {
      header('Location: http://thebiglib/thebiglib.php/login');
    }
  }

  public function modifyAccount(array $data) {
    $a = $this->authorStorage->read($data['name']);
    $this->authorBuilder = new AuthorBuilder($data, $this->authorStorage);
    $author = $this->authorBuilder->createAuthor();
    $this->authorStorage->update($author);
    $_SESSION['account'] = $this->authorStorage->read($data['name']);
    header('Location: http://thebiglib/thebiglib.php/myprofile');
  }

}
