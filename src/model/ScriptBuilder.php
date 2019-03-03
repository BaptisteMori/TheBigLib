<?php
require_once("model/Script.php");

class ScrpitBuilder{

  const NAME_REF="name";
  const DESCRIPTION_REF="description";
  const DATE_REF="date";
  const LANGUAGE_REF="language";
  const AUTHOR_REF="author";
  const URL_REF="url";
  const CRITICAL_REF="critique";

  private $data;
  private $error;

  function __construct($data){
    $this->data=$data;
    $this->error=array();
    $this->languages = array('PHP','PY','HTML','CSS','JS','C','C++','C#','JAVA','PERL','RUBY','KOTLIN');
  }

  public function createScript(){
    return new Script( $this->data[$this::NAME_REF], $this->data[$this::DESCRIPTION_REF], $this->data[$this::LANGUAGE_REF], $_SESSION['account']->getAuthor());
  }

  public function isValid(){
    if($this->data[$this::NAME_REF]==""){
      $this->error[$this::NAME_REF]="Votre nom de script est incomplet";
    }elseif (strlen($this->data[$this::NAME_REF])<7) {
      $this->data[$this::NAME_REF]="Votre nom de script est trop cour il doit faire au moins 7 caractères de long";
    }elseif (strlen($this->data[$this::NAME_REF])>150) {
      $this->data[$this::NAME_REF]="Votre nom de script est trop long il doit faire au plus 150 caractères de long";
    }
    if ($this->data[$this::DESCRIPTION_REF]=="") {
      $this->error[$this::DESCRIPTION_REF]="Vous n'avez pas mit de description";
    }elseif (strlen($this->data[$this::DESCRIPTION_REF])<50) {
      $this->data[$this::NAME_REF]="Votre description est trop courte elle doit faire au moins 50 caractères de long";
    }

    if($this->data[$this::LANGUAGE_REF]==""){
      $this->error[$this::LANGUAGE_REF]="Vous n'avez pas spécifié le langage";
    }elseif (!in_array(strtoupper($this->data[$this::LANGUAGE_REF]))) {
      $this->error[$this::LANGUAGE_REF]="le langage spécifié est inconnus";
    }

    if (!key_exist('account',$_SESSION)){
      $this->error[$this::CRITICAL_REF]="vous n'ète pas connecté";
    }
  }

}
