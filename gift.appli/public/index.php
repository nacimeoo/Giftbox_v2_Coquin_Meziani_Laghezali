<?php
declare(strict_types=1);

session_start();

require_once __DIR__ . '/../src/vendor/autoload.php';

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use Slim\Factory\AppFactory;

$app = AppFactory::create();

$app->addRoutingMiddleware();
$routesFile = __DIR__ . '/../src/conf/routes.php';
if (file_exists($routesFile)) {
	require $routesFile;
}


$app->run();


