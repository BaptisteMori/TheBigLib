<?php
require_once("model/ScriptStorage.php");

class ScriptStorageMysql implements ScriptStorage{

  public function __construct($db){
    $this->db=$db;

  }

  public function read($name){
    $req=" SELECT * FROM script WHERE name = ?;";
    $this->query($req);
    return $db->fetch(PDO::FETCH_ASSOC);
  }

  public function readAll(){
    return "p";
  }

  public function create(Script $script){
    $req=" INSERT INTO script VALUES (?,?,?,?,?,?);";
    $this->db->prepare($req);
    return $this->db->execute(array($script->getName(),
                            $script->getDescription(),
                            new \DateTime(),
                            $script->getLanguage(),
                            $script->getAuthor(),
                            $script->getUrl()));
  }

}
