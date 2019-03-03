<?php

class Controller{
  private $view;

  public function __construct(View $view){
    $this->view = $view;
  }
}
