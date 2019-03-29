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
    $req="INSERT INTO `author` (`name`,`password`,`email`,`description`) VALUES (?,?,?,?);";
    $prepared = $this->db->prepare($req);
    return $prepared->execute(array($author->getName(),
                              $author->getPassword(),
                              $author->getEmail(),
                              $author->getDescription()));
  }

  public function update(Author $author) {
    $req = "UPDATE `author` SET `name`=?, `password`=?, `email`=?,`description`=? WHERE name=?;";
    $prepared = $this->db->prepare($req);
    return $prepared->execute(array($author->getName(),
                              $author->getPassword(),
                              $author->getEmail(),
                              $author->getDescription(),
                              $author->getName()));
  }
}

?>
