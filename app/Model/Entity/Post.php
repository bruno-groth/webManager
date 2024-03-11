<?php

namespace App\Model\Entity;

use App\Database\Database;
use PDO;
use PDOStatement;

class Post
{
  private int $id;
  private string $name = '';
  private string $message = '';
  private string $created_at = '';

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

  /**
   * Retrieves Posts according to "where"
   */
  public static function getPosts(string $where = null, string $order = null, string $limit = null): array
  {
    $posts = (new Database('posts'))->select($where, $order, $limit)->fetchAll(PDO::FETCH_CLASS, Post::class);

    return $posts;
  }

  /**
   * TODO
   * Retrieves the number of posts.
   * Mostly used for pagination purposes.
   */
  public static function getPostsCounter(string $where = null, string $order = null, string $limit = null, string $fields = '*'): int
  {
    $counter = (new Database('posts'))->select($where, $order, $limit, $fields, true)->fetch();

    return $counter[0];
  }
}
