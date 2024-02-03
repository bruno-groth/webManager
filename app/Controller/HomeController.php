<?php

namespace App\Controller;

use \App\Utils\View;


class HomeController
{

  /**
   * Retorna o conteúdo (view) da home.
   * 
   * @return string
   */
  public static function getHome(): string
  {
    return View::render('home');
  }
}
