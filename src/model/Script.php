<?php

class Script {

  private $name;
  private $description;
  private $language;
  private $author;
  private $url;

  public function __construct($name, $description, $language, $author,$filename) {
    $this->name=$name;
    $this->description=$description;
    $this->language=$language;
    $this->author=$author;
    $this->url="Script/".$this->name;
    $this->filename=$filename;
  }

  public function getName() {
    return htmlspecialchars($this->name, ENT_QUOTES|ENT_SUBSTITUTE|ENT_HTML5, 'UTF-8');
  }

  public function getDescription() {
    return htmlspecialchars($this->description, ENT_QUOTES|ENT_SUBSTITUTE|ENT_HTML5, 'UTF-8');
  }

  public function getLanguage() {
    return htmlspecialchars($this->language, ENT_QUOTES|ENT_SUBSTITUTE|ENT_HTML5, 'UTF-8');
  }

  public function getAuthor() {
    return htmlspecialchars($this->author, ENT_QUOTES|ENT_SUBSTITUTE|ENT_HTML5, 'UTF-8');
  }

  public function getUrl() {
    return htmlspecialchars($this->url, ENT_QUOTES|ENT_SUBSTITUTE|ENT_HTML5, 'UTF-8');
  }

  public function getFileName() {
    return htmlspecialchars($this->filename, ENT_QUOTES|ENT_SUBSTITUTE|ENT_HTML5, 'UTF-8');
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
