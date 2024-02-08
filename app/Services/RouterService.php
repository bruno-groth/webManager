<?php

namespace App\Services;

class RouterService
{
  /**
   * Método que coleta os parâmetros dinâmicos da rota
   * 
   * TODO: corrigir e utilizar
   */
  public function getRouteParams(string $route)
  {
    // variável com padrão de regex aplicado pra buscar dentro da string da rota recebida
    $patternRegularVariable = '/{(.*?)}/';

    if (preg_match_all($patternRegularVariable, $route, $matches)) {
      // Precisa isso?
      $route = preg_replace($patternRegularVariable, '(.*?)', $route);

      $matches = $matches[1];
    }
    return [$matches, $route];
  }
}
