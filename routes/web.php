<?php

use App\Controller\AboutController;
use App\Controller\HomeController;
use App\Http\Response;


$router->get('/', [function () {
  return new Response(200, HomeController::index());
}]);

$router->get('/sobre', [function () {
  return new Response(200, AboutController::index());
}]);

$router->get('/pagina/{idPagina}', [
  function ($idPagina) {
    return new Response(200, $idPagina);
  }
]);

$router->run()->sendResponse();
