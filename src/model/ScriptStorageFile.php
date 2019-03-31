<?php

class ScriptStorageFile{

  const PATH_REF="../ressources/Scripts";

  public function __construct(){

  }

  public function generateAleatoire($longueur=10) {
    $alphabet = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $res = substr(str_shuffle(str_repeat($alphabet,5)),0,$longueur);
    return $res;
  }

  public function makeName($name){
    $token = hash('ripemd256',$id.$this->generateAleatoire());
  }

  public function store($filename,$file){

  }

  public function delete($filename){

  }

  public function getScript($filename){

  }
}
