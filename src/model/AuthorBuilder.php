<?php

require_once("model/Author.php");

class AuthorBuilder {

  const NAME_REF="name";
  const PASSWORD_REF="password";
  const EMAIL_REF="email";
  const DESCRIPTION_REF="description";

  private $data;
  private $error;

  function __construct($data) {
    $this->data=$data;
    $this->error=array();
  }

  public function createAuthor() {
    return new Author($this->data[$this::NAME_REF],$this->data[$this::PASSWORD_REF],$this->data[$this::EMAIL_REF],$this->data[$this::DESCRIPTION_REF]);
  }

  public function isValid() {
    if($this->data[$this::NAME_REF] == "") {
      $this->error[$this::NAME_REF]="Veuillez entrer un nom";
    } else if(strlen($this->data[$this::NAME_REF])<7) {
      $this->error[$this::NAME_REF]="Le nom doit faire au moins 7 caractères";
    } else if(strlen($this->data[$this::NAME_REF])>50) {
      $this->error[$this::NAME_REF]="Le nom est trop long, maximum 50 caractères";
    }

    if($this->data[$this::PASSWORD_REF] == "") {
      $this->error[$this::PASSWORD_REF]="Veuillez entrer un mot de passe";
    } else if(strlen($this->data[$this::PASSWORD_REF])<8) {
      $this->error[$this::PASSWORD_REF]="Le mot de passe doit faire au moins 8 caractères";
    } else if(strlen($this->data[$this::PASSWORD_REF])>255) {
      $this->error[$this::PASSWORD_REF]="Le mot de passe est trop long, maximum 255 caractères";
    }

    if($this->data[$this::EMAIL_REF] == "") {
      $this->error[$this::EMAIL_REF]="Veuillez indiquer votre adresse email";
    } else if(strlen($this->data[$this::EMAIL_REF])>100) {
      $this->error[$this::EMAIL_REF]="L'email est trop long, maximum 100 caractères";
    }
    if(!filter_var($this->data[$this::EMAIL_REF],FILTER_VALIDATE_EMAIL)) {
      $this->error[$this::EMAIL_REF]="Format invalde, exemple: aaa@bbb.fr";
    }
  }

  public function getData() {
    return $this->data;
  }

  public function getError() {
    return $this->error;
  }
}

?>
