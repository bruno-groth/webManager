<?php

namespace App\Http;

class Request
{

  private Router $router;
  public string $httpMethod;
  public string $uri;
  public array $headers = [];
  # URL parameters ($_GET)
  public array $queryparams = [];
  # Received variables in POST request ($_POST)
  public array $postVars = [];

  public function __construct(Router $router)
  {
    $this->router = $router;
    $this->queryparams = $_GET ?? [];
    $this->postVars = $_POST ?? [];
    $this->headers = getallheaders();
    $this->httpMethod = $_SERVER['REQUEST_METHOD'] ?? '';
    $this->setUri();
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
   * Defines the URI removing queryString.
   */
  private function setUri()
  {
    $this->uri = $_SERVER['REQUEST_URI'] ?? '';

    $xURI = explode('?', $this->uri);

    $this->uri = $xURI[0];
  }
}
