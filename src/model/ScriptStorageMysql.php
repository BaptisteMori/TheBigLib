<?php
require_once("model/ScriptStorage.php");

class ScriptStorageMysql implements ScriptStorage{

  private $db;

  public function __construct($db){
    $this->db=$db;
  }

  public function read($name){
    $req="SELECT * FROM script WHERE name = :name;";
    $stmt=$this->db->prepare($req);
    $stmt->execute(array(':name'=>$name));
    return $stmt->fetch(PDO::FETCH_ASSOC);
  }

  public function readAll(){
    return "p";
  }

  public function create(Script $script){
    $req=" INSERT INTO `script` (`id`,`name`,`description`,`date`,`language`,`author`,`url`) VALUES (NULL,?,?,?,?,?,?);";
    $prepared = $this->db->prepare($req);
    return $prepared->execute(array($script->getName(),
                            $script->getDescription(),
                            "DateTime",
                            $script->getLanguage(),
                            $script->getAuthor(),
                            $script->getUrl()));
  }

}
