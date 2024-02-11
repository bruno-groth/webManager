<?php

namespace App\Controller;

use App\Http\Request;
use App\Model\Entity\Post;
use App\Utils\View;

class TimelineController extends TemplateController
{
  public static function index()
  {
    $content = View::render('timeline');

    return parent::getTemplate('webManager - Timeline', $content);
  }

  public static function createPost(Request $request)
  {

    if (!isset($_POST['name']) && !isset($_POST['message'])) {
      die;
    }

    $post = new Post;
    $post->name = $_POST['name'];
    $post->message = $_POST['message'];

    $post->create();

    echo '<pre>';
    var_export($post);
    echo '</pre>';
  }
}
