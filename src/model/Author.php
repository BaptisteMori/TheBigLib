<?php

class Author {

  private $name;
  private $password;
  private $email;
  private $description;

  public function __construct($name, $password, $email, $description) {
    $this->name=htmlspecialchars($name,ENT_QUOTES|ENT_SUBSTITUTE|ENT_HTML5, 'UTF-8');
    $password=htmlspecialchars($password,ENT_QUOTES|ENT_SUBSTITUTE|ENT_HTML5, 'UTF-8');
    $this->password=password_hash($password, PASSWORD_BCRYPT);
    $this->email=htmlspecialchars($email,ENT_QUOTES|ENT_SUBSTITUTE|ENT_HTML5, 'UTF-8');
    $this->description=htmlspecialchars($description,ENT_QUOTES|ENT_SUBSTITUTE|ENT_HTML5, 'UTF-8');
  }

  public function getName() {
    return htmlspecialchars($this->name,ENT_QUOTES|ENT_SUBSTITUTE|ENT_HTML5, 'UTF-8');
  }

  public function getPassword() {
    return htmlspecialchars($this->password,ENT_QUOTES|ENT_SUBSTITUTE|ENT_HTML5, 'UTF-8');
  }

  public function getEmail() {
    return htmlspecialchars($this->email,ENT_QUOTES|ENT_SUBSTITUTE|ENT_HTML5, 'UTF-8');
  }

  public function getDescription() {
    return htmlspecialchars($this->description,ENT_QUOTES|ENT_SUBSTITUTE|ENT_HTML5, 'UTF-8');
  }

  public function setPassword($password) {
    $password=htmlspecialchars($password);
    $this->password=password_hash($password, PASSWORD_BCRYPT);
  }

  public function setEmail($email) {
    $this->email=htmlspecialchars($email,ENT_QUOTES|ENT_SUBSTITUTE|ENT_HTML5, 'UTF-8');
  }

  public function setDescription($description) {
    $this->description=htmlspecialchars($description,ENT_QUOTES|ENT_SUBSTITUTE|ENT_HTML5, 'UTF-8');
  }
}

?>
