<?php

namespace App\Controller;

use App\Model\Entity\Organization;
use \App\Utils\View;

class HomeController extends TemplateController
{

  /**
   * Retorna o conteúdo (view) da home.
   * 
   * @return string
   */
  public static function getHome(): string
  {

    $organization = new Organization();

    $data = [
      'name' => $organization->name,
      'description' => $organization->description,
      'site' => $organization->site
    ];

    // home view
    $content = View::render('home', $data);

    // home view inside template
    return parent::getTemplate('webManager - Home', $content);
  }
}
