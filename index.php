<?php
require __DIR__ . '/vendor/autoload.php';
define('URL', 'http://localhost/app');

use App\Controller\HomeController;
use App\Http\Request;
use App\Http\Response;
use App\Http\Router;

$router = new Router(URL);

$router->get('/', [function () {
  return new Response(200, HomeController::getHome());
}]);

$router->run();
//$router->run()->sendResponse();

?>

<?php echo (HomeController::getHome()); ?>
