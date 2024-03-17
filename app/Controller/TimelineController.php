<?php

namespace App\Controller;

use App\Database\Pagination;
use App\Http\Request;
use App\Model\Entity\Post;
use App\Utils\View;

class TimelineController extends TemplateController
{
  public static function index(Request $request)
  {
    $perPage = $request->queryparams['perPage'] ?? 10;
    $page = $request->queryparams['page'] ?? 1;

    $posts = self::getPostItems(perPage: $perPage, page: $page);
    $postsCounter = Post::getPostsCounter();

    $pagination = new Pagination($postsCounter, $perPage, $page);

    $paginator = $pagination->getPages();

    $paginate = View::render('timeline/paginate', [
      'next' => $page + 1,
      'previous' => $page == 1 ? $page : $page - 1,
      //'totalPages' => $totalPages
    ]);

    $content = View::render('timeline/index', [
      'posts' => $posts,
      'paginate' => $paginate
    ]);

    return parent::getTemplate('webManager - Timeline', $content);
  }

  public static function createPost(Request $request): bool
  {

    if (!isset($request->postVars['name']) || !isset($request->postVars['message'])) {
      // TODO: Tela de erro 500
      // Migrar pra um try catch disparando uma exception
      header(':', true, 500);
      return 'Internal Server Error. Please try again.';
      exit;
    }

    $post = new Post;
    $post->name = $request->postVars['name'];
    $post->message = $request->postVars['message'];

    $post->create();

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
