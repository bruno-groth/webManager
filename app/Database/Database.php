<?php

namespace App\Database;

use PDO;
use PDOException;
use PDOStatement;

class Database
{
  private string $table;

  private PDO $connection;

  public function __construct(string $table = null)
  {
    $this->table = $table;
    $this->setConnection();
  }

  /**
   * Creates a connection in database.
   * Creates an instance of PDO.
   */
  private function setConnection()
  {
    try {
      $this->connection = new PDO(
        'mysql:host=mysql'  . ';dbname=' . getenv('DB_NAME'),
        getenv('DB_USER'),
        getenv('DB_PASS')
      );
      $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (PDOException $error) {

      // Production scenario is returns a error message for user and logs this error message
      echo '<pre>';
      var_export('ERROR: ' . $error);
      echo '</pre>';
      die;
    }
  }

  /**
   * Responsible for executing the sql query.
   * Replaces '?', '?', into actual values before doing.
   */
  public function executeQuery(string $query, array $params = []): PDOStatement
  {
    try {

      $statement = $this->connection->prepare($query);

      $statement->execute($params);
      return $statement;
    } catch (PDOException $error) {
      echo '<pre>';
      var_export('ERROR: ' . $error);
      echo '</pre>';
      die;
    }
  }

  /**
   * Insert data into table.
   * @param array $values [ field => value ]
   * 
   * @return int id
   */
  public function insert(array $values) //: int
  {
    $fields = array_keys($values);
    $binds = array_pad([], count($values), '?');

    $query = 'INSERT INTO ' . $this->table . ' (' . implode(',', $fields) . ') VALUES (' . implode(',', $binds) . ')';

    $this->executeQuery($query, array_values($values));

    return $this->connection->lastInsertId();
  }

  /**
   * Retrieves data from table.
   *
   *  @return PDOStatement
   */
  public function select(string $where = null, string $order = null, string $limit = null, $fields = '*', bool $count = false): PDOStatement
  {
    $where = isset($where) ? ' WHERE ' . $where : '';
    $order = isset($order) ? ' ORDER BY ' . $order : '';
    $limit = isset($limit) ? ' LIMIT ' . $limit : '';
    $fields = $count ? ' COUNT(' . $fields . ')' : $fields;

    $query = 'SELECT ' . $fields . ' FROM ' . $this->table . $where . $order . $limit;

    return $this->executeQuery($query);
  }
}
