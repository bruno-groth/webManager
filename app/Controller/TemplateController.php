<?php

namespace App\Controller;

use \App\Utils\View;


class TemplateController
{

  /**
   * Returns the layout's header page.
   * 
   * @return string
   */
  private static function getHeader(): string
  {
    return View::render('layout/header');
  }

  /**
   * Returns the layout's footer page. 
   */
  private static function getFooter(): string
  {
    return View::render('layout/footer');
  }

  /**
   * Retorna o conteúdo (view) do Template do projeto.
   * 
   * @return string
   */
  public static function getTemplate(string $title, string $content): string
  {
    $data = [
      'name' => 'WebManager',
      'description' => 'WebManager empowers you to effortlessly handle user data with ease. Seamlessly manage user information, from adding new entries to updating and removing records. Experience a user-friendly interface that simplifies user administration for your web applications.'
    ];

    return View::render('layout/template', [
      'title' => $title,
      'header' => self::getHeader(),
      'content' => $content,
      'footer' => self::getFooter()
    ]);
  }
}
