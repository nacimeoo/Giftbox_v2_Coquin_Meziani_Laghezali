<?php
declare(strict_types=1);

session_start();

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

$app = \Slim\Factory\AppFactory::create();
$app->addRoutingMiddleware();
$app = (require_once __DIR__ . '/routes.php')($app);

return $app;