<?php
require_once("model/ScriptStorage.php");
require_once("model/ScriptStorageFile.php");

class ScriptStorageMysql implements ScriptStorage{

  private $db;

  public function __construct($db){
    $this->db=$db;
    $this->storeFilenam=new ScriptStorageFile();
  }

  public function readByName($id){
    $req="SELECT * FROM script WHERE name = :name;";
    $stmt=$this->db->prepare($req);
    $stmt->execute(array(':name'=>$id));
    return $stmt->fetch(PDO::FETCH_ASSOC);
  }

  public function read($id){
    $req="SELECT * FROM script WHERE id = :id;";
    $stmt=$this->db->prepare($req);
    $stmt->execute(array(':id'=>$id));
    return $stmt->fetch(PDO::FETCH_ASSOC);
  }

  public function readAll(){
    $req="SELECT * FROM script;";
    $stmt=$this->db->prepare($req);
    $stmt->execute();
    return $stmt->fetchall(PDO::FETCH_ASSOC);
  }

  public function create(Script $script){
    $req=" INSERT INTO `script` (`name`,`description`,`date`,`language`,`author`,`url`) VALUES (?,?,?,?,?,?);";
    $prepared = $this->db->prepare($req);
    return $prepared->execute(array($script->getName(),
                            $script->getDescription(),
                            date('Y-m-d H:i:s'),
                            $script->getLanguage(),
                            $script->getAuthor(),
                            $script->getUrl()));
  }

  public function delete($id){

  }

}
