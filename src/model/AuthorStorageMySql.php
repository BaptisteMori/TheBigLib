<?php

require_once("model/AuthorStorage.php");

class AuthorStorageMySql implements AuthorStorage {

  private $db;

  public function __construct($db) {
    $this->db=$db;
  }

  public function read($name) {
    $req="SELECT * FROM author WHERE name = :name;";
    $stmt = $this->db->prepare($req);
    $stmt->execute(array(':name'=>$name));
    return $stmt->fetch(PDO::FETCH_ASSOC);
  }

  public function readAll() {
    $req="SELECT * FROM author;";
    $this->query($req);
    return $this->db->fetchAll(PDO::FETCH_ASSOC);
  }

  public function create(Author $author) {
    $req="INSERT INTO `author` (`id`,`name`,`password`,`email`,`description`) VALUES (NULL,?,?,?,?);";
    $prepared = $this->db->prepare($req);
    return $prepared->execute(array($author->getName(),
                              $author->getPassword(),
                              $author->getEmail(),
                              $author->getDescription()));
  }
}

?>
