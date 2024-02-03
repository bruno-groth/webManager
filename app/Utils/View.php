<?php

namespace App\Utils;

class View

{

  /**
   * Retorna o conteúdo .html de um arquivo View 
   * @param string $view
   * 
   * @return string
   */
  private static function getContentView($view): string
  {
    $file = __DIR__ . '/../../resources/view/' . $view . '.html';

    return file_exists($file) ? file_get_contents($file) : '';
  }

  /**
   * Returns the render content of a View.
   * @param string $view
   * 
   * @return string
   */
  public static function render($view): string
  {
    $contentView = self::getContentView($view);

    return $contentView;
  }
}
