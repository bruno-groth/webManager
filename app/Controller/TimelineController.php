<?php

namespace App\Controller;

use App\Http\Request;
use App\Model\Entity\Post;
use App\Utils\View;

class TimelineController extends TemplateController
{
  public static function index(Request $request)
  {
    // TODO: REFACTOR. $request não está funcionando. Parar de usar queryparams e usar o objeto da request.
    $perPage = /* TODO: $request->perPage ?? */ 10;
    $page = $_GET['page'] ?? 1;

    $posts = self::getPostItems(perPage: $perPage, page: $page);
    // $postsCounter = Post::getPostsCounter();
    $paginate = View::render('timeline/paginate', [
      'next' => $page + 1,
      'previous' => $page == 1 ?: $page - 1
    ]);

    $content = View::render('timeline/index', [
      'posts' => $posts,
      'paginate' => $paginate
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

  private static function getPostItems(int $perPage = 10,  int $page = 1)
  {
    $items = '';
    $perPage = ($page == 0) ? 999999 : $perPage;
    $offset = ($page * $perPage) - $perPage;

    $posts = Post::getPosts(order: 'id DESC', limit: "$perPage offset $offset");

    foreach ($posts as $post) {
      $items .= View::render('timeline/timelineItem', [
        'name' => $post->name,
        'message' => $post->message,
        'created_at' => date_format(date_create($post->created_at), 'd/m/Y - H:i:s'),
      ]);
    }
    return $items;
  }
}
