<?php
declare(strict_types=1);

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

return function (Slim\App $app): Slim\App {
    $app->get('/categories', \gift\appli\controlers\GetCategoriesAction::class);
    $app->get('/categorie/{id}', \gift\appli\controlers\GetCategorieByIdAction::class);
    $app->get('/prestation', \gift\appli\controlers\GetPrestationAction::class);

    return $app;
    
};

