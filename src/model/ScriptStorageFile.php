<?php

class ScriptStorageFile{

  const PATH_REF="../Scripts";

  public function __construct(){

  }

  public function generateAleatoire($longueur=10) {
    $alphabet = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $res = substr(str_shuffle(str_repeat($alphabet,5)),0,$longueur);
    return $res;
  }

  public function makeName($name){
    return hash('ripemd256',$name.$this->generateAleatoire());
  }

  public function store($filename,$file){
    return move_uploaded_file($file['tmp_name'],$filename);
  }

  public function delete($filename){

  }

  public function getScript($filename){

  }
}
