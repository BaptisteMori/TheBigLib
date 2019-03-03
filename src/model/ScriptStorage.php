<?php

interface ScriptStorage {

  public function read($name);

  public function readAll();

  public function create(Script $script);

}
