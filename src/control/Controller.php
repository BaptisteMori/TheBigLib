<?php

class Controller{
  private $view;

  public function __construct(View $view,$scriptStorage){
    $this->view = $view;
    $this->scriptStorage=$scriptStorage;
  }
}
