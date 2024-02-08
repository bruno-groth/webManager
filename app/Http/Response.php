<?php

namespace App\Http;

/**
 * Entidade que define o valor que será retornado para o cliente que fez a chamada.
 */
class Response
{

  private int $httpCode = 200;
  private array $headers = [];
  private string $contentType = 'text/html';
  private mixed $content;

  public function __construct(int $httpCode, mixed $content, string $contentType = 'text/html')
  {
    $this->httpCode = $httpCode;
    $this->content = $content;
    $this->setContentType($contentType);
  }

  public function setContentType(string $contentType): void
  {
    $this->contentType = $contentType;
    $this->addHeader('ContentType', $contentType);
  }

  public function addHeader($key, $value)
  {
    $this->headers[$key] = $value;
  }

  /**
   * Método responsável por enviar os headers para o navegador
   */
  private function sendHeaders(): void
  {
    http_response_code($this->httpCode);

    foreach ($this->headers as $key => $value) {
      header($key . ': ' . $value);
    }
  }

  public function sendResponse(): mixed
  {
    // ENVIA OS HEADERS PARA O BROWSER
    $this->sendHeaders();

    // IMPRIME O CONTEÚDO
    switch ($this->contentType) {
      case 'text/html':
        echo $this->content;
        exit;
        break;
    }
  }
}
