<?php

namespace App\Database;

class Pagination
{

  private int $resultsCounter;
  private int $totalPages;
  private int $perPage;
  private int $currentPage;

  public function __construct(int $resultsCounter, int $perPage = 10, int $currentPage = 1)
  {
    $this->perPage = $perPage;
    $this->resultsCounter = $resultsCounter;
    $this->currentPage = $currentPage > 0 ? $currentPage : 1;
    $this->calculatePages();
  }

  /**
   * Calcula o número de páginas
   */
  private function calculatePages()
  {
    $this->totalPages = $this->resultsCounter >  0 ? ceil($this->resultsCounter / $this->perPage) : 1;

    $this->currentPage = $this->currentPage <= $this->totalPages ? $this->currentPage : $this->totalPages;
  }

  public function getLimit()
  {
    $offset = $this->perPage * ($this->currentPage - 1);
    return $offset . ',' . $this->perPage;
  }

  /**
   * Retorna as opções de páginas disponíveis
   */
  public function getPages()
  {
    if ($this->totalPages == 1) return [];

    $pages = [];
    for ($i = 1; $i <= $this->totalPages; $i++) {
      $pages[] =
        [
          'pagina' => $i,
          'atual' => $i == $this->currentPage
        ];
    }
  }
}
