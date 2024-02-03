<?php

use App\Controller\HomeController;

require __DIR__ . '/vendor/autoload.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>WebManager</title>
</head>

<body>

  <?php echo (HomeController::getHome()); ?>
</body>

</html>