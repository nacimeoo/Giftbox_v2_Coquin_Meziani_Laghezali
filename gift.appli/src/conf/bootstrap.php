<?php
declare(strict_types=1);
use gift\appli\utils\Eloquent;

$app = \Slim\Factory\AppFactory::create();
$app->addRoutingMiddleware();
$app = (require_once __DIR__ . '/routes.php')($app);
Eloquent::init(__DIR__ . '/gift.db.conf.ini');

return $app;