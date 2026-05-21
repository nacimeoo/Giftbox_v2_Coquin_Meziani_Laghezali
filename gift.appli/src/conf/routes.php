<?php
declare(strict_types=1);

use gift\appli\src\webui\actions\GetCategoriesAction;
use gift\appli\src\webui\actions\GetCategorieByIdAction;
use gift\appli\src\webui\actions\GetPrestationAction;
use gift\appli\src\webui\actions\GetPrestaBycate;
use gift\appli\src\webui\actions\GetHomeAction;
use gift\appli\src\webui\actions\GetCoffretBytheme;
use gift\appli\src\webui\actions\GetCoffretDetaille;

return function (Slim\App $app): Slim\App {
    $app->get('/categories', GetCategoriesAction::class)->setName('categories');
    $app->get('/categorie[/{id}]', GetCategorieByIdAction::class)->setName('categorie');
    $app->get('/prestation', GetPrestationAction::class)->setName('prestation');
    $app->get('/presta2', GetPrestaBycate::class)->setName('presta2');
    $app->get('/home', GetHomeAction::class)->setName('home');
    $app->get('/coffret', GetCoffretBytheme::class)->setName('coffret');
    $app->get('/coffretDetaille', GetCoffretDetaille::class)->setName('coffretDetaille');

    return $app;
};

