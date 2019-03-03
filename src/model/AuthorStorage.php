<?php

interface AuthorStorage {

  public function read($name);

  public function readAll();

  public function create(Author $author);
}

?>
