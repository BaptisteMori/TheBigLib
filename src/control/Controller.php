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

  public function homePage() {
    if(key_exists('account',$_SESSION)) {
        $author = $this->authorStorage->read($_SESSION['account']['id']);
    } else {
      $author = null;
    }
    $authorBuilder = new AuthorBuilder($author,$this->authorStorage);
    $account = $authorBuilder->createAuthor();
    $this->view->makeHomePage($account);
  }

  public function newAccount() {
    $this->view->makeAuthorCreationPage(new AuthorBuilder(null,$this->authorStorage));
  }

  public function saveNewAccount(array $data) {
    $authorBuilder = new AuthorBuilder($data,$this->authorStorage);
    if ($authorBuilder->isValid()) {
      $author = $authorBuilder->createAuthor();
      $a = $this->authorStorage->create($author);
      $_SESSION['account'] = $this->authorStorage->readByName($data['name']);
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
      $a = $this->authorStorage->readToken($_SESSION['account']['id']);
      if ($a['token'] === $_SESSION['account']['token']) {
        return true;
      }
    } else {
      return false;
    }
  }

  public function generateAleatoire($longueur=10) {
    $alphabet = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $res = substr(str_shuffle(str_repeat($alphabet,5)),0,$longueur);
    return $res;
  }

  public function loginVerification(array $data) {
    if (key_exists('nom',$data) && key_exists('mdp',$data) && ($data['nom'] !== "")  && ($data['mdp'] !== "")) {
      $a = $this->authorStorage->readByName($data['nom']);
      if ($a) {
        if (password_verify($data['mdp'],$a['password'])) {
          $id = $a['id'];
          $token = hash('ripemd256',$id.$this->generateAleatoire());
          $this->authorStorage->updateToken($id, $token);
          $_SESSION['account'] = array('id'=>$a['id'],'token'=>$token);
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
      $this->authorStorage->updateToken($_SESSION['account']['id'],null);
      unset($_SESSION['account']);
      header('Location: http://thebiglib/thebiglib.php');
    } else {
      header('Location: http://thebiglib/thebiglib.php/login');
    }
  }

  public function profil() {
    if ($this->accessVerify()) {
      $author = $this->authorStorage->read($_SESSION['account']['id']);
      $authorBuilder = new AuthorBuilder($author,$this->authorStorage);
      $account = $authorBuilder->createAuthor();
      $this->view->makeProfilePage($account);
    } else {
      header('Location: http://thebiglib/thebiglib.php/login');
    }
  }

  public function apropos() {
    $this->view->makeAProposPage();
  }

  public function editProfile() {
    if ($this->accessVerify()) {
      $author = $this->authorStorage->read($_SESSION['account']['id']);
      $authorBuilder = new AuthorBuilder($author,$this->authorStorage);
      $account = $authorBuilder->createAuthor();
      $this->view->makeEditProfilePage($account);
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
