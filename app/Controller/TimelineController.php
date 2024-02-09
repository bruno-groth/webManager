<?php

namespace App\Controller;

use App\Http\Request;
use App\Utils\View;

class TimelineController extends TemplateController
{
  public static function index()
  {
    $content = View::render('timeline');

    return parent::getTemplate('webManager - Timeline', $content);
  }

  public static function create(Request $request)
  {
    echo '<pre>';
    var_export($request);
    echo '</pre>';
  }
}
