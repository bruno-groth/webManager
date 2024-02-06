<?php

namespace App\Controller;

use App\Http\Response;
use App\Utils\View;

class AboutController extends TemplateController
{
  /**
   * Retorna o conteúdo (view) da home.
   * 
   * @return string
   */
  public static function index(): string
  {

    $content = View::render('about');

    return parent::getTemplate('webManager - Sobre', $content);
  }
}
