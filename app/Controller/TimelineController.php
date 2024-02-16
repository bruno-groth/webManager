<?php

namespace App\Controller;

use App\Http\Request;
use App\Model\Entity\Post;
use App\Utils\View;

class TimelineController extends TemplateController
{
  public static function index()
  {
    $posts = Post::getPosts();

    $content = View::render('timeline', [
      'posts' => self::getPostItems()
    ]);

    return parent::getTemplate('webManager - Timeline', $content);
  }

  public static function createPost(Request $request): bool
  {

    if (!isset($_POST['name']) && !isset($_POST['message'])) {
      die;
    }

    $post = new Post;
    $post->name = $_POST['name'];
    $post->message = $_POST['message'];

    $post->create();

    // TODO: fazer o apache aceitar querystring sem dar 404
    header('location: /app/timeline?status=success');
    exit;

    return true;
  }

  private static function getPostItems()
  {
    $items = '';

    $results = Post::getPosts(null, 'id DESC');

    foreach ($results as $post) {
      // TODO: Criar componente com esses dados
      $items .= $post->name . $post->message;
    }
    return $items;
  }
}
