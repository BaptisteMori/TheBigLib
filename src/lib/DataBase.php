<?php

class DataBase{
  private $user;
  private $pass;
  private $pdo;

  public function __construct(){
    $this->user="root";
    $this->pass="";
    $this->pdo=new PDO("mysql:host=localhost;
                      dbname=thebiglib;
                      charset=utf8",
                      $this->user,
                      $this->pass);
    $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  }

  public function getDB(){
    return $this->pdo;
  }

}
