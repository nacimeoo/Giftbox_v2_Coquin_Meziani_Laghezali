<?php
declare(strict_types=1);

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

return function (Slim\App $app): Slim\App {
    $app->get('/categories', \webui\actions\GetCategoriesAction::class)->setName('categories');
    $app->get('/categorie[/{id}]', \webui\actions\GetCategorieByIdAction::class)->setName('categorie');
    $app->get('/prestation', \webui\actions\GetPrestationAction::class)->setName('prestation');
    $app->get('/presta2', \webui\actions\GetPrestaBycate::class)->setName('presta2');
    $app->get('/home', \webui\actions\GetHomeAction::class)->setName('home');
    $app->get('/coffret', \webui\actions\GetCoffretBytheme::class)->setName('coffret');
    $app->get('/coffretDetaille', \webui\actions\GetCoffretDetaille::class)->setName('coffretDetaille');


    return $app;
    
};

