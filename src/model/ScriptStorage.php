<?php

interface ScriptStorage {

  public function read($id);

  public function readAll();

  public function create(Script $script);

  public function delete($id);

}
