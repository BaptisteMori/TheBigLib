<?php
require_once("model/Script.php");

class ScriptBuilder{

  const NAME_REF="name";
  const DESCRIPTION_REF="description";
  const DATE_REF="date";
  const LANGUAGE_REF="language";
  const AUTHOR_REF="author";
  const URL_REF="url";
  const CRITICAL_REF="critique";
  const FILE_REF="file";

  private $data;
  private $error;
  private $language;
  private $storage;

  function __construct($data,$scriptStorage){
    $this->data=$data;
    $this->storage=$scriptStorage;
    $this->error=array();
    $this->languages = array('PHP','PY','HTML','CSS','JS','C','C++','C#','JAVA','PERL','RUBY','KOTLIN');
  }

  public function createScript(){
    return new Script( $this->data[$this::NAME_REF], $this->data[$this::DESCRIPTION_REF], $this->data[$this::LANGUAGE_REF], $this->data[$this::AUTHOR_REF],$this->data[$this::URL_REF]);
  }

  public function isValid(){
    if($this->data[$this::NAME_REF]!==htmlspecialchars($this->data[$this::NAME_REF], ENT_QUOTES|ENT_SUBSTITUTE|ENT_HTML5, 'UTF-8')){
      $this->error[$this::NAME_REF]="votre nom de srcipt contené des caractères spéciaux, voici une version sans eux";
      $this->data[$this::NAME_REF]=htmlspecialchars($this->data[$this::NAME_REF], ENT_QUOTES|ENT_SUBSTITUTE|ENT_HTML5, 'UTF-8');
    }elseif($this->data[$this::NAME_REF]==""){
      $this->error[$this::NAME_REF]="Votre nom de script est incomplet";
    }elseif (strlen($this->data[$this::NAME_REF])<7) {
      $this->error[$this::NAME_REF]="Votre nom de script est trop cour il doit faire au moins 7 caractères de long";
    }elseif (strlen($this->data[$this::NAME_REF])>150) {
      $this->error[$this::NAME_REF]="Votre nom de script est trop long il doit faire au plus 150 caractères de long";
    }elseif ($this->storage->read($this->data[$this::NAME_REF])!=""){
      $this->error[$this::NAME_REF]="le nom choisi est déjà pris";
    }


    if ($this->data[$this::DESCRIPTION_REF]=="") {
      $this->error[$this::DESCRIPTION_REF]="Vous n'avez pas mit de description";
    }elseif (strlen($this->data[$this::DESCRIPTION_REF])<50) {
      $this->error[$this::NAME_REF]="Votre description est trop courte elle doit faire au moins 50 caractères de long";
    }

    if($this->data[$this::LANGUAGE_REF]==""){
      $this->error[$this::LANGUAGE_REF]="Vous n'avez pas spécifié le langage";
    }elseif (!in_array(strtoupper($this->data[$this::LANGUAGE_REF]),$this->languages)) {
      $this->error[$this::LANGUAGE_REF]="le langage spécifié est inconnus";
    }
    if (count($this->error) === 0) {
      return true;
    } else {
      return false;
    }
    /*
    if (!key_exists('account',$_SESSION)){
      $this->error[$this::CRITICAL_REF]="vous n'ète pas connecté";
    }*/
  }

  public function setUrl($filename){
    $this->data[$this::URL_REF]=$filename;
  }

  public function setAuthor($id){
    $this->data[$this::AUTHOR_REF]=$id;
  }

  public function getError(){
    return $this->error;
  }

  public function getData(){
    return $this->data;
  }

  public function getLanguages(){
    return $this->languages;
  }

}
