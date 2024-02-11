<?php

namespace App\Model\Entity;

use App\Database\Database;

class Post
{
  private int $id;

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
  public function create()
  {

    $this->created_at = date('Y-m-d H:i:s');

    $database = new Database('posts');

    // executes the insert and saves the id into the post instance $this->id
    $this->id = $database->insert(
      [
        'name' => $this->name,
        'message' => $this->message,
        'created_at' => $this->created_at
      ]
    );
  }
}
