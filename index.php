<?php
require __DIR__ . '/vendor/autoload.php';

use App\Controller\HomeController;
use App\Http\Request;
use App\Http\Response;

$request = new Request();

echo '<pre>';
var_export($request);
echo '</pre>';

$response = new Response(200, 'Criado com sucesso!');

// $response->sendReponse();

// echo '<pre>';
// var_export($response);
// echo '</pre>';


?>

<?php echo (HomeController::getHome()); ?>
