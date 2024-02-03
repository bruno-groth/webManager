<?php

namespace App\Controller;

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
    $data = [
      'name' => 'Home',
      'description' => 'WebManager empowers you to effortlessly handle user data with ease. Seamlessly manage user information, from adding new entries to updating and removing records. Experience a user-friendly interface that simplifies user administration for your web applications.'
    ];

    // home view
    $content = View::render('home', $data);

    // home view inside template
    return parent::getTemplate('webManager - Home', $content);
  }
}
