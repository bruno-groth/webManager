<?php

namespace App\Model\Entity;

use App\Database\Database;

class Post
{

  public function __construct(
    private string $name = '',
    private string $message = '',
    private string $created_at = ''
  ) {
  }

  /**
   * Magic Method Auto getter
   */
  public function __get($name)
  {
    if (property_exists($this, $name)) {
      return $this->$name;
    }
  }

  /**
   * Magic Method Auto setter
   */
  public function __set($name, $value)
  {
    if (property_exists($this, $name)) {
      $this->$name = $value;
    }
  }

  /**
   * Creates a new Post.
   */
  public function create(Post $post)
  {
    $this->created_at = date('Y-m-d H:i:s');

    $database = new Database('posts');

    // Checking instance of database
    echo '<pre>';
    var_export($database);
    echo '</pre>';
  }
}
