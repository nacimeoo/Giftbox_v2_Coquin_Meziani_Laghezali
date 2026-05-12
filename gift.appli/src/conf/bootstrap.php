<?php
declare(strict_types=1);
use gift\appli\utils\Eloquent;
use Slim\Views\Twig;
use Slim\Views\TwigMiddleware;

$app = \Slim\Factory\AppFactory::create();

$twig = Twig::create(__DIR__ . '/../views', ['cache' =>'path/to/cache-dir', 'auto_reload' => true]);

$twig->getEnvironment()
->addGlobal('globals', [
 'css_dir'=> 'static/css',
 'img_dir'=> 'images/img',
 'menu' => [
    ['route' => 'categories', 'text' => 'Lister les catégories']
 ]
]);
$app->add(TwigMiddleware::create($app, $twig));

$app->addRoutingMiddleware();
$app->addErrorMiddleware(true, false, false);
$app = (require_once __DIR__ . '/routes.php')($app);
Eloquent::init(__DIR__ . '/gift.db.conf.ini');

return $app;