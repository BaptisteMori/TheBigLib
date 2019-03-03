<?php

class DataBase{
  private $user;
  private $pass;

  public function __construct(){
    $this->user="root";
    $this->pass="";
    $this->db=new PDO("
      mysql:host=localhost;
      dbname=thebiglib;
      charset=utf8",
      $this->user,
      $this->pass);
  }

  public function getDB(){
    return $this->db;
  }

}
