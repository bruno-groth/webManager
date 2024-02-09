<?php

namespace App\Model\Entity;

class Timeline
{

  public function __construct(
    private string $name,
    private string $message
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
}
