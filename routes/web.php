<?php

use App\Controller\AboutController;
use App\Controller\HomeController;
use App\Controller\TimelineController;
use App\Http\Response;


$router->get('/', [function () {
  return new Response(200, HomeController::index());
}]);

$router->get('/sobre', [function () {
  return new Response(200, AboutController::index());
}]);

$router->get('/pagina/{idPagina}/{metodo}', [
  function ($idPagina, $metodo) {
    return new Response(200, 'Página: ' . $idPagina . ' Método: ' . $metodo);
  }
]);

$router->get('/timeline', [function () {
  return new Response(200, TimelineController::index());
}]);

$router->post('/timeline', [function ($request) {
  return new Response(200, TimelineController::createPost($request));
}]);


$router->run()->sendResponse();
