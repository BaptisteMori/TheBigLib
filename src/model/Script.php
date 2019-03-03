<?php

class Script {

  private $name;
  private $description;
  private $language;
  private $author;
  private $url;

  public function __construct($name, $description, $language, $author, $url) {
    $this->name=$name;
    $this->description=$description;
    $this->language=$language;
    $this->author=$author;
    $this->url=$url;
  }

  public function getName() {
    return $this->name;
  }

  public function getDescription() {
    return $this->description;
  }

  public function getLanguage() {
    return $this->language;
  }

  public function getAuthor() {
    $this->author;
  }

  public function getUrl() {
    return $this->url;
  }

  public function setName($name) {
    $this->name = $name;
  }

  public function setDescription($description) {
    $this->description = $description;
  }

  public function setUrl($url) {
    $this->url = $url;
  }
}

?>
