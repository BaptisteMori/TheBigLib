<?php

class Author {

  private $name;
  private $password;
  private $email;
  private $description;

  public function __construct($name, $password, $email, $description) {
    $this->name=htmlspecialchars($name);
    $password=htmlspecialchars($password);
    $this->password=password_hash($password, PASSWORD_BCRYPT);
    $this->email=htmlspecialchars($email);
    $this->description=htmlspecialchars($description);
  }

  public function getName() {
    return $this->name;
  }

  public function getPassword() {
    return $this->password;
  }

  public function getEmail() {
    return $this->email;
  }

  public function getDescription() {
    return $this->description;
  }

  public function setPassword($password) {
    $password=htmlspecialchars($password);
    $this->password=password_hash($password, PASSWORD_BCRYPT);
  }

  public function setEmail($email) {
    $this->email=$email;
  }

  public function setDescription($description) {
    $this->description=$description;
  }
}

?>
