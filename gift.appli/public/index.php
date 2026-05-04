<?php
declare(strict_types=1);

session_start();

require_once __DIR__ . '/../src/vendor/autoload.php';

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
$app = \Slim\Factory\AppFactory::create();
$app->addRoutingMiddleware();
$app = (require_once __DIR__ . '/../src/conf/routes.php')($app);

$app->run();


