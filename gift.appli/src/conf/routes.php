<?php
declare(strict_types=1);

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

return function (Slim\App $app): Slim\App {
    $app->get('/categories', \gift\appli\controlers\GetCategoriesAction::class)->setName('categories');
    $app->get('/categorie[/{id}]', \gift\appli\controlers\GetCategorieByIdAction::class)->setName('categorie');
    $app->get('/prestation', \gift\appli\controlers\GetPrestationAction::class)->setName('prestation');
    $app->get('/presta2', \gift\appli\controlers\GetPrestaBycate::class)->setName('presta2');
    $app->get('/home', \gift\appli\controlers\GetHomeAction::class)->setName('home');
    $app->get('/coffret', \gift\appli\controlers\GetCoffretBytheme::class)->setName('coffret');
    $app->get('/coffretDetaille', \gift\appli\controlers\GetCoffretDetaille::class)->setName('coffretDetaille');


    return $app;
    
};

