 
<?php

namespace App\Database;

use PDO;
use PDOException;

class Database
{
  const HOST = getenv('DB_HOST');
  const NAME = getenv('DB_NAME');
  const USER = getenv('DB_USER');
  const PASS = getenv('DB_PASS');

  private string $table;

  private PDO $connection;

  public function __construct(string $table = null)
  {
    $this->table = $table;
    $this->setConnection();
  }

  /**
   * Creates a connection in database, creates an instance of PDO.
   */
  private function setConnection()
  {
    try {
      $this->connection = new PDO('mysql:host=' . self::HOST . ';dbname=' . self::NAME, self::USER, self::PASS);
      $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (PDOException $error) {

      // Production scenario is returns a error message for user and logs this error message
      die('ERROR: ' . $error->getMessage());
    }
  }
}
