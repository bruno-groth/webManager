<?php

namespace App\Utils;

class View
{

  private static array $vars = [];

  /**
   * Método que define as variáveis inicializadas com o sistema para todas as views.
   */
  public static function init(array $vars = [])
  {
    self::$vars = $vars;
  }

  /**
   * Retorna o conteúdo .html de um arquivo View 
   * @param string $view
   * 
   * @return string
   */
  private static function getContentView(string $view): string
  {
    $file = __DIR__ . '/../../resources/view/' . $view . '.html';

    return file_exists($file) ? file_get_contents($file) : '';
  }

  /**
   * Returns the render content of a View.
   * @param string $view
   * @param array $vars (string|int|float)[]
   * 
   * @return string
   */
  public static function render(string $view, array $vars = []): string
  {
    $contentView = self::getContentView($view);

    $vars = array_merge(self::$vars, $vars);

    // método que substitui {{}} da $contentView pelo conteudo que bater com $vars[]
    foreach (array_keys($vars) as $key) {
      $contentView = str_replace('{{ ' . $key . ' }}', $vars[$key], $contentView);
    }

    return $contentView;
  }
}
